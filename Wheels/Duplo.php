<?php

class Duplo extends Wheels
{
    public function get_data() {
        file_put_contents("/home/c/cf08116/public_html/downloader/duplo/duplo_wheels.csv",file_get_contents('https://duplo.shinservice.ru/xml/shinservice-b2b-wheels.csv?id=88964843&t=1632167785298'));
    }

    public function read_from_csv(){
        $file_handle = fopen($this->file_name, "r");
        $key = 0;
        while(($wheel = fgetcsv($file_handle,99999,"\t")) !== FALSE){
            if($key == 0){
                $key = 1;
                continue;
            }

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["brand"] = $wheel[3];
            $this->database_fields["model"] = $wheel[4];
            $this->database_fields["type"] = $wheel[5];
            $this->database_fields["diameter"] = $wheel[7];
            $this->database_fields["color"] = $wheel[6];

            $this->database_fields["pn"] = $wheel[8];
            $this->database_fields["pcd"] = $wheel[9];
            $this->database_fields["et"] = $wheel[11];
            $this->database_fields["price"] = $wheel[14];
            $this->database_fields["price_retail"] = $wheel[15];
            $this->database_fields["photo_url"] = $wheel[16];

            $this->add_database();
            $this->clear_value();
        }
    }
}