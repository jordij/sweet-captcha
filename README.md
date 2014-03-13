sweet-captcha
=============

Laravel 4 Sweet Captcha Package
-------------------------------

This package provides an easy and quick integration of the **[sweetCaptcha](http://www.sweetcaptcha.com)** service for Laravel 4.

Installation
------------

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `jordij/sweet-captcha`.

```
"require": {
	"jordij/sweet-captcha": "dev-master"
},
```

Save the changes and run a composer update:

`composer update`

Add `'Jordij\SweetCaptcha\SweetCaptchaServiceProvider'` to the providers array in your `app/config/app.php`

Configuration
------------

Register your sweetCaptcha account **[here](http://www.sweetcaptcha.com/accounts/signup)**. Set the ApplicationID, the key and the secret in the package configuration file `config/config.php`.

Localization
------------

By default the package will use the current locale of your Laravel application. If by any reasons you want to set a fixed locale you can do it by editing the package configuration file `config/config.php`.

Usage
-----

In your form:

```
{{ Form::sweetcaptcha() }}
```
Add `'sckey' => 'sweetcaptcha'` to your rules array before validating the form.

If you want to change the error message you can do it in the package language file `lang/en/validation.php`

