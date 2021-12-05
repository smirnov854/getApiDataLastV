<?php


abstract class PressureSensor extends Database_worker
{

    private $table_name = "parsing_sensor";
    public $file_name;

    public $database_fields = [
        "source"=>'',
        "name"=>'',
        "brand"=>'',
        "model"=>'',
        "price"=>'',
        "photo_url"=>''
    ];


    public function add_database(){
        $this->insert($this->table_name,$this->database_fields);
    }

    public function clear_value(){
        foreach($this->database_fields as $key=>$row){
            $this->database_fields[$key] = "";
        }
    }

    public static function get_data(){}

}