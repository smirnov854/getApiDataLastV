<?php

class Vianor extends Wheels
{
    public function get_data(){
        $disk  = "https://b2b.vianor-tyres.ru/online/catalog/products.xml?token=fe4e503cabac580d6af478952639c4e9&tire=false&wheel=true&truck-tire=false&truck-wheel=false";
        file_put_contents("wheels.xml",file_get_contents($disk));
    }
    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->products->wheel as $wheel) {

            $this->database_fields["brand"] = htmlentities((string)$wheel->brand);
            $this->database_fields["model"] = htmlentities((string)$wheel->model);
            $this->database_fields["color"] = htmlentities((string)$wheel->attributes()->color);
            $this->database_fields["diameter"] = htmlentities((string)$wheel->attributes()->D) . " / " . htmlentities((string)$wheel->attributes()->W);
            $this->database_fields["et"] = htmlentities((string)$wheel->attributes()->ET);
            $this->database_fields["pn"] = explode("x", htmlentities((string)$wheel->attributes()->PCD))[0];
            $this->database_fields["pcd"] = explode("x", htmlentities((string)$wheel->attributes()->PCD))[1];

            $this->add_database();
            $this->clear_value();
        }
    }
}