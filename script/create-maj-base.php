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

dol_include_once('/citrusmanager2/class/citrus2.class.php');

$o=new Citrus2($db);
$o->init_db_by_vars();

