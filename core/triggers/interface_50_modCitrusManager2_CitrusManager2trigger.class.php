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

dol_include_once('citrusmanager2/class/citrus2.class.php');

/**
 * 	\file		core/triggers/interface_99_modMyodule_CitrusManager2trigger.class.php
 * 	\ingroup	citrusmanager2
 * 	\brief		Sample trigger
 * 	\remarks	You can create other triggers by copying this one
 * 				- File name should be either:
 * 					interface_99_modCitrusmanager2_Mytrigger.class.php
 * 					interface_99_all_Mytrigger.class.php
 * 				- The file must stay in core/triggers
 * 				- The class name must be InterfaceMytrigger
 * 				- The constructor method must be named InterfaceMytrigger
 * 				- The name property name must be Mytrigger
 */

/**
 * Trigger class
 */
class InterfaceCitrusManager2trigger
{

    private $db;

    /**
     * Constructor
     *
     * 	@param		DoliDB		$db		Database handler
     */
    public function __construct($db)
    {
        $this->db = $db;

        $this->name = preg_replace('/^Interface/i', '', get_class($this));
        $this->family = "demo";
        $this->description = "Triggers of this module are empty functions."
            . "They have no effect."
            . "They are provided for tutorial purpose only.";
        // 'development', 'experimental', 'dolibarr' or version
        $this->version = 'development';
        $this->picto = 'citrusmanager2@citrusmanager2';
    }

    /**
     * Trigger name
     *
     * 	@return		string	Name of trigger file
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Trigger description
     *
     * 	@return		string	Description of trigger file
     */
    public function getDesc()
    {
        return $this->description;
    }

    /**
     * Trigger version
     *
     * 	@return		string	Version of trigger file
     */
    public function getVersion()
    {
        global $langs;
        $langs->load("admin");

        if ($this->version == 'development') {
            return $langs->trans("Development");
        } elseif ($this->version == 'experimental')

                return $langs->trans("Experimental");
        elseif ($this->version == 'dolibarr') return DOL_VERSION;
        elseif ($this->version) return $this->version;
        else {
            return $langs->trans("Unknown");
        }
    }
	
	
	/**
	 * Function called when a Dolibarrr business event is done.
	 * All functions "run_trigger" are triggered if file is inside directory htdocs/core/triggers
	 *
	 * @param string $action code
	 * @param Object $object
	 * @param User $user user
	 * @param Translate $langs langs
	 * @param conf $conf conf
	 * @return int <0 if KO, 0 if no triggered ran, >0 if OK
	 */
	function runTrigger($action, $object, $user, $langs, $conf) {
		//For 8.0 remove warning
		$result=$this->run_trigger($action, $object, $user, $langs, $conf);
		return $result;
	}	
		

