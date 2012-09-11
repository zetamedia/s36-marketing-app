<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/


View::name('partial.layout', 'layout');

View::composer('partial.layout', function($view){
    $view->nest('header', 'partial.header');
    $view->nest('footer', 'partial.footer');
    return $view;
});

Route::get('/', function(){
    return View::of('layout')->nest('contents', 'home.index');
});

Route::get('tour', function(){
    return View::of('layout')->nest('contents', 'home.tour');
});

Route::get('pricing', function(){
    return View::of('layout')->nest('contents', 'home.pricing');
});

Route::get('company', function(){
    return View::of('layout')->nest('contents', 'home.company');
});

Route::get('tac', function(){
    return View::of('layout')->nest('contents', 'home.tac');
});

Route::get('privacy', function(){
    return View::of('layout')->nest('contents', 'home.privacy');
});

Route::get('login', function(){
    return View::of('layout')->nest('contents', 'home.login');
});


Route::post('registration/ajax_validation/(:any?)', 'registration@ajax_validation');


Route::get('registration/(:any?)', 'registration@show_form');


Route::post('registration/(:any?)', 'registration@process');


Route::get('registration-successful', function(){
    
    $site = ( array_key_exists('login_url', $_GET) ? $_GET['login_url'] : '' );
    return View::of('layout')->nest('contents', 'home.registration-successful', array('site' => $site));

});

use Helpers\Helpers;
Route::get('test', function(){
    
    //$result = S36Braintree::create_account();
    //Helpers::show_data($result);

    $company = new S36Braintree(9564306);
    //$result = $company->update_subscription('enhanced');
    //$result = $company->update_credit_card('4005519200000004', '02', '2014', '456');
    //Helpers::show_data($result);
    Helpers::show_data($company);
    
    //$result = $company->get_next_billing_info();
    //Helpers::show_data($result);
    
    //$result = $company->get_billing_history();
    //Helpers::show_data($result);




    /*
    $site_name = 'kennwel';
    $site = URL::base();
    //$site = 'http://Marketing-Site-Laravel-';
    //$site = 'http://www.mathew-marketing.gearfish.com';
    //$site = 'http://gearfish.com';

    $tld = ( strrpos($site, '.') !== false ? substr($site, strrpos($site, '.')) : '' );
    $host = str_replace('http://', '', $site);
    $host = str_replace($tld, '', $host);
    $host = substr($host, strrpos($host, '.'));
    $host = str_replace('.', '', $host);
    $site = 'https://' . $site_name . '.' . $host . $tld . '/login';

    return $site;
    */

    
    /*
    $output = '';
    $pattern = '/^[\w*\d*]+(-*_*\.*)?[\w*\d*]+$/';
    
    $str[] = 'abc.abc';
    $str[] = 'abc-abc';
    $str[] = 'abc_abc';
    $str[] = 'abc-abc.abc';
    $str[] = 'abc-abc_abc';
    $str[] = 'abc_abc.abc';
    $str[] = 'abc.abc-abc';


    foreach( $str as $k => $v ){
        if( preg_match($pattern, $v) ) $output .= $k . ' => ' . $v . '<br/>';
    }

    return $output;
    */

});


/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});
