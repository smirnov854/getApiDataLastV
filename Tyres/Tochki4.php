<?php

class Tochki4 extends Tyres
{
    public function read_from_json() {
        $file_handle = fopen($this->file_name, "r");
        $file_content = fread($file_handle, filesize($this->file_name));
        $json = json_decode($file_content);
        foreach ($json->tires as $tire) {
            $this->database_fields["brand"] = $tire->brand;
            $this->database_fields["model"] = $tire->model;
            $this->database_fields["diameter"] = $tire->diameter;
            $this->database_fields["season"] = $tire->season == "Зимняя" ? "W" : "S";
            $this->database_fields["width"] = $tire->width;
            $this->database_fields["profile"] = $tire->height;
            $this->database_fields["speed_index"] = $tire->speed_index;
            $this->database_fields["load_index"] = $tire->load_index;
            $this->database_fields["photo_url"] = $tire->img_big_pish;
            $this->database_fields["price"] = $tire->price;
            $this->database_fields["price_retail"] = $tire->price_mkrs;
            $this->database_fields["runflat"] = $tire->runflat == "Да" ? "Y" : "N";
            $this->add_database();
        }
    }
}