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
 * \file    class/actions_citrusmanager2.class.php
 * \ingroup citrusmanager2
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class ActionsCitrusManager2
 */
class ActionsCitrusManager2
{
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}

	/**
	 * Overloads the addMoreActionsButtons method and adds a 'create citrus from product' button to product cards
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    &$object        The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          &$action        Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	function addMoreActionsButtons($parameters, &$object, &$action, $hookmanager)
	{
		$error = 0; // Error counter
		$myvalue = 'test'; // A result value
        $contexts = explode(':', $parameters['context']);
        $in_context = function($context) use ($contexts) { return in_array($context, $contexts); };
        global $langs;

		if ($in_context('productcard'))
		{
		    $this->results = array();
		    $url = dol_buildpath(
		        'citrusmanager2/card.php?' . http_build_query(array(
		            'action' => 'create_from_product',
		            'mainmenu' => 'citrusmanager2',
                    'fk_product' => $object->id
                )),
                1
            );
		    echo '<div class="divButAction">';
		    echo '<a class="butAction" href=' . $url . '>';
            echo $langs->trans('DeriveCitrusFromProduct');
		    echo '</a>';
		    echo '</div>';
		    return 0;
		}

		if (! $error)
		{
			$this->results = array('myreturn' => $myvalue);
			$this->resprints = 'A text to show';
			return 0; // or return 1 to replace standard code
		}
		else
		{
			$this->errors[] = 'Error message';
			return -1;
		}
	}
}
