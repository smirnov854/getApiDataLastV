<?php


class Okno2PresssureSensor extends PressureSensor
{
    public static function get_data(){
        $url = "http://okno2.kolobox.ru/storage/catalog/pressure-sensors.xml";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/okno2/press_sensor.xml",file_get_contents($url));
    }

    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->press as $press) {

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["name"] = htmlentities((string)$press->name);
            $this->add_database();
            $this->clear_value();
        }
    }

}