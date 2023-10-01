<?php

namespace Modules\Livestream\Repositories;

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
