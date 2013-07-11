<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('auth/facebook/{process?}',
    array('as' => 'hybridauth', 'before' => 'guest', function($process = null)
    {
        if ($process)
        {
            try
            {
                return Hybrid_Endpoint::process();
            }
            catch (Exception $e)
            {
                return Redirect::route('hybridauth');
            }
        }

        try
        {
            $oauth = new Hybrid_Auth(Config::get('hybridauth'));

            $provider = $oauth->authenticate('facebook');
            $userProfile = $provider->getUserProfile();

            // You probably want to do something with the userProfile,
            // like store the facebook identifier and make sure it's unique
            // Or make some more queries via $provider->api()

            $user = new stdClass();
            $user->id = 1;

            $provider->logout();

            Auth::loginUsingId($user->id, true);

            return 'You are now logged in.';
        }
        catch (Exception $e)
        {
            // http://hybridauth.sourceforge.net/userguide/Errors_and_Exceptions_Handling.html
            Log::notice($e);

            return 'Authentication Failed.';
        }
    })
);
