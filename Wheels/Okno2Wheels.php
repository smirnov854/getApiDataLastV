<?php

class Okno2Wheels extends Wheels
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }

    public static function get_data() {
        $tyres = "http://okno2.kolobox.ru/storage/catalog/rims.xml";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/okno2/wheels.xml",file_get_contents($tyres));
    }


    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->wheel as $wheel) {


            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["brand"] = htmlentities((string)$wheel->mark);
            $this->database_fields["model"] = htmlentities((string)$wheel->model);
            $this->database_fields["color"] = htmlentities((string)$wheel->color);
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/', '',htmlentities((string)$wheel->diameter));
            $this->database_fields["width"] = htmlentities((string)$wheel->width);
            $this->database_fields["et"] = htmlentities((string)$wheel->et);
            $this->database_fields["pn"] =  htmlentities((string)$wheel->pcd1Quntity);
            $this->database_fields["pcd"] = htmlentities((string)$wheel->pcd1Diameter);
            $this->database_fields['code'] = htmlentities((string)$wheel->articul);
            $this->database_fields['amount'] = htmlentities((string)$wheel->quality);




            $this->add_database();
            $this->clear_value();
        }
    }


}