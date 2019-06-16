<?php


class Master_model extends NS_Model    
{
    protected $tblName;
    protected $tblId = "id";
    public function __construct($table = null)
    {
        parent::__construct();
        $this->tblName = $table;
    }
    
}
?>