    /**
     * Function called when a Dolibarrr business event is done.
     * All functions "run_trigger" are triggered if file
     * is inside directory core/triggers
     *
     * 	@param		string		$action		Event action code
     * 	@param		Object		$object		Object
     * 	@param		User		$user		Object user
     * 	@param		Translate	$langs		Object langs
     * 	@param		conf		$conf		Object conf
     * 	@return		int						<0 if KO, 0 if no triggered ran, >0 if OK
     */
    public function run_trigger($action, $object, $user, $langs, $conf)
    {
        // Put here code you want to execute when a Dolibarr business events occurs.
        // Data and type of action are stored into $object and $action
        // Users
        switch ($action) {
            case 'USER_LOGIN':
                break;
            case 'USER_UPDATE_SESSION':
                // Warning: To increase performances, this action is triggered only if
                // constant MAIN_ACTIVATE_UPDATESESSIONTRIGGER is set to 1.
                break;
            case 'USER_CREATE':
                break;
            case 'USER_CREATE_FROM_CONTACT':
                break;
            case 'USER_MODIFY':
                break;
            case 'USER_NEW_PASSWORD':
                break;
            case 'USER_ENABLEDISABLE':
                break;
            case 'USER_DELETE':
                break;
            case 'USER_LOGOUT':
                break;
            case 'USER_SETINGROUP':
                break;
            case 'USER_REMOVEFROMGROUP':
                break;
            case 'GROUP_CREATE':
                break;
            case 'GROUP_MODIFY':
                break;
            case 'GROUP_DELETE':
                break;
            case 'COMPANY_CREATE':
                break;
            case 'COMPANY_MODIFY':
                break;
            case 'COMPANY_DELETE':
                break;
            case 'CONTACT_CREATE':
                break;
            case 'CONTACT_MODIFY':
                break;
            case 'CONTACT_DELETE':
                break;
            case 'PRODUCT_CREATE':
                break;
            case 'PRODUCT_MODIFY':
                break;
            case 'PRODUCT_DELETE':
                global $db;
                // if any citrus has a foreign key to this product, set the fk to 0.
                $citrus = new Citrus2($db);
                $citrus->invalidateFkProduct($object->id);
                break;
            case 'ORDER_CREATE':
                break;
            case 'ORDER_CLONE':
                break;
            case 'ORDER_VALIDATE':
                break;
            case 'ORDER_DELETE':
                break;
            case 'ORDER_BUILDDOC':
                break;
            case 'ORDER_SENTBYMAIL':
                break;
            case 'LINEORDER_INSERT':
                break;
            case 'LINEORDER_DELETE':
                break;
            case 'ORDER_SUPPLIER_CREATE':
                break;
            case 'ORDER_SUPPLIER_VALIDATE':
                break;
            case 'ORDER_SUPPLIER_SENTBYMAIL':
                break;
            case 'SUPPLIER_ORDER_BUILDDOC':
                break;
            case 'PROPAL_CREATE':
                break;
            case 'PROPAL_CLONE':
                break;
            case 'PROPAL_MODIFY':
                break;
            case 'PROPAL_VALIDATE':
                break;
            case 'PROPAL_BUILDDOC':
                break;
            case 'PROPAL_SENTBYMAIL':
                break;
            case 'PROPAL_CLOSE_SIGNED':
                break;
            case 'PROPAL_CLOSE_REFUSED':
                break;
            case 'PROPAL_DELETE':
                break;
            case 'LINEPROPAL_INSERT':
                break;
            case 'LINEPROPAL_MODIFY':
                break;
            case 'LINEPROPAL_DELETE':
                break;
            case 'CONTRACT_CREATE':
                break;
            case 'CONTRACT_MODIFY':
                break;
            case 'CONTRACT_ACTIVATE':
                break;
            case 'CONTRACT_CANCEL':
                break;
            case 'CONTRACT_CLOSE':
                break;
            case 'CONTRACT_DELETE':
                break;
            case 'BILL_CREATE':
                break;
            case 'BILL_CLONE':
                break;
            case 'BILL_MODIFY':
                break;
            case 'BILL_VALIDATE':
                break;
            case 'BILL_BUILDDOC':
                break;
            case 'BILL_SENTBYMAIL':
                break;
            case 'BILL_CANCEL':
                break;
            case 'BILL_DELETE':
                break;
            case 'LINEBILL_INSERT':
                break;
            case 'LINEBILL_DELETE':
                break;
            case 'PAYMENT_CUSTOMER_CREATE':
                break;
            case 'PAYMENT_SUPPLIER_CREATE':
                break;
            case 'PAYMENT_ADD_TO_BANK':
                break;
            case 'PAYMENT_DELETE':
                break;
            case 'FICHEINTER_CREATE':
                break;
            case 'FICHEINTER_MODIFY':
                break;
            case 'FICHEINTER_VALIDATE':
                break;
            case 'FICHEINTER_DELETE':
                break;
            case 'MEMBER_CREATE':
                break;
            case 'MEMBER_VALIDATE':
                break;
            case 'MEMBER_SUBSCRIPTION':
                break;
            case 'MEMBER_MODIFY':
                break;
            case 'MEMBER_NEW_PASSWORD':
                break;
            case 'MEMBER_RESILIATE':
                break;
            case 'MEMBER_DELETE':
                break;
            case 'CATEGORY_CREATE':
                break;
            case 'CATEGORY_MODIFY':
                break;
            case 'CATEGORY_DELETE':
                break;
            case 'PROJECT_CREATE':
                break;
            case 'PROJECT_MODIFY':
                break;
            case 'PROJECT_DELETE':
                break;
            case 'TASK_CREATE':
                break;
            case 'TASK_MODIFY':
                break;
            case 'TASK_DELETE':
                break;
            case 'TASK_TIMESPENT_CREATE':
                break;
            case 'TASK_TIMESPENT_MODIFY':
                break;
            case 'TASK_TIMESPENT_DELETE':
                break;
            case 'SHIPPING_CREATE':
                break;
            case 'SHIPPING_MODIFY':
                break;
            case 'SHIPPING_VALIDATE':
                break;
            case 'SHIPPING_SENTBYMAIL':
                break;
            case 'SHIPPING_DELETE':
                break;
            case 'SHIPPING_BUILDDOC':
                break;
            case 'FILE_UPLOAD':
                break;
            case 'FILE_DELETE':
                break;
        }

        return 0;
    }
}