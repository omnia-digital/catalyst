<?php

namespace App\Repositories;

use App\Omnia;
use Carbon\Carbon;
use Livestream\Livestream;

class EpisodeTemplateRepository
{
    private $_livestreamAccount;

    public function __construct($livestreamAccount)
    {
        $this->_livestreamAccount = $livestreamAccount;
    }

    /**
     * Get the Current Episode Template to be used for this livestreamAccount
     *
     * @param null $livestreamAccount
     *
     * @return
     */
    public function current($livestreamAccount = null)
    {
        if (empty($livestreamAccount)) {
            $livestreamAccount = $this->_livestreamAccount;
        }

        $episodeTemplate = $livestreamAccount->default_episode_template->template;
        return $episodeTemplate;
    }
}
