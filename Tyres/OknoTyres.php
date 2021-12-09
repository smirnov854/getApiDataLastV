<?php

class OknoTyres extends Tyres
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }

    public static function get_data() {
        $tyres = "http://okno2.kolobox.ru/storage/catalog/tyres.xml";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/okno2/tyres.xml",file_get_contents($tyres));
    }

    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);

        foreach ($xml->product as $tire) {

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["cae"] = htmlentities((string)$tire->articul);
            $this->database_fields["amount"] = htmlentities((string)$tire->articul);
            $this->database_fields["brand"] = htmlentities((string)$tire->mark);
            $this->database_fields["model"] = htmlentities((string)$tire->model);
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/','', htmlentities((string)$tire->diameter));
            $this->database_fields["season"] = htmlentities((string)$tire->season) != 1 ? "S" : "W";
            $this->database_fields["width"] = htmlentities((string)$tire->treadWidth);
            $this->database_fields["profile"] = htmlentities((string)$tire->profileHeight);
            $this->database_fields["speed_index"] = htmlentities((string)$tire->speedindex);
            $this->database_fields["load_index"] = htmlentities((string)$tire->loadindex);
            $this->database_fields["type"] = htmlentities((string)$tire->softsidewall);
            $this->database_fields["runflat"] = htmlentities((string)$tire->runflat) >0 ? "Y" : "N";
            $this->add_database();
            $this->clear_value();
        }
    }

    public function get_token(){
        $url = "https://okno2.kolobox.ru/api/oauth/token";

        $post_data = [
            ""
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);

        var_dump($output);
    }



}