<?php

class DiscoverWheels extends Wheels
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }

    public static function get_data() {
        $tyres = 'https://discovery.moscow/xmlprice/contract/181/?token=$1$VP7fCNIN$RGUvbfGC/4OcNdWkDUq4K1';
        file_put_contents("/home/c/cf08116/public_html/downloader/data/discovery/tyres.xml",file_get_contents($tyres));
    }

    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->disks->disk as $wheel) {

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["brand"] = htmlentities((string)$wheel->brand);
            $this->database_fields["model"] = htmlentities((string)$wheel->model);
            $this->database_fields['cae']=htmlentities((string)$wheel->artikul);
            $this->database_fields['amount']=
                (!empty(htmlentities((string)$wheel->rest_middle)) ? htmlentities((string)$wheel->rest_middle) : 0) +
                (!empty(htmlentities((string)$wheel->rest_fast)) ? htmlentities((string)$wheel->rest_fast) : 0)+
                (!empty(htmlentities((string)$wheel->rest_long)) ? htmlentities((string)$wheel->rest_long) : 0);;


            foreach($wheel->param as $cur_param){


                switch(htmlentities((string)$cur_param->attributes()->name)){
                    case "H/PCD":
                        $this->database_fields["pcd"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Цвет":
                        $this->database_fields["color"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Диаметр колеса":
                        $this->database_fields["diameter"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Количество отверстий":
                        $this->database_fields["pn"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Вылет ET":
                        $this->database_fields["et"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Тип диска":
                        $this->database_fields["type"] = trim(htmlentities((string)$cur_param));
                        break;
                }
            }
            $this->database_fields["photo_url"] = htmlentities((string)$wheel->picture);
            $this->database_fields["price"] = htmlentities((string)$wheel->price);
            $this->database_fields["price_retail"] = htmlentities((string)$wheel->price_recommended);
            $this->add_database();
            $this->clear_value();
        }
    }
}