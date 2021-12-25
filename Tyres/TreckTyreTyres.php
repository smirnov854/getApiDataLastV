<?php

class TreckTyreTyres extends Tyres
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }
    public static function get_data() {
        $tyres = "https://www.trektyre.ru/load-price-xml?url=4a4a95e0811629011631bcf0e3add5d8&oplata=0";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/trektyre/tyres.xml",file_get_contents($tyres));
    }

    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->product as $tire) {
            $type = trim(htmlentities((string)$tire->attributes()->type));
            if($type != "шины"){
                continue;
            }
            $amount = htmlentities((string)$tire->StockSmirnovka)+
                      htmlentities((string)$tire->StockKhimki)+
                      htmlentities((string)$tire->StockPechatniki)+
                      htmlentities((string)$tire->StockYuzhnyy)+
                      htmlentities((string)$tire->StockWaiting);
            $this->database_fields["source"] = __CLASS__;
            $this->database_fields["type"] = htmlentities((string)$tire->type);
            $this->database_fields["cae"] = htmlentities((string)$tire->cae);
            $this->database_fields["amount"] = $amount;

            $this->database_fields["brand"] = htmlentities((string)$tire->producer);
            $this->database_fields["model"] = htmlentities((string)$tire->model);
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/','',htmlentities((string)$tire->radius));
            $this->database_fields["load_index"] = htmlentities((string)$tire->li);
            $this->database_fields["speed_index"] = htmlentities((string)$tire->ss);
            $this->database_fields["season"] = (htmlentities((string)$tire->season) == 'всесезон' ? '3' : ( htmlentities((string)$tire->season =='зима' ? 2 : 1)));
            $this->database_fields["width"] = htmlentities((string)$tire->width);
            $this->database_fields["profile"] = htmlentities((string)$tire->h);
            $this->database_fields["pins"] = (htmlentities((string)$tire->stud) == "Y" ? 'on' : 'off');
            $this->database_fields["name"] = htmlentities((string)$tire->name);

            if(stripos($this->database_fields["name"],"RunFlat") !== FALSE){
                $this->database_fields["runflat"] = "on";
            }else{
                $this->database_fields["runflat"] = "off";
            }

            $this->database_fields["price"] = htmlentities((string)$tire->price);
            $this->database_fields["price_retail"] = htmlentities((string)$tire->rs);
            $this->database_fields["photo_url"] = htmlentities((string)$tire->img);
            $this->add_database();
            $this->clear_value();
        }
    }

    /*
    public $api_key = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Iml2YW5vdmthN0BnbWFpbC5jb20iLCJpZCI6IjQ4MDciLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMH0.aE7r9edkvtrFp7wB_8GdsTiAuM__tSwjuw1J4sKN06Q";

    public function get_fro_api(){

        $url = "https://www.trektyre.ru/api-b2b/json/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);

    }*/

}