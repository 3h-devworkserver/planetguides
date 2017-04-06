<?php

if( ! function_exists('limit_to_numwords'))
{
    /**
     * Limit content with number of words
     *
     * @param $string
     * @param $numwords
     * @return array|string
     */
    function limit_to_numwords($string, $numwords)
    {
        $excerpt = explode(' ', $string, $numwords + 1);
        if (count($excerpt) >= $numwords)
        {
            array_pop($excerpt);
        }
        $excerpt = implode(' ', $excerpt) . ' ...';
        return $excerpt;
    }
}


if( ! function_exists('getTitle')) {
    /**
     * Render nodes for nested sets
     *
     * @param $object
     * @return string
     */
    function getTitle($object)
    {
        return isset($object->title) ? $object->title : '';
    }
}

if( ! function_exists('getDescription')) {
    /**
     * Render nodes for nested sets
     *
     * @param $object
     * @return string
     */
    function getDescription($object = null)
    {
        return isset($object) && isset($object->description) ? $object->description : Session::get('current_lang')->site_description;
    }
}

if ( ! function_exists('facebookExist'))
{
    /**
     * Access the facebookExist helper
     */
    function facebookExist($providers)
    {
       
       foreach ($providers as $p) {
            if ($p->provider == 'facebook') {
                return true;
            }

        }

        return false;
    }
}

if ( ! function_exists('facebookProfilePic'))
{
    /**
     * Access the facebookProfilePic helper
     */
    function facebookProfilePic($providers)
    {
       
       foreach ($providers as $p) {
            if ($p->provider == 'facebook') {
                return $p->avatar;
            }

        }

        return false;
    }
}



