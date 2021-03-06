<?php namespace Arcanedev\Support\Traits;

/**
 * Trait     AbortTrait
 *
 * @package  Arcanedev\Support\Traits
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait AbortTrait
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Throw Page not found [404].
     *
     * @param  string  $message
     * @param  array   $headers
     */
    protected static function pageNotFound($message = 'Page not Found', array $headers = [])
    {
        abort(404, $message, $headers);
    }

    /**
     * Throw AccessNotAllowed [403].
     *
     * @param  string  $message
     * @param  array   $headers
     */
    protected static function accessNotAllowed($message = 'Access denied !', array $headers = [])
    {
        abort(403, $message, $headers);
    }
}
