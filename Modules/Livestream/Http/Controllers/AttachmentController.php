<?php

namespace Modules\Livestream\Http\Controllers;

use Modules\Livestream\Models\Media;

class AttachmentController extends Controller
{
    public function download(Media $media)
    {
        $download = $media->downloads()->whereDay('created_at', now())->first();

        if (! is_null($download)) {
            $download->count++;
            $download->save();
        } else {
            $media->downloads()->create([
                'count' => 1,
            ]);
        }

        return redirect($media->getUrl());
    }

    public function staticDownload(Media $media)
    {
        $download = $media->downloads()->whereDay('created_at', now())->first();

        if (! is_null($download)) {
            $download->count++;
            $download->save();
        } else {
            $media->downloads()->create([
                'count' => 1,
            ]);
        }

        return redirect($media->getStaticUrl());
    }
}
