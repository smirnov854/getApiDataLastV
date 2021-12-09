<?php

class Tochki4Tyres extends Tyres
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
        foreach ($json->tires as $tire) {
            $price = !empty($tire->price) ? $tire->price : (
                !empty($tire->price_sk4) ? $tire->price_sk4 :(
                    !empty($tire->price_sk3) ? $tire->price_sk3 :
                    (
                        !empty($tire->price_yamka) ? $tire->price_yamka :(
                        !empty($tire->price_mkrs) ? $tire->price_mkrs : 0
                        )
                    )
                )
            );
            $amount =
            !empty($tire->rest_sk4) ? $tire->rest_sk4 :(
            !empty($tire->rest_sk3) ? $tire->rest_sk3 :
                (
                !empty($tire->rest_yamka) ? $tire->rest_yamka :(
                !empty($tire->rest_mkrs) ? $tire->rest_mkrs : 0
                )
                )
            );
            $this->database_fields['source'] = __CLASS__;
            $this->database_fields['cae'] = $tire->cae;
            $this->database_fields['type'] = $tire->tiretype;
            $this->database_fields["brand"] = $tire->brand;
            $this->database_fields["model"] = $tire->model;
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/','', $tire->diameter);
            $this->database_fields["season"] = $tire->season == "Зимняя" ? "W" : "S";
            $this->database_fields["width"] = $tire->width;
            $this->database_fields["profile"] = $tire->height;
            $this->database_fields["speed_index"] = $tire->speed_index;
            $this->database_fields["load_index"] = $tire->load_index;
            $this->database_fields["photo_url"] = $tire->img_big_pish;
            $this->database_fields["price"] = $price;
            $this->database_fields["price_retail"] = $tire->price_mkrs;
            $this->database_fields["runflat"] = $tire->runflat == "Да" ? "Y" : "N";
            $this->database_fields['amount'] = $amount;
            $this->add_database();
            $this->clear_value();
        }
        fclose($file_handle);
    }
}