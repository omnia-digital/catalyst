<?php

namespace Modules\Livestream\Registries\VideoSource;

use Modules\Livestream\Exceptions\InvalidVideoSourceException;
use Modules\Livestream\Registries\VideoSource\Concerns\BaseVideoSource;

class VideoSourceRegistry
{
    protected array $videos = [];

    /**
     * @return $this
     */
    public function register($name, BaseVideoSource $instance)
    {
        $this->videos[$name] = $instance;

        return $this;
    }

    /**
     * @throws InvalidVideoSourceException
     */
    public function get($name): BaseVideoSource
    {
        if (!array_key_exists($name, $this->videos)) {
            throw new InvalidVideoSourceException('Invalid video source: ' . $name);
        }

        return $this->videos[$name];
    }

    ///**
    // * Get all supported trackers.
    // *
    // * @return SupportedTrackerCollection
    // */
    //public function supportedTrackers(): SupportedTrackerCollection
    //{
    //    return SupportedTrackerCollection::make($this->trackers);
    //}

    /**
     * Get the registered tracker class name.
     *
     * @param $class
     * @return false|int|string
     */
    //public function getTrackerClassName($class)
    //{
    //    is_string($class) || $class = get_class($class);
    //
    //    $supportedTrackers = $this->supportedTrackers()->map(fn($tracker) => get_class($tracker));
    //
    //    return $supportedTrackers->search($class);
    //}
}
