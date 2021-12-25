<?php


class Duplo extends Tyres
{    
    public function get_data() {
        file_put_contents("/home/c/cf08116/public_html/downloader/duplo/duplo_tyres.csv",file_get_contents('https://duplo.shinservice.ru/xml/shinservice-b2b-tyres.csv?id=88964843&t=1632167785298'));
    }

    public function read_from_csv(){
        $file_handle = fopen($this->file_name, "r");
        $key = 0;
        while(($tire = fgetcsv($file_handle,99999,"\t")) !== FALSE){
            if($key == 0){
                $key = 1;
                continue;
            }
            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["season"] = $tire[4] == "S" ? '1' : '2';
            $this->database_fields["brand"] = $tire[5];
            $this->database_fields["model"] = $tire[6];
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/', '', $tire[7]);

            $this->database_fields["width"] = $tire[8];
            $this->database_fields["profile"] = $tire[9];
            $this->database_fields["load_index"] = $tire[10];
            $this->database_fields["speed_index"] = $tire[11];
            $this->database_fields["pins"] = $tire[12] == 'N' ? 'off':'on';
            $this->database_fields["runflat"] = $tire[13] == 'N' ? 'off':'on';

            $this->database_fields["price"] = $tire[16];
            $this->database_fields["price_retail"] = $tire[17];
            $this->database_fields["photo_url"] = $tire[19];
            $this->database_fields["amount"] = $tire[20];
            $this->add_database();
            $this->clear_value();
        }
    }
}