<?php
define("TEMP",__DIR__ . "/tmp/");
define("ATK14_DOCUMENT_ROOT",__DIR__ . "/tmp/");
define("ATK14_USE_SMARTY4",PHP_VERSION_ID >= 70100);
define("ATK14_USE_SMARTY3",!ATK14_USE_SMARTY4);
define("ATK14_SMARTY_DIR_PERMS",0771);
define("ATK14_SMARTY_FILE_PERMS",0644);
define("ATK14_SMARTY_FORCE_COMPILE",true);
define("ATK14_SMARTY_DEFAULT_MODIFIER","h");
define("DEVELOPMENT",false);
define("PRODUCTION",false);
define("TEST",true);

$ATK14_GLOBAL = Atk14Global::GetInstance();

//require(__DIR__ . "/../vendor/atk14/core/src/load.php");
require(__DIR__ . "/../vendor/atk14/core/src/atk14_smarty_base_v4.php");
require(__DIR__ . "/../vendor/atk14/core/src/atk14_smarty_utils.php");
