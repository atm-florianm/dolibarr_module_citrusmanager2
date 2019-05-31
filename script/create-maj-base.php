<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 */

if(!defined('INC_FROM_DOLIBARR')) {
	define('INC_FROM_CRON_SCRIPT', true);

	require('../config.php');
} else {
	global $db;
}

dol_include_once('/citrusmanager2/class/citrusmanager2.class.php');

$o=new Citrus($db);
$o->init_db_by_vars();

