<?php

if (!class_exists('SeedObject'))
{
	/**
	 * Needed if $form->showLinkedObjectBlock() is call
	 */
	define('INC_FROM_DOLIBARR', true);
	require_once dirname(__FILE__).'/../config.php';
}


class Citrus2 extends SeedObject
{
	public $table_element = 'citrus2';

	public $element = 'citrus2';

    public $isextrafieldmanaged = 1; // enable extrafields
	
	public function __construct($db)
	{
		global $conf,$langs;
		
		$this->db = $db;
		
		$this->fields=array(
			'ref'            =>  array(
                'type' => 'string',
                'length' => 50,
                'index' => true
            ),
			'label'          => array( 'type' => 'string', 'length' => 255 ),
            'price'          => array( 'type' => 'float' ),
            'date_creation'  => array( 'type' => 'date' ),
            'fk_category'    => array( 'type' => 'integer' ),
            'fk_product'     => array( 'type' => 'integer' ),
            'import_key'     => array( 'type' => 'string' ),
            'fk_user_creat'  => array( 'type' => 'integer' ),
            'fk_user_modif'  => array( 'type' => 'integer' ),
            'entity'         => array( 'type' => 'integer' ),
		);
		
		$this->init();
		
		$this->entity = $conf->entity;
	}

	public function save()
	{
		global $user;
		
		if (!$this->id) $this->fk_user_author = $user->id;
		
		$res = $this->id>0 ? $this->updateCommon($user) : $this->createCommon($user);
		
		return $res;
	}
	
	
	public function loadBy($value, $field, $annexe = false)
	{
	    $res = parent::fetchBy($value, $field, $annexe);
		return $res;
	}
	
	public function load($id, $ref, $loadChild = true)
	{
		global $db;
		
		$res = parent::fetchCommon($id, $ref);
		
		if ($loadChild) $this->fetchObjectLinked();
		
		return $res;
	}
	
	public function delete(User &$user)
	{
		parent::deleteCommon($user);
	}

	public function getNumero()
	{
		if (preg_match('/^[\(]?PROV/i', $this->ref) || empty($this->ref))
		{
			return $this->getNextNumero();
		}
		
		return $this->ref;
	}
	
	private function getNextNumero()
	{
		global $db,$conf;
		
		require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
		
		$mask = !empty($conf->global->MYMODULE_REF_MASK) ? $conf->global->MYMODULE_REF_MASK : 'MM{yy}{mm}-{0000}';
		$numero = get_next_value($db, $mask, 'citrus2', 'ref');
		
		return $numero;
	}

	public function getNomUrl($withpicto=0, $get_params='')
	{
		global $langs;

        $result='';
        $label = '<u>' . $langs->trans("ShowCitrusManager2") . '</u>';
        if (! empty($this->ref)) $label.= '<br><b>'.$langs->trans('Ref').':</b> '.$this->ref;
        
        $linkclose = '" title="'.dol_escape_htmltag($label, 1).'" class="classfortooltip">';
        $link = '<a href="'.dol_buildpath('/citrusmanager2/card.php', 1).'?id='.$this->id. $get_params .$linkclose;
       
        $linkend='</a>';

        $picto='generic';
		
        if ($withpicto) $result.=($link.img_object($label, $picto, 'class="classfortooltip"').$linkend);
        if ($withpicto && $withpicto != 2) $result.=' ';
		
        $result.=$link.$this->ref.$linkend;
		
        return $result;
	}

    /** This method replaces the provided fk_product with 0 in all matching citruses.
     *  It should be called when a product is deleted: this way no citrus will hold a
     *  foreign key to a non-existing product.
     *
     * @param $fk_product The ID of the product you are about to delete.
     * @return bool true if the query succeeded, false otherwise.
     */
    public function invalidateFkProduct($fk_product)
    {
        $fk_product = intval($fk_product);
        $sql = 'UPDATE ' . MAIN_DB_PREFIX . $this->table_element . ' SET fk_product = 0 WHERE fk_product = '. $fk_product . ';';
        $resql = $this->db->query($sql);
        if (!$resql) {
            dol_print_error($this->db);
        }
        return (boolean)$resql;
    }

    public function updateLabelWhere($new_label, $where_clause)
    {
        $new_label = '"' . $this->db->escape($new_label) . '"';
        $fk_product = intval($fk_product);
        $sql = 'UPDATE ' . MAIN_DB_PREFIX . $this->table_element . ' SET label = ' . $new_label . ' WHERE ' . $where_clause . ';';
        $resql = $this->db->query($sql);
        if (!$resql) {
            dol_print_error($this->db);
        }
        return (boolean)$resql;
    }

	public static function getStaticNomUrl($id, $withpicto=0)
	{
		global $db;
		
		$object = new Citrus2($db);
		$object->load($id, '',false);
		
		return $object->getNomUrl($withpicto);
	}
}

