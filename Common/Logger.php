<?php

class Logger extends Database_worker
{
    public $table = "";

    public function add_log_row($source){
        $insert_array =[
            "source"=>$source,
        ];
        $this->insert($this->table,$insert_array);
    }
}