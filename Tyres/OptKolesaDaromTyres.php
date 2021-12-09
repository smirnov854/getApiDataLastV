<?php

class OptKolesaDaromTyres extends Tyres
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }

    public function read_from_json()
    {
        $file_handle = fopen($this->file_name, "r");
        $file_content = fread($file_handle, filesize($this->file_name));
        $json = json_decode($file_content);
        foreach ($json as $rim) {
            if ($rim->group != "Автошины") {
                continue;
            }
            $this->database_fields['source'] = __CLASS__;
            $this->database_fields['cae'] = $rim->vendor_code;
            $this->database_fields['amount'] = $rim->countAll;
            $this->database_fields["brand"] = $rim->maker;
            $this->database_fields["model"] = explode(" ",str_replace($rim->maker,'',explode("R",$rim->name)[0]))[0];
            $this->database_fields["name"] = $rim->name;
            $this->database_fields["price"] = $rim->price;
            $this->database_fields["price_retail"] = $rim->price;
            $this->database_fields["code"] = $rim->vendor_code;
            $this->add_database();
            $this->clear_value();
        }
        fclose($file_handle);
    }
}