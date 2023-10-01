<?php

namespace App\Traits\Team;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasLogo
{
    /**
     * Update the company's logo.
     *
     * @return void
     */
    public function updateLogo(UploadedFile $photo)
    {
        tap($this->logo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'logo_path' => $photo->storePublicly(
                    'logos', ['disk' => $this->logoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->logoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the company's logo.
     *
     * @return void
     */
    public function deleteLogo()
    {
        Storage::disk($this->logoDisk())->delete($this->logo_path);

        $this->forceFill([
            'logo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the company's logo.
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path
            ? Storage::disk($this->logoDisk())->url($this->logo_path)
            : $this->defaultLogoUrl();
    }

    /**
     * Get the disk that logo should be stored on.
     *
     * @return string
     */
    protected function logoDisk()
    {
        return 's3';
    }

    /**
     * Get the logo URL if no logo has been uploaded.
     *
     * @return string
     */
    protected function defaultLogoUrl()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF&size=128';
    }
}
