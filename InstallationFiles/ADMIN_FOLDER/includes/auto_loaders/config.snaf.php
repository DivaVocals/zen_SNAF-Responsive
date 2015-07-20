<?php

/*
 * SNAF version 1.2
 * auto loader
*/

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
} 

$autoLoadConfig[199][] = array(
    'autoType' => 'init_script',
    'loadFile' => 'init_snaf.php'
    );  


// uncomment the following line to perform a uninstall
// $uninstall = 'uninstall';

