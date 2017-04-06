<?php

/**
 * Global helpers file with misc functions
 **/

if (! function_exists('app_name')) {
	/**
	 * Helper to grab the application name
	 *
	 * @return mixed
	 */
	function app_name() {
		return config('app.name');
	}
}

if ( ! function_exists('access'))
{
	/**
	 * Access (lol) the Access:: facade as a simple function
	 */
	function access()
	{
		return app('access');
	}
}

if ( ! function_exists('javascript'))
{
	/**
	 * Access the javascript helper
	 */
	function javascript()
	{
		return app('JavaScript');
	}
}

if ( ! function_exists('gravatar'))
{
	/**
	 * Access the gravatar helper
	 */
	function gravatar()
	{
		return app('gravatar');
	}
}

function general_date($date)
  {
	  // 31/05/2010 reference
	  
	  if(empty($date))
	   		return false;
	  $date_array = explode("/",$date);
	  if(!is_array($date_array))
	   return '-';
	  
	  $general_date = $date_array[2].'-'.$date_array[0].'-'.$date_array[1];
	  return($general_date);
 }
 
 function cal_date($date,$zeroRem=false){
     
     if(empty($date))
	   return false;
	  $date_array = explode("-",$date);
	  if(!is_array($date_array))
	   return '-';
	  if($zeroRem)
	   $general_date = str_replace('0','',$date_array[1]).'/'.str_replace('0','',$date_array[2]).'/'.$date_array[0];
          else
            $general_date = $date_array[1].'/'.$date_array[2].'/'.$date_array[0];   
          
          
          
	  return($general_date);
     
 }
 
 
   function q($all = true) 
    {
        $queries = DB::getQueryLog();

        if($all == false) {
            $last_query = end($queries);
            return $last_query;
        }

        return $queries;
    }
