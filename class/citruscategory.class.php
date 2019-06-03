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
}