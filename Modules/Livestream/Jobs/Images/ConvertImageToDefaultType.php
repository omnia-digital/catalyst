<?php

namespace App\Jobs\Images;

use App\Image;
use App\Services\ImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertImageToDefaultType implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $_image_id;

    private $_imageService;

    /**
     * Create a new job instance.
     *
     * @param $image_id
     * @param ImageService $imageService
     */
    public function __construct($image_id, ImageService $imageService = null)
    {
        $this->_image_id = $image_id;
        if (is_null($imageService)) {
            $this->_imageService = new ImageService();
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
