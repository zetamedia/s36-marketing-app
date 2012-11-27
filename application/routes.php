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

Route::get('contact', function(){
    return View::of('layout')->nest('contents', 'home.contact');
});


Route::get('login', function(){
    return View::of('layout')->nest('contents', 'home.login');
});


Route::post('validate_login', 'login@validate');


Route::post('get_app_login_url', 'login@get_app_login_url');


Route::post('registration/ajax_validation/(:any?)', 'registration@ajax_validation');


Route::get('registration/(:any?)', 'registration@show_form');


Route::post('registration/(:any?)', 'registration@process');


Route::get('registration-successful', function(){
    
    $site = ( array_key_exists('login_url', $_GET) ? $_GET['login_url'] : '' );
    return View::of('layout')->nest('contents', 'home.registration-successful', array('site' => $site));

});


use JqueryFileUploader\JqueryFileUploader;
use LinkPreview\LinkPreview;

Route::get('jquery_file_uploader', function(){
    new JqueryFileUploader();
});

Route::post('jquery_file_uploader', function(){
    new JqueryFileUploader();
});

Route::get('search_urls', function(){
    $link_preview = new LinkPreview();
    $link_preview->search_urls();
});

Route::get('text_crawler', function(){
    $link_preview = new LinkPreview();
    $link_preview->text_crawler();
});


use Helpers\Helpers;
Route::get('test', function(){
    
    return View::make('jqueryfileuploader.index');
    
    
    
    //$val = 'ssfsdftest';
    //$company = DB::table('User')
    //    ->where('username', '=', $val)
    //    ->or_where('email', '=', $val)
    //    ->get('username');
        
    //var_dump( empty($company) );
    
    
    //$site_name = 'derps';
    //$site = URL::base();
    //$site = 'http://kennwel-marketing.gearfish.com';
    //$site = 'http://beta.36stories.com';
    //$site = 'http://www.beta.36stories.com';
    //$site = 'http://36storiesapp.com';
    //$site = 'http://www.36storiesapp.com';
    
    //$tld = ( strrpos($site, '.') !== false ? substr($site, strrpos($site, '.')) : '' );
    //$host = str_replace('http://', '', $site);
    //$host = str_replace($tld, '', $host);
    //$host = substr($host, strrpos($host, '.'));
    //$host = str_replace('.', '', $host);
    //$host = ($host == '36stories' ? '36storiesapp' : $host);
    //$site = 'https://' . $site_name . '.' . $host . $tld . '/login';
    
    //echo $site;
    
    
    
    //$result = S36Braintree::create_account();
    //Helpers::show_data($result);

    //$company = new S36Braintree(2836241);
    //$result = $company->update_subscription('enhanced');
    //$result = $company->update_credit_card('4005519200000004', '123', '02', '2014', '456');
    //Helpers::show_data($result);
    //Helpers::show_data($company);
    
    //Helpers::show_data($company->exists());
    //Helpers::show_data($company->get_existence_error());
    //Helpers::show_data($company->get_existence_result());
    
    //$result = $company->get_next_billing_info();
    //Helpers::show_data($result);
    
    //$result = $company->get_billing_history();
    //Helpers::show_data($result);

});


