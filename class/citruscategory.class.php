<?php

if (!class_exists('SeedObject')) {

}

class CitrusCategory extends SeedObject
{
    /**
     * @var string $table_element  Name of the SQL table without prefix (the prefix, usually 'llx_', will be added
     *                             automatically)
     */
    public $table_element = 'c_citrusmanager2_category';
    public $element       = 'c_citrusmanager2_category';
    public $isextrafieldmanaged = 0;
    public function __construct(DoliDB &$db)
    {
        global $conf;
        global $langs;
        $this->db = $db;
        $this->fields = array(
            'code'           => array('type' => 'string', 'length' => 255, 'index' => true),
            'label'          => array('type' => 'string', 'length' => 1024),
            'default_price' => array('type' => 'integer'),
            'active'        => array('type' => 'integer')
        );
        $this->init();
    }

    public function fetchOptionsForSelect()
    {
        $sql  = 'SELECT category.rowid, category.code, category.label';
        $sql .= ' FROM ' . MAIN_DB_PREFIX . 'c_citrusmanager2_category category;';
        $resql = $this->db->query($sql);
        if ($resql) {
            $allCategories = array();
            while ($object = $this->db->fetch_object($resql)) {
                $id = $object->rowid;
                $allCategories[$id] = $object->label;
            }
            return $allCategories;
        } else {
            dol_print_error($this->db);
            return -1;
        }

    }
}