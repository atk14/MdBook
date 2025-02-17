<?php
define("TEMP",__DIR__ . "/tmp/");
define("ATK14_DOCUMENT_ROOT",__DIR__ . "/");
define("ATK14_USE_SMARTY4",PHP_VERSION_ID >= 70100);
define("ATK14_USE_SMARTY3",!ATK14_USE_SMARTY4);
define("ATK14_SMARTY_DIR_PERMS",0771);
define("ATK14_SMARTY_FILE_PERMS",0644);
define("ATK14_SMARTY_FORCE_COMPILE",true);
define("ATK14_SMARTY_DEFAULT_MODIFIER","h");
define("ATK14_NON_SSL_PORT",80);
define("DEFAULT_CHARSET","UTF-8");
define("DEVELOPMENT",false);
define("PRODUCTION",false);
define("TEST",true);

$ATK14_GLOBAL = Atk14Global::GetInstance();
$HTTP_REQUEST = new HTTPRequest();
$HTTP_RESPONSE = new HTTPResponse();

//require(__DIR__ . "/../vendor/atk14/core/src/load.php");
require(__DIR__ . "/../vendor/atk14/core/src/atk14_smarty_base_v4.php");
require(__DIR__ . "/../vendor/atk14/core/src/atk14_smarty_utils.php");

function atk14_initialize_locale(&$lang = null){
	global $ATK14_GLOBAL;

	$locale = $ATK14_GLOBAL->getConfig("locale");

	if(is_null($lang) || !isset($locale[$lang])){
		$_keys = array_keys($locale);
		$lang = $_keys[0];
	}

	$l = $locale[$lang]["LANG"];

	putenv("LANG=$l");
	putenv("LANGUAGE=");
	setlocale(LC_MESSAGES,$l);
	setlocale(LC_ALL,$l);
	setlocale(LC_CTYPE,$l);
	setlocale(LC_COLLATE,$l);
	setlocale(LC_NUMERIC,"C"); // we need to display float like 123.456
	bindtextdomain("messages",$ATK14_GLOBAL->getApplicationPath()."/../locale/");
	bind_textdomain_codeset("messages", DEFAULT_CHARSET);
	textdomain("messages");
}
