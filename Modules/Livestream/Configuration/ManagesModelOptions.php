<?php

namespace Modules\Livestream\Configuration;

use Illuminate\Contracts\Auth\Authenticatable;

trait ManagesModelOptions
{
    /**
     * The person model class name.
     *
     * @var string
     */
    public static $personModel = 'People\App\Person';

    /**
     * Set the person model class name.
     *
     * @param string $personModel
     * @return void
     */
    public static function usePersonModel($personModel)
    {
        static::$personModel = $personModel;
    }

    /**
     * Get the person model class name.
     *
     * @return string
     */
    public static function personModel()
    {
        return static::$personModel;
    }

    /**
     * Get a new person model instance.
     *
     * @return Authenticatable
     */
    public static function person()
    {
        return new static::$personModel;
    }
}
