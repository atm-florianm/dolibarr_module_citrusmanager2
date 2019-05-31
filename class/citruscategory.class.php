<?php

if (!class_exists('SeedObject')) {

}

class CitrusCategory extends SeedObject
{
    public $table_element = 'CitrusCategory';
    public $element       = 'CitrusCategory';
    public $isextrafieldmanaged = 0;
    public function __construct(DoliDB &$db)
    {
        global $conf;
        global $langs;
        $this->db = $db;
        $this->fields = array(
            'ref'            => array('type' => 'string', 'length' => 50, 'index' => true),
            'label'          => array('type' => 'string', 'length' => 255),
            'default_price'  => array('type' => 'integer')
        );
        $this->init();
    }
}