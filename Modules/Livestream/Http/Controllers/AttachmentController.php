<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download(Media $media)
    {
        $download = $media->downloads()->whereDay('created_at', now())->first();

        if(!is_null($download)) {
            $download->count++;
            $download->save();
        } else {
            $media->downloads()->create([
                'count' => 1
            ]);
        }

        return redirect($media->getUrl());
    }

    public function staticDownload(Media $media)
    {
        $download = $media->downloads()->whereDay('created_at', now())->first();

        if(!is_null($download)) {
            $download->count++;
            $download->save();
        } else {
            $media->downloads()->create([
                'count' => 1
            ]);
        }

        return redirect($media->getStaticUrl());
    }
}
