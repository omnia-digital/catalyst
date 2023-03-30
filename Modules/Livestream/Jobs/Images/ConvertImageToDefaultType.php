<?php

namespace Modules\Livestream\Jobs\Images;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Image;
use Modules\Livestream\Services\ImageService;

class ConvertImageToDefaultType implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $_image_id;

    private $_imageService;

    /**
     * Create a new job instance.
     *
     * @param  ImageService  $imageService
     */
    public function __construct($image_id, ImageService $imageService = null)
    {
        $this->_image_id = $image_id;
        if (is_null($imageService)) {
            $this->_imageService = new ImageService;
        } else {
            $this->_imageService = $imageService;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $image = Image::findOrFail($this->_image_id);
        $this->_imageService->convertImage($image);
    }
}