Route::get('textcrawler', function(){
    
    header("Content-Type: text/html; charset=ISO-8859-1", true);
    error_reporting(false);
    
    $urlOpen = false;
    if (!ini_get('allow_url_fopen')) {
        $urlOpen = true;
        ini_set('allow_url_fopen', 1);
    }
    
    function utf8Fix($msg){
        $accents = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $utf8 = array("Ã¡","Ã ","Ã¢","Ã£","Ã¤","Ã©","Ã¨","Ãª","Ã«","Ã­","Ã¬","Ã®","Ã¯","Ã³","Ã²","Ã´","Ãµ","Ã¶","Ãº","Ã¹","Ã»","Ã¼","Ã§","Ã","Ã€","Ã‚","Ãƒ","Ã„","Ã‰","Ãˆ","ÃŠ","Ã‹","Ã","ÃŒ","ÃŽ","Ã","Ã“","Ã’","Ã”","Ã•","Ã–","Ãš","Ã™","Ã›","Ãœ","Ã‡");
        $fix = str_replace($utf8, $accents, $msg);
        return $fix;
    }
    
    $text = $_GET["text"];
    $text = " ".str_replace("\n", " ", $text);
    $urlRegex = "/(https?\:\/\/|\s)[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})(\/+[a-z0-9_.\:\;-]*)*(\?[\&\%\|\+a-z0-9_=,\.\:\;-]*)?([\&\%\|\+&a-z0-9_=,\:\;\.-]*)([\!\#\/\&\%\|\+a-z0-9_=,\:\;\.-]*)}*/i";
    
    function getPage($url, $referer, $timeout, $header = ""){
        /*
        if(!isset($timeout))
        $timeout = 30;
        $curl = curl_init();
        if(strstr($referer,"://")){
            curl_setopt ($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
        curl_setopt ($curl, CURLOPT_HEADER, (int)$header);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $html = curl_exec ($curl);
        curl_close ($curl);
        return $html;
        */
        $res = array();
        $options = array( 
            CURLOPT_RETURNTRANSFER => true,     // return web page 
            CURLOPT_HEADER         => false,    // do not return headers 
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects 
            CURLOPT_USERAGENT      => "spider", // who am i 
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect 
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect 
            CURLOPT_TIMEOUT        => 120,      // timeout on response 
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects 
        ); 
        $ch      = curl_init( $url ); 
        curl_setopt_array( $ch, $options ); 
        $content = curl_exec( $ch ); 
        $err     = curl_errno( $ch ); 
        $errmsg  = curl_error( $ch ); 
        $header  = curl_getinfo( $ch ); 
        curl_close( $ch ); 

        $res['content'] = $content;     
        $res['url'] = $header['url'];
        return $res; 
    }
    
    function getTagContent($tag, $string){
        preg_match_all("/<$tag(.*?)>(.*?)<\/$tag>/i", $string, $matches);
        $content = "";
        for($i = 0; $i < count($matches[0]); $i++){
            $currentMatch = strip_tags($matches[0][$i]);
            if(strlen($currentMatch) >= 120){
                $content = $currentMatch;
                break;
            }
        }
        if($content == ""){
            preg_match("/<$tag(.*?)>(.*?)<\/$tag>/i", $string, $matches);
            $content = $matches[0];
        }       
        return str_replace("&nbsp;", "", $content);
    }
    
    function getOpenGraphicContent($property, $text){
        $content = "";
        if(preg_match('/<meta(.*?)property="'.$property.'"(.*?)content="(.+?)"(.*?)(\/)?>/', $text, $matching)){
            $content = $matching[3];
        }
        else if(preg_match('/<meta(.*?)content="(.+?)"(.*?)property="'.$property.'"(.*?)(\/)?>/', $text, $matching)){
            $content = $matching[2];
        }
        else if(preg_match("/<meta(.*?)property='$property'(.*?)content='(.+?)'(.*?)(\/)?>/", $text, $matching)){
            $content = $matching[3];
        }
        else if(preg_match("/<meta(.*?)content='(.+?)'(.*?)property='$property'(.*?)(\/)?>/", $text, $matching)){
            $content = $matching[2];
        }
        return $content;
    }
    
    function mediaYoutube($url){
        $media = array();
        if(preg_match("/(.*?)v=(.*?)($|&)/i", $url, $matching)){
            $vid = $matching[2]; 
            array_push($media, "http://i2.ytimg.com/vi/$vid/hqdefault.jpg");
            array_push($media, '<iframe id="'.date("YmdHis").$vid.'" style="display: none; margin-bottom: 5px;" width="499" height="368" src="http://www.youtube.com/embed/'.$vid.'" frameborder="0" allowfullscreen></iframe>');
        }
        else{
            array_push($media, "", "");
        }
        return $media;
    }
    
    function mediaVimeo($url){
        $url = str_replace("https://", "", $url);
        $url = str_replace("http://", "", $url);
        $breakUrl = explode("/", $url);
        $media = array();
        if($breakUrl[1] != ""){
            $imgId = $breakUrl[1];
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgId.php"));
            array_push($media, $hash[0]['thumbnail_large']); 
            array_push($media, '<iframe id="'.date("YmdHis").$imgId.'" style="display: none; margin-bottom: 5px;" width="500" height="281" src="http://player.vimeo.com/video/'.$imgId.'" width="654" height="368" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe>');
        }
        else{
            array_push($media, "", "");
        }
        return $media;
    }
    
    function cannonicalLink($imgSrc, $referer){
        if(strpos($imgSrc, "//") === 0) $imgSrc = "http:".$imgSrc;
        else if(strpos($imgSrc, "/") === 0) $imgSrc = "http://".cannonicalPage($referer).$imgSrc;
        else $imgSrc = "http://".cannonicalPage($referer).'/'.$imgSrc;
        return $imgSrc;
    }
    
    function cannonicalImgSrc($imgSrc){
        $imgSrc = str_replace("../", "", $imgSrc);
        $imgSrc = str_replace("./", "", $imgSrc);
        $imgSrc = str_replace(" ", "%20", $imgSrc);
        return $imgSrc;
    }
    
    function cannonicalRefererPage($url){
        $cannonical = "";
        $barCounter = 0;
        for($i = 0; $i < strlen($url); $i++){
            if($url[$i] != "/"){
                $cannonical .= $url[$i];
            }
            else{
                $cannonical .= $url[$i];
                $barCounter++;
            } 
            if($barCounter == 3){
                break;
            }
        }
        return $cannonical;
    }
    
    function cannonicalPage($url){
        $cannonical = "";
        if(strpos($url, "http://") !== false) $url = substr($url, 7);
        else if(strpos($url, "https://") !== false) $url = substr($url, 8);
        for($i = 0; $i < strlen($url); $i++){
            if($url[$i] != "/") $cannonical .= $url[$i];
            else break;
        }
        return $cannonical;
    }
    
    function getImageUrl($pathCounter, $url){
        $src = "";
        if($pathCounter > 0){
            $urlBreaker = explode('/', $url);
            for($j = 0; $j < $pathCounter + 1; $j++){
                $src .= $urlBreaker[$j].'/';
            }
        }
        else{
            $src = $url;
        }
        return $src;
    }
    
    function joinAll($matching, $number, $url, $content){
        for($i = 0; $i < count($matching[$number]); $i++){
            $imgSrc =  $matching[$number][$i].$matching[$number + 1][$i];
            $src = "";
            $pathCounter = substr_count($imgSrc, "../");
            if(!preg_match("/https?\:\/\//i", $imgSrc)){
                $src = getImageUrl($pathCounter, cannonicalLink($imgSrc, $url));
            }
            if($src.$imgSrc != $url){
                if($src == "") array_push($content, $src.$imgSrc);
                else array_push($content, $src);
            }
        }
        return $content;
    }
    
    function getImages($text, $url){
        $content = array();
        if(preg_match_all("/<img(.*?)src=(\"|\')(.+?)(gif|jpg|png|bmp)(\"|\')(.*?)(\/)?>(<\/img>)?/", $text, $matching)){
            for($i = 0; $i < count($matching[0]); $i++){
                $src = "";
                $pathCounter = substr_count($matching[0][$i], "../");
                preg_match('/src=(\"|\')(.+?)(\"|\')/i', $matching[0][$i], $imgSrc);
                $imgSrc = cannonicalImgSrc($imgSrc[2]);
                if(!preg_match("/https?\:\/\//i", $imgSrc)){
                    $src = getImageUrl($pathCounter, cannonicalLink($imgSrc, $url));
                }
                if($src.$imgSrc != $url){
                    if($src == "") array_push($content, $src.$imgSrc);
                    else array_push($content, $src);
                }
            }
        }
        if(preg_match_all("/<link(.*?)rel=(\"|\')(.*?)icon(.*?)(\"|\')(.*?)href=(\"|\')(.+?)(gif|jpg|png|bmp|ico)(\"|\')(.*?)(\/)?>(<\/link>)?/", $text, $matching)){
            $content = joinAll($matching, 8, $url, $content);
        }
        else if(preg_match_all("/<link(.*?)href=(\"|\')(.+?)(gif|jpg|png|bmp|ico)(\"|\')(.*?)rel=(\"|\')(.*?)icon(.*?)(\"|\')(.*?)(\/)?>(<\/link>)?/", $text, $matching)){
            $content = joinAll($matching, 3, $url, $content);
        }
        if(preg_match_all("/<meta(.*?)itemprop=(\"|\')image(\"|\')(.*?)content=(\"|\')(.+?)(gif|jpg|png|bmp|ico)(\"|\')(.*?)(\/)?>(<\/meta>)?/", $text, $matching)){
            $content = joinAll($matching, 6, $url, $content);
        }
        else if(preg_match_all("/<meta(.*?)content=(\"|\')(.+?)(gif|jpg|png|bmp|ico)(\"|\')(.*?)itemprop=(\"|\')image(\"|\')(.*?)(\/)?>(<\/meta>)?/", $text, $matching)){
            $content = joinAll($matching, 3, $url, $content);
        }
        $content = array_unique($content);
        $content = array_values($content);
        $images = "";
        for($i = 0; $i < count($content); $i++){
            $size = getimagesize($content[$i]);
            if($size[0] > 100 && $size[1] > 15) $images .= $content[$i]."|";
        }
        return substr($images, 0, -1);
    }
    
    function crawCode($text){
        $content = "";
        $contentSpan = "";
        $contentParagraph = "";
        $contentSpan = getTagContent("span", $text);
        $contentParagraph = getTagContent("p", $text);
        $contentDiv = getTagContent("div", $text);
        $content = $contentSpan;
        if(strlen($contentParagraph) > strlen($contentSpan) && strlen($contentParagraph) >= strlen($contentDiv)) $content = $contentParagraph;
        else if(strlen($contentParagraph) > strlen($contentSpan) && strlen($contentParagraph) < strlen($contentDiv)) $content = $contentDiv;
        else $content = $contentParagraph;
        return $content;
    }
    
    if(preg_match($urlRegex, $text, $match)){
        $raw = "";
        $title = "";
        $images = "";
        $description = "";
        $videoIframe = "";
        $titleAnalysis = "";
        $video = "no";
        if(strpos($match[0], " ") === 0) $match[0] = "http://".substr($match[0], 1);
        $finalUrl = $match[0];
        $pageUrl = str_replace("https://", "http://", $finalUrl);
        $urlData = getPage($pageUrl);
        $pageUrl = $finalUrl = $urlData["url"];
        $raw = $urlData["content"];
        
        //if(!($raw = file_get_contents($pageUrl))) $raw = getPage($pageUrl, 'http://google.com', '30');
        $metaTags = get_meta_tags($pageUrl);
        
        if(isset($metaTags['title'])){
            $title = $metaTags['title'];
        }
        else{
            $title = getOpenGraphicContent("og:title", $raw);
            if($title == ""){
                if(preg_match("/<title(.*?)>(.*?)<\/title>/i", str_replace("\n", " ", $raw), $matching)) $title = $matching[2];
                $titleAnalysis = " ".strtolower($title);
                if($title == "" || (strpos($titleAnalysis, "404") !== false && strpos($titleAnalysis, "not found") !== false && strpos($titleAnalysis, "error") !== false)) $title = $match[0];
                if(strpos($titleAnalysis, "navegador incomp") !== false || strpos($titleAnalysis, "browser not compatible") !== false) $title = "Facebook";
            }
        }
        
        $description = getOpenGraphicContent("og:description", $raw);
        if($description == ""){
            if(isset($metaTags['description'])){
                $description = $metaTags['description'];
                $descriptionUnderstood = true;
            }
            else{
                $description = crawCode($raw);
            }
        }
        if(($descriptionUnderstood == false && strlen($title) > strlen($description) && !preg_match($urlRegex, $description) && $description != "" && !preg_match('/[A-Z]/', $description)) || $title == $description){
            $title = $description;
            $description = crawCode($raw);
        }
        $images = getOpenGraphicContent("og:image", $raw);
        $media = array();
        
        if(strpos($pageUrl, "youtube.com") !== false){
            $media = mediaYoutube($pageUrl);
            $images = $media[0];
            $videoIframe = $media[1];
        }
        else if(strpos($pageUrl, "vimeo.com") !== false){
            $media = mediaVimeo($pageUrl);
            $images = $media[0];
            $videoIframe = $media[1];
        }
        if($images == ""){
            $images = getImages($raw, $pageUrl);
        }
        if($media != null && $media[0] != "" && $media[1] != "") $video = "yes";
        
        $title = trim(str_replace("\n", " ", str_replace("\t", " ", preg_replace("/\s+/", " ", $title))));
        $pageUrl = trim(str_replace("\n", " ", str_replace("\t", " ",  preg_replace("/\s+/", " ", $pageUrl))));
        $description = trim(str_replace("\n", " ", str_replace("\t", " ",  preg_replace("/\s+/", " ", $description))));
        
        $finalLink = explode("&", $finalUrl);
        $finalLink = $finalLink[0];
        
        $description = preg_replace("/<script(.*?)>(.*?)<\/script>/i", "", $description);
        
        $title = utf8Fix($title);
        $description = utf8Fix($description);
        
        $answer = array(
            "title" => $title,
            "titleEsc" => htmlentities($title),
            "url" => $finalLink,
            "pageUrl" => $finalUrl,
            "cannonicalUrl" => cannonicalPage($pageUrl),
            "description" => strip_tags($description),
            "descriptionEsc" => htmlentities(strip_tags($description)),
            "images" => $images,
            "video" => $video,
            "videoIframe" => $videoIframe
        );
        
        echo json_encode($answer);
        
    }
    
    if($urlOpen == true){
        ini_set('allow_url_fopen', 0);
    }
    
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
