<?php


abstract class Wheels extends Database_worker
{



    private $table_name = "parsing_wheels";

    public $database_fields = [
        "source"=>'',
        "brand"=>'',
        "model"=>'',
        "type"=>'',
        "diameter"=>'',
        "color"=>'',
        "pn"=>'',
        "pcd"=>'',
        "et"=>'',
        "price"=>'',
        "price_retail"=>'',
        "photo_url"=>''
    ];


    public $cur_fields = [];
    public $file_name;

    public function read_from_xml(){}
    public function read_from_json(){}
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