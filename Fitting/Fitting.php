<?php


abstract class Fitting extends Database_worker
{
    private $table_name = "parsing_fitting";

    public $database_fields = [
        "source"=>"",
        "brand"=>'',
        "name"=>'',
        "material"=>'',
        "price"=>'',
        "photo_url"=>''
    ];


    public $cur_fields = [];
    public $file_name;

    public function read_from_xml(){}
    public function read_from_json(){}
    public function read_from_csv(){}
    public static function get_data(){}

    public function add_database(){
        $this->insert($this->table_name,$this->database_fields);
    }

    public function clear_value(){
        foreach($this->database_fields as $key=>$row){
            $this->database_fields[$key] = "";
        }
    }
}