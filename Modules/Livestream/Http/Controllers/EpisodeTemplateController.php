<?php

namespace App\Http\Controllers;

use App\Omnia;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use App\Episode;
use Illuminate\Http\Request;
use App\EpisodeTemplate;
use App\Http\Requests;
use App\Http\Requests\EpisodeRequest;
use App\Http\Requests\EpisodeTemplateRequest;
use App\Http\Requests\S3Request;
use App\Http\Controllers\LivestreamController;
use App\Interactions\DeleteEpisodeTemplateThumbnail;
use App\Interactions\UpdateEpisodeTemplateThumbnail;
use App\LivestreamAccount;
use App\LivestreamApplication;
use App\Player;
use App\WowzaMediaServer;
use App\WowzaVhost;
use App\WowzaPublisher;
use App\WowzaVhostHostPort;
use Redirect;


/**
 * Class EpisodeTemplateController
 * @package App\Http\Controllers
 */
class EpisodeTemplateController extends LivestreamController
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        if ( !empty($this->_livestreamAccount) ) {
            $episodeTemplates = $this->_livestreamAccount->episodeTemplates;
            $episodeTemplates->load('LivestreamAccount');
        } else {
            throw new ValidationException("Can't find livestream Account, which is necessary to get Episode Templates");
        }


        return $episodeTemplates;
    }

    /**
     * Show the form for creating a new episode.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('livestream::episodeTemplate/create');
    }

	/**
	 * Store a newly created Episode in storage.
	 *
	 * @param EpisodeTemplateRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function store(EpisodeTemplateRequest $request)
    {
        $request = $request->all();
        $episode = new Episode();

	    if (!empty($request['episode'])) {
            $episode->fill($request['episode']);
        }
        $episodeTemplate = EpisodeTemplate::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'template' => $episode,
            'livestream_account_id' => $this->_livestreamAccount->id
        ]);

        return $episodeTemplate;
    }

    /**
     * Display the specified resource.
     *
     * @param EpisodeTemplate $episodeTemplate
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
     * @param EpisodeTemplateRequest $request
     * @param EpisodeTemplate        $episodeTemplate
     *
     * @return EpisodeTemplate
     */
    public function update( EpisodeTemplateRequest $request, EpisodeTemplate $episodeTemplate )
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
     * @param  int $id
     *
     * @return int
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
                    throw new Exception("You must assign another Episode Template as the <b>Default</b> before you can delete this one");
//		    return Redirect::back()->with( [
//			    'flash.title'   => "Cannot Delete Default Episode Template",
//			    'flash.message' => "You must assign another Episode Template as the <b>Default</b> before you can delete this one",
//			    'flash.level'   => 'danger'
//		    ] );
                }
            }
        } catch(Exception $e) {
//            $data = ['errors' => $e->getMessage()];
            throw $e;
        }

    }

    /**
     * Change the Default Episode Template on this Livestream Account
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeDefaultEpisodeTemplate($id)
    {
        $this->_livestreamAccount->default_episode_template_id = (int)$id;
        $this->_livestreamAccount->save();

        $response = [
            'success' => true,
            'data' => []
        ];

        return response()->json($response);
    }

    /**
     * Update the thumbnail on given Episode
     *
     * @param Request         $request
     * @param EpisodeTemplate $episodeTemplate
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
     * @param Episode $episodeTemplate
     *
     * @return mixed
     */
    public function removeThumbnail(Episode $episodeTemplate)
    {
        return Omnia::interact(DeleteEpisodeTemplateThumbnail::class, [$episodeTemplate]);
    }
}
