<?php

class Tochki4Wheels extends Wheels
{

    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }

    public function read_from_json() {
        $file_handle = fopen($this->file_name, "r");
        $file_content = fread($file_handle, filesize($this->file_name));
        $json = json_decode($file_content);
        foreach ($json->rims as $rim) {

            $price = !empty($rim->price) ? $rim->price : (
            !empty($rim->price_sk4) ? $rim->price_sk4 :(
            !empty($rim->price_sk3) ? $rim->price_sk3 :
                (
                !empty($rim->price_yamka) ? $rim->price_yamka :(
                !empty($rim->price_mkrs) ? $rim->price_mkrs : 0
                )
                )
            )
            );
            $amount =
                !empty($rim->rest_sk4) ? $rim->rest_sk4 :(
                !empty($rim->rest_sk3) ? $rim->rest_sk3 :
                    (
                    !empty($rim->rest_yamka) ? $rim->rest_yamka :(
                    !empty($rim->rest_mkrs) ? $rim->rest_mkrs : 0
                    )
                    )
                );

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields['cae'] = $rim->cae;
            $this->database_fields["brand"] = $rim->brand;
            $this->database_fields["model"] = $rim->model;
            $this->database_fields["type"] = $rim->rim_type;
            $this->database_fields["name"] = $rim->name;
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/', '',$rim->diameter);
            $this->database_fields["color"] = $rim->color;

            $this->database_fields["pn"] = $rim->bolts_count;
            $this->database_fields["pcd"] = $rim->dia;
            $this->database_fields["et"] = $rim->height;
            $this->database_fields["width"] = $rim->width;
            $this->database_fields["price"] = $price;
            $this->database_fields["price_retail"] = $rim->price_sk4_rozn;
            $this->database_fields["photo_url"] = $rim->img_big_pish;
            $this->database_fields['amount'] = $amount;

            $this->add_database();
            $this->clear_value();
        }
        fclose($file_handle);
    }
}