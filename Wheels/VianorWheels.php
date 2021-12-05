<?php

class VianorWheels extends Wheels
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }
    public static function get_data(){
        $disk  = "https://b2b.vianor-tyres.ru/online/catalog/products.xml?token=fe4e503cabac580d6af478952639c4e9&tire=false&wheel=true&truck-tire=false&truck-wheel=false";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/vianor/wheels.xml",file_get_contents($disk));
    }

    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->products->wheel as $wheel) {

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["cae"] = htmlentities((string)$wheel->attributes()->cae);
            $this->database_fields["code"] = htmlentities((string)$wheel->attributes()->code);
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

    public function parse_amounts(){
        $sql = "UPDATE parsing_wheels pt
                LEFT JOIN parsing_vianor_tmp tmp ON tmp.code=pt.code
                SET pt.amount=tmp.amount, pt.price=tmp.price";
        @$this->do_sql($sql);
    }
}