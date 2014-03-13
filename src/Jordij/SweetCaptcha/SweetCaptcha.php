<?php
/* 
* @Author: Jordi J. <hi@jordijoan.me>
* @Date:   2014-03-13 09:14:28
* @Last Modified by:   jordi
* @Last Modified time: 2014-03-13 11:08:13
*/
namespace Jordij\SweetCaptcha;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

define('SWEETCAPTCHA_API_URL', 'sweetcaptcha.com');
define('SWEETCAPTCHA_API_PORT', 80);
/**
 * Class to handle the requests to Sweet Captcha service.
 * 
 */
class SweetCaptcha{

	private $appid, $key, $secret, $path, $url, $port, $language;
	
	function __construct() 
	{
		$this->appid = Config::get('sweet-captcha::SWEETCAPTCHA_APP_ID');
		$this->key = Config::get('sweet-captcha::SWEETCAPTCHA_KEY');
		$this->secret = Config::get('sweet-captcha::SWEETCAPTCHA_SECRET');
		$this->path = Config::get('sweet-captcha::SWEETCAPTCHA_PUBLIC_URL');
		$this->language = strtoupper( (Config::get('sweet-captcha::SWEETCAPTCHA_LANGUAGE') != '') ? Config::get('sweet-captcha::SWEETCAPTCHA_LANGUAGE') : App::getLocale());
	}
	/**
	 * Set call parameters.
	 * @param  [type] $method [description]
	 * @param  [type] $params [description]
	 * @return void
	 */
	private function api($method, $params) 
	{
    
		$basic = array(
		  'method'      => $method,
		  'appid'       => $this->appid,
		  'key'         => $this->key,
		  'path'        => $this->path,
		  'user_ip'     => $_SERVER['REMOTE_ADDR'],
		  'language'    => $this->language,
		  'platform'    => 'php'
		);

		return $this->call(array_merge(isset($params[0]) ? $params[0] : $params, $basic));
	}

  	/**
  	 * Call to Sweet Captcha service
  	 * @param  array $params 
  	 * @return string         
  	 */
    private function call($params) 
    {
    	$param_data = "";   
    	foreach ($params as $param_name => $param_value) 
    	{
      		$param_data .= urlencode($param_name) .'='. urlencode($param_value) .'&'; 
    	}
    
    	if (!($fs = fsockopen(SWEETCAPTCHA_API_URL, SWEETCAPTCHA_API_PORT, $errno, $errstr, 10))) 
    	{
      		die ("Could not connect to server");
    	}
    
	    $req = "POST /api.php HTTP/1.0\r\n";
	    $req .= "Host: " . SWEETCAPTCHA_API_URL . "\r\n";
	    $req .= "Content-Type: application/x-www-form-urlencoded\r\n";
	    $req .= "Referer: " . $_SERVER['HTTP_HOST']. "\r\n";
	    $req .= "Content-Length: " . strlen($param_data) . "\r\n\r\n";
	    $req .= $param_data;    
  
	    $response = '';
	    fwrite($fs, $req);
	    
	    while (!feof($fs)) 
	    {
	      $response .= fgets($fs, 1160);
	    }
	    
	    fclose($fs);
	    
	    $response = explode("\r\n\r\n", $response, 2);
	    
	    return $response[1];  
	}
  
  	public function __call($method, $params) 
  	{
    	return $this->api($method, $params);
  	}

}

?>