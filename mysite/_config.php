<?php

global $project;
$project = 'mysite';

global $database;
$database = '';

require_once('conf/ConfigureFromEnv.php');

// Set the site locale
i18n::set_locale('en_US');

if(Director::isDev()) {
	Config::inst()->update('FacebookControllerExtension', 'app_id', '441311279594004');
	Config::inst()->update('FacebookControllerExtension', 'api_secret', '79ba23273591f94a8af6a7f64cc3845e');
	SS_Log::add_writer(new SS_LogEmailWriter('coinfolioerror@robertclarkson.net'), SS_Log::ERR);
}