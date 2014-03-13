<?php
/* 
* @Author: Jordi J. <hi@jordijoan.me>
* @Date:   2014-03-13 09:14:07
* @Last Modified by:   jordi
* @Last Modified time: 2014-03-13 09:43:45
*/
namespace Jordij\SweetCaptcha;

use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Input;
/**
 * Custom class validator for the Sweet Captcha inputs
 * 
 */
class SweetCaptchaValidator extends Validator {

    /**
     * Validation method for the Sweet Captcha input values.
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return boolean            
     */
    public function validateSweetcaptcha($attribute, $value, $parameters)
    {

        if (Input::has('scvalue'))
        {	
        	$sweetcaptcha = app()->make('SweetCaptcha');        	
        	return $sweetcaptcha->check(array('sckey' => $value, 'scvalue' => Input::get('scvalue'))) == "true";
    	}
    	else
    		return false;
    }

}