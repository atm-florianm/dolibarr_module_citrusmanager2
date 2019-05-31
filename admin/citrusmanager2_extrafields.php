<?php
/* Copyright (C) 2001-2002	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2003		Jean-Louis Bergamo		<jlb@j1b.org>
 * Copyright (C) 2004-2011	Laurent Destailleur		<eldy@users.sourceforge.net>
 * Copyright (C) 2012		Regis Houssin			<regis.houssin@inodbox.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *      \file       admin/citrusmanager2_extrafields.php
 *		\ingroup    citrusmanager2
 *		\brief      Page to setup extra fields of citrusmanager2
 */

$res = @include("../../main.inc.php"); // From htdocs directory
if (! $res) {
    $res = @include("../../../main.inc.php"); // From "custom" directory
}


/*
 * Config of extrafield page for CitrusManager2
 */
require_once '../lib/citrusmanager2.lib.php';
require_once '../class/citrus2.class.php';
$langs->loadLangs(array("citrusmanager2@citrusmanager2", "admin", "other"));

$citrusmanager2 = new Citrus($db);
$elementtype=$citrusmanager2->table_element;  //Must be the $table_element of the class that manage extrafield

// Page title and texts elements
$textobject=$langs->transnoentitiesnoconv("CitrusManager2");
$help_url='EN:Help CitrusManager2|FR:Aide CitrusManager2';
$pageTitle = $langs->trans("CitrusManager2ExtrafieldPage");

// Configuration header
$head = citrusmanager2AdminPrepareHead();



/*
 *  Include of extrafield page
 */

require_once dol_buildpath('abricot/tpl/extrafields_setup.tpl.php'); // use this kind of call for variables scope
