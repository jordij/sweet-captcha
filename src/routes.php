<?php
/* 
* @Author: Jordi J. <hi@jordijoan.me>
* @Date:   2014-03-12 17:54:05
* @Last Modified by:   jordi
* @Last Modified time: 2014-03-13 10:07:52
*/
/*
|--------------------------------------------------------------------------
| Sweet Captcha Routes
|--------------------------------------------------------------------------
|
| Just one POST route to be a proxy script negotiating with Sweet Captcha. Route defined in config file.
|
*/

Route::post(Config::get('sweet-captcha::SWEETCAPTCHA_PUBLIC_URL'), function()
{
	$sweetcaptcha = App::make('SweetCaptcha');
	if (isset($_POST['ajax']) and $method = $_POST['ajax']) 
	{
  		return $sweetcaptcha->$method(isset($_POST['params']) ? $_POST['params'] : array());
	}
	else 
	{
		return $sweetcaptcha->get_html();
	}
    	
});