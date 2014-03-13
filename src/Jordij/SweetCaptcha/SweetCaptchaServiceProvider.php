<?php namespace Jordij\SweetCaptcha;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Lang;

class SweetCaptchaServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		
		$this->package('jordij/sweet-captcha');
		include __DIR__.'/../../routes.php';

		app()->singleton('SweetCaptcha', function()
		{
		    return new SweetCaptcha();
		});

		app('validator')->resolver(function($translator, $data, $rules, $messages) {
			$messages['sweetcaptcha'] = Lang::get('sweet-captcha::validation.sweetcaptcha');
	        return new SweetCaptchaValidator($translator, $data, $rules, $messages);
	    });

	    app('form')->macro('sweetcaptcha', function(){
			$sweetcaptcha = app()->make('SweetCaptcha');
            return $sweetcaptcha->get_html();
        });
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('sweet-captcha');
	}

}
