<?php

namespace Modules\Livestream\Services;

use Exception;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;
use Modules\Livestream\Image;
use Modules\Livestream\Jobs\Images\ConvertImageToDefaultType;

/**
 * Class ImageService
 *
 * The purpose of this class is to handle the interactions between Image objects and their physical file counterparts (both in cache and source storage). That means saving, retrieval, and any type of manipulation
 */
class ImageService
{
    /**
     * @var Server
     */
    private $_server;

    /**
     * @var FilesystemAdapter
     */
    private $_source_disk;

    /**
     * @var string
     */
    private $_source_disk_name;

    /**
     * @var FilesystemAdapter
     */
    private $_cache_disk;

    /**
     * @var string
     */
    private $_cache_disk_name;

    /**
     * ImageService constructor.
     *
     * @param  null  $source_disk
     * @param  null  $cache_disk
     */
    public function __construct($source_disk = null, $cache_disk = null)
    {
        if (is_null($cache_disk)) {
            $this->_cache_disk_name = config('app.default_images_cache_disk_name');
            $this->_cache_disk = Storage::disk($this->_cache_disk_name);
        }

        if (is_null($source_disk)) {
            $this->_source_disk_name = config('app.default_images_source_disk_name');
            $this->_source_disk = Storage::disk($this->_source_disk_name);
        } elseif (is_string($source_disk)) {
            $this->_source_disk_name = $source_disk;
            $this->_source_disk = Storage::disk($this->_source_disk_name);
        } elseif ($source_disk instanceof \League\Flysystem\Filesystem) {
            $this->_source_disk = $source_disk;
        }

        if (is_null($source_disk)) {
            $this->_source_disk_name = config('app.default_images_source_disk_name');
            $this->_source_disk = Storage::disk($this->_source_disk_name);
        } elseif (is_string($source_disk)) {
            $this->_source_disk_name = $source_disk;
            $this->_source_disk = Storage::disk($this->_source_disk_name);
        } elseif ($source_disk instanceof \League\Flysystem\Filesystem) {
            $this->_source_disk = $source_disk;
        }

        $this->_server = $this->_initializeServer($this->_source_disk, $this->_cache_disk);
    }

    /**
     * Create an Image Object and save the image file
     * I want to handle if just the $imageData is passed, or if all of the data is passed
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     *
     * @throws Exception
     */
    public function create($imageFile, $imageData = null, array $storageOptions = [])
    {
        try {
            if (is_array($imageData)) {
                $imageData = collect($imageData);
            } elseif (is_string($imageData) || empty($imageData)) {
                $imageData = collect();
            } elseif (! $imageData instanceof Collection) {
                throw new Exception('Image Data must be an array or Collection');
            }

            if ($imageData->has('file_path') === false) {
                throw new Exception('Must have the file_path in order to create the image file');
            }
//            $imageData->put('file_path',$imageData->get('file_path'));

//            $imageData->put('storage_source','s3'); // @TODO [Josh] - need to figure this out somehow and only put it if it's going to be different from the default images storage source

            if (empty($storageOptions['disk'])) {
                $storageOptions['disk'] = $this->_source_disk_name;
            }

            if ($imageFile instanceof File || $imageFile instanceof UploadedFile) {
                if (! $imageData->has('full_file_name')
                    && (! $imageData->has('file_name') && ! $imageData->has('file_type'))) {
                    $imageData->put('full_file_name', $this->generateFullFileName($imageFile));
                }
            }

            // If instance of File, convert to UploadedFile
//            // @TODO [Josh] - not sure if I even need this yet
//            if ($imageFile instanceof File) {
//                // We must assume that this file already exists within the storage, and that file_path is in the imageData
//                $imageFile = new UploadedFile($imageData->get('file_path'),$imageData->get('file_name'));
//            }

            // Store UploadedFile
            if ($imageFile instanceof UploadedFile) {
                $fileUploadedSuccess = $imageFile->storePubliclyAs($imageData->get('file_path'), $imageData->get('full_file_name'), $storageOptions);
                if ($fileUploadedSuccess === false) {
                    throw new Exception('File failed to upload!');
                }
            } else {
                // @TODO [Josh] - this is something we may want to change later so it can be a different type of file instance
                throw new Exception('Image File must be an instance of File or UploadedFile!');
            }

            if ($imageData instanceof Collection) {
                $imageData = $imageData->toArray();
            }

            try {
                $image = Image::create($imageData);
            } catch (Exception $e) {
                $this->_source_disk->delete($imageData->get('file_path'));
            }

            if ($image->file_type !== config('app.default_image_type')) {
//                dispatch(new ConvertImageToDefaultType($image->id));
            }

            return $image;
        } catch (Exception $e) {
            $msg = 'Cannot create Image: ' . $e->getMessage();
            Log::error($msg);
            throw new Exception($msg);
        }
    }

    public function convertImage($image, $newType = null)
    {
        // @TODO [Josh] - need to come back to this and fix it so we can convert images easily

        if (is_null($newType)) {
            $newType = config('app.default_image_type');
        }

//        $manager = new ImageManager(array('driver' => 'imagick'));
//        $imagePath = $this->_server->makeImage($image->full_file_path,[]);
//        $manager->make($imagePath)->encode('png');
    }

    /**
     * @param  File  $file
     * @return string
     *
     * @throws Exception
     */
    public function generateFullFileName($file)
    {
        if (! $file instanceof UploadedFile && ! $file instanceof File) {
            throw new Exception(__FUNCTION__ . ': File must be an instance of File or Uploaded File');
        }

        return $this->generateFileName() . '.' . $file->extension();
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function generateFileName()
    {
        return time() . uniqid();
    }

    public function update($data)
    {
        return Image::update($data);
    }

    public function show($imageId, $params = [])
    {
        $image = Image::findOrFail($imageId);

        return $this->_server->getImageResponse($image->full_file_path, $params);
    }

    public function deleteImage($image)
    {
        if (is_int($image)) {
            $image = Image::findOrFail($image);
        }
        $deletedFiles = false;
        $imageDeleted = false;
        $file_exists = false;
        try {
            $this->_server->deleteCache($image->full_file_path);
            $file_exists = $this->_source_disk->has($image->full_file_path);
            if ($file_exists === true) {
                $deletedFiles = $this->_source_disk->delete($image->full_file_path);
            }
        } catch(Exception $e) {
            $deletedFiles = false;
            Log::error('Unable to Delete Image files: ' . $e->getMessage());
        }

        if ($deletedFiles === true || $file_exists !== true) {
            $imageDeleted = $image->delete();
        }

        return $imageDeleted;
    }

    /**
     * @return Server
     */
    private function _initializeServer($source_disk, $cache_disk)
    {
        return ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $source_disk->getDriver(),
            'cache' => $cache_disk->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'images',
        ]);
    }

    /**
     * Serialization
     */
    public function __sleep()
    {
        $serializeVars = [
            '_source_disk_name',
            '_cache_disk_name',
        ];

        return $serializeVars;
    }

    /**
     * De-serialization
     */
    public function __wakeup()
    {
        if (! empty($this->_source_disk_name)) {
            $this->_source_disk = Storage::disk($this->_source_disk_name);
        }
        if (! empty($this->_cache_disk_name)) {
            $this->_cache_disk = Storage::disk($this->_cache_disk_name);
        }
        $this->_server = $this->_initializeServer($this->_source_disk, $this->_cache_disk);

        return $this;
    }
}
