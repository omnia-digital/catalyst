<?php namespace App\Configuration;

use App\User;
use Illuminate\Support\HtmlString;

trait ManagesAppDetails
{
    /**
     * The e-mail address of the System Admin Users.
     */
    public static $systemAdminUser;

    /**
     * Set the e-mail address of the System Admin User.
     *
     * @param  string $email
     * @return void
     */
    public static function systemAdminUser($email)
    {
        static::$systemAdminUser = $email;
    }

    /**
     * Determine if the given e-mail address belongs to a developer.
     *
     * @param  string  $email
     * @return bool
     */
    public static function isSystemAdmin($email)
    {
        if ($email === static::$systemAdminUser) {
            return true;
        }

        return false;
    }
}
