<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application/'));

set_include_path( APPLICATION_PATH . '/../library' . PATH_SEPARATOR .
                          APPLICATION_PATH . '/models' . PATH_SEPARATOR .
                          APPLICATION_PATH . '/forms' . PATH_SEPARATOR .
                          get_include_path() );

require_once "Zend/Loader.php";
Zend_Loader::registerAutoload();

