<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *	\file		lib/citrusmanager2.lib.php
 *	\ingroup	citrusmanager2
 *	\brief		This file is an example module library
 *				Put some comments here
 */

function citrusmanager2AdminPrepareHead()
{
    global $langs, $conf;

    $langs->load("citrusmanager2@citrusmanager2");

    $h = 0;
    $head = array();

    $head[$h][0] = dol_buildpath("/citrusmanager2/admin/citrusmanager2_setup.php", 1);
    $head[$h][1] = $langs->trans("Parameters");
    $head[$h][2] = 'settings';
    $h++;
    $head[$h][0] = dol_buildpath("/citrusmanager2/admin/citrusmanager2_about.php", 1);
    $head[$h][1] = $langs->trans("About");
    $head[$h][2] = 'about';
    $h++;
    $head[$h][0] = dol_buildpath("/citrusmanager2/admin/citrusmanager2_extrafields.php", 1);
    $head[$h][1] = $langs->trans("ExtraFields");
    $head[$h][2] = 'extrafields';
    $h++;

    // Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    //$this->tabs = array(
    //	'entity:+tabname:Title:@citrusmanager2:/citrusmanager2/mypage.php?id=__ID__'
    //); // to add new tab
    //$this->tabs = array(
    //	'entity:-tabname:Title:@citrusmanager2:/citrusmanager2/mypage.php?id=__ID__'
    //); // to remove a tab
    complete_head_from_modules($conf, $langs, $object, $head, $h, 'Citrus');

    return $head;
}

/**
 * Return array of tabs to used on pages for third parties cards.
 *
 * @param 	Citrus	$object		Object company shown
 * @return 	array				Array of tabs
 */
function citrusmanager2_prepare_head(Citrus $object)
{
    global $db, $langs, $conf, $user;
    $h = 0;
    $head = array();
    $head[$h][0] = dol_buildpath('/citrusmanager2/card.php', 1).'?id='.$object->id;
    $head[$h][1] = $langs->trans("CitrusManager2Card");
    $head[$h][2] = 'card';
    $h++;
	
	// Show more tabs from modules
    // Entries must be declared in modules descriptor with line
    // $this->tabs = array('entity:+tabname:Title:@citrusmanager2:/citrusmanager2/mypage.php?id=__ID__');   to add new tab
    // $this->tabs = array('entity:-tabname:Title:@citrusmanager2:/citrusmanager2/mypage.php?id=__ID__');   to remove a tab
    complete_head_from_modules($conf,$langs,$object,$head,$h, 'Citrus');
	
	return $head;
}

function getFormConfirmCitrusManager2(&$PDOdb, &$form, &$object, $action)
{
    global $langs,$conf,$user;

    $formconfirm = '';

    if ($action == 'validate' && !empty($user->rights->citrusmanager2->write))
    {
        $text = $langs->trans('ConfirmValidateCitrusManager2', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('ValidateCitrusManager2'), $text, 'confirm_validate', '', 0, 1);
    }
    elseif ($action == 'delete' && !empty($user->rights->citrusmanager2->write))
    {
        $text = $langs->trans('ConfirmDeleteCitrusManager2');
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('DeleteCitrusManager2'), $text, 'confirm_delete', '', 0, 1);
    }
    elseif ($action == 'clone' && !empty($user->rights->citrusmanager2->write))
    {
        $text = $langs->trans('ConfirmCloneCitrusManager2', $object->ref);
        $formconfirm = $form->formconfirm($_SERVER['PHP_SELF'] . '?id=' . $object->id, $langs->trans('CloneCitrusManager2'), $text, 'confirm_clone', '', 0, 1);
    }

    return $formconfirm;
}