<?php

abstract class Tyres extends Database_worker
{


    private $table_name = "parsing_tyres";
    
    public $database_fields = [
        "source"=>"",
        "cae"=>"",
        "season"=>'',
        "brand"=>'',
        "model"=>'',
        "diameter"=>'',
        "width"=>'',
        "profile"=>'',
        "load_index"=>'',
        "speed_index"=>'',
        "pins"=>'',
        "runflat"=>'',
        "price"=>'',
        "price_retail"=>'',
        "photo_url"=>'',
        "amount"=>0
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