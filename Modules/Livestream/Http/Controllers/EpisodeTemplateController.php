<?php

namespace Modules\Livestream\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Livestream\Episode;
use Modules\Livestream\EpisodeTemplate;
use Modules\Livestream\Http\Requests\EpisodeTemplateRequest;
use Modules\Livestream\Interactions\DeleteEpisodeTemplateThumbnail;
use Modules\Livestream\Interactions\UpdateEpisodeTemplateThumbnail;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Omnia;

/**
 * Class EpisodeTemplateController
 */
class EpisodeTemplateController extends LivestreamController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     *
     * @throws Exception
     */
    public function index()
    {
        if (!empty($this->_livestreamAccount)) {
            $episodeTemplates = $this->_livestreamAccount->episodeTemplates;
            $episodeTemplates->load('LivestreamAccount');
        } else {
            throw new ValidationException("Can't find livestream Account, which is necessary to get Episode Templates");
        }

        return $episodeTemplates;
    }

    /**
     * Store a newly created Episode in storage.
     *
     *
     * @return Response
     */
    public function store(EpisodeTemplateRequest $request)
    {
        $request = $request->all();
        $episode = new Episode;

        if (!empty($request['episode'])) {
            $episode->fill($request['episode']);
        }
        $episodeTemplate = EpisodeTemplate::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'template' => $episode,
            'livestream_account_id' => $this->_livestreamAccount->id,
        ]);

        return $episodeTemplate;
    }

    /**
     * Show the form for creating a new episode.
     *
     * @return Response
     */
    public function create()
    {
        return view('livestream::episodeTemplate/create');
    }

    /**
     * Display the specified resource.
     *
     *
     * @return EpisodeTemplate
     */
    public function show(EpisodeTemplate $episodeTemplate)
    {
        $isDefault = false;

        if ($this->_livestreamAccount->default_episode_template_id == $episodeTemplate->id) {
            $isDefault = true;
        }

        $episodeTemplate->isDefault = $isDefault;

        return $episodeTemplate;
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return EpisodeTemplate
     */
    public function update(EpisodeTemplateRequest $request, EpisodeTemplate $episodeTemplate)
    {
        $request = $request->all();
        $templateData['title'] = $request['title'];
        $templateData['description'] = $request['description'];
        $episode = $episodeTemplate->template;
        $episode->fill($request['episode']);
        $episodeTemplate->title = $templateData['title'];
        $episodeTemplate->description = $templateData['description'];
        $episodeTemplate->template = $episode;
        $episodeTemplate->livestream_account_id = $this->_livestreamAccount->id;
        $episodeTemplate->save();

        return $episodeTemplate;
    }

    /**
     * Remove the LivestreamAccount and associated files from storage.
     *
     * @param int $id
     * @return int
     *
     * @throws Exception
     */
    public function destroy($id)
    {
        try {
            // Check to make sure its not the default
            if ($id == EpisodeTemplate::getSystemDefault()->id) {
                throw new Exception('Cannot Delete the System-wide Episode Template... as that could implode the universe....');
            } else {
                if ($this->_livestreamAccount->default_episode_template_id != $id) {
                    $count = EpisodeTemplate::destroy($id);
                    flash('Episode deleted: ' . $count);

                    return $count;
                    //		    return redirect('/livestream');
                } else {
                    //	        throw new Exception("You must assign another Episode Template as the <b>Default</b> before you can delete this one");
                    throw new Exception('You must assign another Episode Template as the <b>Default</b> before you can delete this one');
                    //		    return Redirect::back()->with( [
                    //			    'flash.title'   => "Cannot Delete Default Episode Template",
                    //			    'flash.message' => "You must assign another Episode Template as the <b>Default</b> before you can delete this one",
                    //			    'flash.level'   => 'danger'
                    //		    ] );
                }
            }
        } catch (Exception $e) {
//            $data = ['errors' => $e->getMessage()];
            throw $e;
        }
    }

    /**
     * Change the Default Episode Template on this Livestream Account
     *
     *
     * @return JsonResponse
     */
    public function changeDefaultEpisodeTemplate($id)
    {
        $this->_livestreamAccount->default_episode_template_id = (int)$id;
        $this->_livestreamAccount->save();

        $response = [
            'success' => true,
            'data' => [],
        ];

        return response()->json($response);
    }

    /**
     * Update the thumbnail on given Episode
     *
     *
     * @return mixed
     */
    public function storeThumbnail(Request $request, EpisodeTemplate $episodeTemplate)
    {
        return Omnia::interact(UpdateEpisodeTemplateThumbnail::class, [$episodeTemplate, $request->all()]);
    }

    /**
     * Delete the thumbnail file and remove from Episode
     *
     *
     * @return mixed
     */
    public function removeThumbnail(Episode $episodeTemplate)
    {
        return Omnia::interact(DeleteEpisodeTemplateThumbnail::class, [$episodeTemplate]);
    }
}
