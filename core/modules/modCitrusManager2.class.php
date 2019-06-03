<?php
/* Copyright (C) 2003      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2012 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@capnetworks.com>
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
 * 	\defgroup   citrusmanager2     Module CitrusManager2
 *  \brief      Example of a module descriptor.
 *				Such a file must be copied into htdocs/citrusmanager2/core/modules directory.
 *  \file       htdocs/citrusmanager2/core/modules/modCitrusManager2.class.php
 *  \ingroup    citrusmanager2
 *  \brief      Description and activation file for module CitrusManager2
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 *  Description and activation class for module CitrusManager2
 */
class modCitrusManager2 extends DolibarrModules
{
	/**
	 *   Constructor. Define names, constants, directories, boxes, permissions
	 *
	 *   @param      DoliDB		$db      Database handler
	 */
	function __construct($db)
	{
        global $langs,$conf;

        $this->db = $db;

		$this->editor_name = 'ATM-Consulting';
		$this->editor_url = 'https://www.atm-consulting.fr';

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 104577; // 104000 to 104999 for ATM CONSULTING
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'citrusmanager2';

		// Family can be 'crm','financial','hr','projects','products','ecm','technic','other'
		// It is used to group modules in module setup page
		$this->family = "ATM";
		// Module label (no space allowed), used if translation string 'ModuleXXXName' not found (where XXX is value of numeric property 'numero' of module)
		$this->name = preg_replace('/^mod/i','',get_class($this));
		// Module description, used if translation string 'ModuleXXXDesc' not found (where XXX is value of numeric property 'numero' of module)
		$this->description = "CitrusManager2 – citrus management made easy";
		// Possible values for version are: 'development', 'experimental', 'dolibarr' or version
		$this->version = '1.0.0';
		// Key used in llx_const table to save module status enabled/disabled (where MYMODULE is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Where to store the module in setup page (0=common,1=interface,2=others,3=very specific)
		$this->special = 0;
		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		$this->picto='citrus@citrusmanager2';
		
		// Defined all module parts (triggers, login, substitutions, menus, css, etc...)
		// for default path (eg: /citrusmanager2/core/xxxxx) (0=disable, 1=enable)
		// for specific path of parts (eg: /citrusmanager2/core/modules/barcode)
		// for specific css file (eg: /citrusmanager2/css/citrusmanager2.css.php)
		$this->module_parts = array(
		                        	'triggers' => 0,                                 	// Set this to 1 if module has its own trigger directory (core/triggers)
									'login' => 0,                                    	// Set this to 1 if module has its own login method directory (core/login)
									'substitutions' => 0,                            	// Set this to 1 if module has its own substitution function file (core/substitutions)
									'menus' => 0,                                    	// Set this to 1 if module has its own menus handler directory (core/menus)
									'theme' => 0,                                    	// Set this to 1 if module has its own theme directory (theme)
		                        	'tpl' => 0,                                      	// Set this to 1 if module overwrite template dir (core/tpl)
									'barcode' => 0,                                  	// Set this to 1 if module has its own barcode directory (core/modules/barcode)
									'models' => 1,                                   	// Set this to 1 if module has its own models directory (core/modules/xxx)
		//							'css' => array('/citrusmanager2/css/citrusmanager2.css.php'),	// Set this to relative path of css file if module has its own css file
	 	//							'js' => array('/citrusmanager2/js/citrusmanager2.js'),          // Set this to relative path of js file if module must load a js on all pages
									'hooks' => array('productcard')  	// Set here all hooks context
        // managed by module
		//							'dir' => array('output' => 'othermodulename'),      // To force the default directories names
		//							'workflow' => array('WORKFLOW_MODULE1_YOURACTIONTYPE_MODULE2'=>array('enabled'=>'! empty($conf->module1->enabled) && ! empty($conf->module2->enabled)', 'picto'=>'yourpicto@citrusmanager2')) // Set here all workflow context managed by module
		);
		$this->module_parts = array();

		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/citrusmanager2/temp");
		$this->dirs = array();

		// Config pages. Put here list of php page, stored into citrusmanager2/admin directory, to use to setup module.
		$this->config_page_url = array("citrusmanager2_setup.php@citrusmanager2");

		// Dependencies
		$this->hidden = false;			// A condition to hide module
		$this->depends = array('modAbricot'); // List of modules id that must be enabled if this module is enabled
		$this->requiredby = array();	// List of modules id to disable if this one is disabled
		$this->conflictwith = array();	// List of modules id this module is in conflict with
		$this->phpmin = array(5,0);					// Minimum version of PHP required by module
		$this->need_dolibarr_version = array(9,0);	// Minimum version of Dolibarr required by module
		$this->langfiles = array("citrusmanager2@citrusmanager2");

		// Constants
		// List of particular constants to add when module is enabled (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		// Example: $this->const=array(0=>array('MYMODULE_MYNEWCONST1','chaine','myvalue','This is a constant to add',1),
		//                             1=>array('MYMODULE_MYNEWCONST2','chaine','myvalue','This is another constant to add',0, 'current', 1)
		// );
		$this->const = array();

		// Array to add new pages in new tabs
		// Example: $this->tabs = array('objecttype:+tabname1:Title1:citrusmanager2@citrusmanager2:$user->rights->citrusmanager2->read:/citrusmanager2/mynewtab1.php?id=__ID__',  	// To add a new tab identified by code tabname1
        //                              'objecttype:+tabname2:Title2:citrusmanager2@citrusmanager2:$user->rights->othermodule->read:/citrusmanager2/mynewtab2.php?id=__ID__',  	// To add another new tab identified by code tabname2
        //                              'objecttype:-tabname:NU:conditiontoremove');                                                     						// To remove an existing tab identified by code tabname
		// where objecttype can be
		// 'categories_x'	  to add a tab in category view (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// 'contact'          to add a tab in contact view
		// 'contract'         to add a tab in contract view
		// 'group'            to add a tab in group view
		// 'intervention'     to add a tab in intervention view
		// 'invoice'          to add a tab in customer invoice view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'member'           to add a tab in fundation member view
		// 'opensurveypoll'	  to add a tab in opensurvey poll view
		// 'order'            to add a tab in customer order view
		// 'order_supplier'   to add a tab in supplier order view
		// 'payment'		  to add a tab in payment view
		// 'payment_supplier' to add a tab in supplier payment view
		// 'product'          to add a tab in product view
		// 'propal'           to add a tab in propal view
		// 'project'          to add a tab in project view
		// 'stock'            to add a tab in stock view
		// 'thirdparty'       to add a tab in third party view
		// 'user'             to add a tab in user view
        $this->tabs = array();

        // Dictionaries
	    if (! isset($conf->citrusmanager2->enabled))
        {
        	$conf->citrusmanager2=new stdClass();
        	$conf->citrusmanager2->enabled=0;
        }
	    $dict_table_name = MAIN_DB_PREFIX . 'c_citrusmanager2_category';
		$this->dictionaries=array(
		    'langs' => 'citrusmanager2@citrusmanager2',
            'tabname' => array($dict_table_name),
            'tablib' => array('CitrusDictCategories'),
            'tabsql' => array('SELECT
                                    dict.rowid,
                                    dict.code,
                                    dict.label,
                                    dict.default_price,
                                    dict.active
                               FROM ' . $dict_table_name . ' AS dict'
            ),
            'tabsqlsort' => array('code ASC'),
            'tabfield' => array('code,label,default_price'),
            'tabfieldvalue' => array('code,label,default_price'),
            'tabfieldinsert' => array('code,label,default_price'),
            'tabrowid' => array('rowid'),
            'tabcond' => array($conf->citrusmanager2->enabled)
        );

        // Boxes
		// Add here list of php file(s) stored in core/boxes that contains class to show a box.
        $this->boxes = array();			// List of boxes
		// Example:
		//$this->boxes=array(array(0=>array('file'=>'myboxa.php','note'=>'','enabledbydefaulton'=>'Home'),1=>array('file'=>'myboxb.php','note'=>''),2=>array('file'=>'myboxc.php','note'=>'')););

		// Permissions
		$this->rights = array();		// Permission array used by this module

		// cf. table llx_rights_def
        $r = 0;
		$this->rights[$r][0] = $this->numero . $r;	    // Permission id (must not be already used)
		$this->rights[$r][1] = 'Read Citrus cards';	// Permission label
		$this->rights[$r][3] = 1; 					    // Permission by default for new user (0/1)
		$this->rights[$r][4] = 'read';				    // In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)
		$this->rights[$r][5] = '';				        // In php code, permission will be checked by test if ($user->rights->permkey->level1->level2)
        $r++;

		$this->rights[$r][0] = $this->numero . $r;
		$this->rights[$r][1] = 'Create, delete or edit Citrus cards';
		$this->rights[$r][3] = 1;
		$this->rights[$r][4] = 'write';
		$this->rights[$r][5] = '';


		// Part of the menu definitions that are the same for all menus of this module:
        $common_menu_config = array(
            'enabled' => '$conf->citrusmanager2->enabled',
            'langs'   => 'citrusmanager2@citrusmanager2',
            'target'  => '',
            'perms'   => 1,
            'user'    => 2
        );
		// Main menu definitions (parts that are specific to each menu):
		$specific_menu_config = array(
		    // Top menu entry (the one you click to go to the module home page)
		    array(
		        'fk_menu'  => '',
                'type'     => 'top',
                'titre'    => 'CitrusManager2',
                'mainmenu' => 'citrusmanager2',
                'leftmenu' => '',
                'url'      => '/citrusmanager2/list.php',
                'position' => $this->numero
            ),
            // Left menu entries (for list / card views)
            array(
                'fk_menu'  => 'fk_mainmenu=citrusmanager2',
                'type'     => 'left',
                'titre'    => 'ListCitruses2',
                'mainmenu' => 'citrusmanager2',
                'leftmenu' => 'citrusmanager2_citrus_list',
                'url'      => '/citrusmanager2/list.php',
                'position' => 1
            ),
            array(
                'fk_menu'  => 'fk_mainmenu=citrusmanager2,fk_leftmenu=citrusmanager2_citrus_list',
                'type'     => 'left',
                'titre'    => 'NewCitrus2',
                'mainmenu' => 'citrusmanager2',
                'leftmenu' => 'citrusmanager2_citrus_new',
                'url'      => '/citrusmanager2/card.php?action=create',
                'position' => 2
            )
        );
		// Combining the common and specific parts into $this->menu
		$this->menu = array();
		foreach ($specific_menu_config as $menu_entry) {
		    $this->menu[] = $menu_entry + $common_menu_config;
        }
	}

	/**
	 *		Function called when module is enabled.
	 *		The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *		It also creates data directories
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */
	function init($options='')
	{
		$sql = array();
		
		define('INC_FROM_DOLIBARR',true);

		require dol_buildpath('/citrusmanager2/script/create-maj-base.php');

		$result=$this->_load_tables('/citrusmanager2/sql/');

		return $this->_init($sql, $options);
	}

	/**
	 *		Function called when module is disabled.
	 *      Remove from database constants, boxes and permissions from Dolibarr database.
	 *		Data directories are not deleted
	 *
     *      @param      string	$options    Options when enabling module ('', 'noboxes')
	 *      @return     int             	1 if OK, 0 if KO
	 */
	function remove($options='')
	{
		$sql = array();

		return $this->_remove($sql, $options);
	}

}
