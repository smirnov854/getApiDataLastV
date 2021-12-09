<?php

class DiscoverTyres extends Tyres
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
        foreach ($xml->tires->tire as $tire) {

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["brand"] = htmlentities((string)$tire->brand);
            $this->database_fields["model"] = htmlentities((string)$tire->model);
            $this->database_fields['cae']=htmlentities((string)$tire->artikul);
            $this->database_fields['amount']=
                (!empty(htmlentities((string)$tire->rest_middle)) ? htmlentities((string)$tire->rest_middle) : 0) +
                (!empty(htmlentities((string)$tire->rest_fast)) ? htmlentities((string)$tire->rest_fast) : 0) +
                (!empty(htmlentities((string)$tire->rest_long)) ? htmlentities((string)$tire->rest_long) : 0);

            foreach($tire->param as $cur_param){

                switch(htmlentities((string)$cur_param->attributes()->name)){
                    case "Ширина":
                        $this->database_fields["width"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Профиль":
                        $this->database_fields["profile"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Диаметр":
                        $this->database_fields["diameter"] = preg_replace('/[^0-9]/', '', trim(htmlentities((string)$cur_param))); ;
                        break;
                    case "Индекс нагрузки":
                        $this->database_fields["load_index"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Индекс скорости":
                        $this->database_fields["speed_index"] = trim(htmlentities((string)$cur_param));
                        break;
                    case "Сезонность":
                        $season = "";
                        if(trim(htmlentities((string)$cur_param)) == "летние"){
                            $season = "S";
                        }
                        if(trim(htmlentities((string)$cur_param)) == "зимние"){
                            $season = "W";
                        }
                        $this->database_fields["season"] = $season;
                        break;
                    case "Шипы":
                        $pin = "";
                        if(trim(htmlentities((string)$cur_param)) == "не Шип"){
                            $pin = "N";
                        }
                        if(trim(htmlentities((string)$cur_param)) == "Шип"){
                            $pin = "Y";
                        }
                        $this->database_fields["pins"] = $pin;
                        break;
                    case "Особенности исполнения модели":
                        if(trim(htmlentities((string)$cur_param)) == "RunFlat"){
                            $this->database_fields["runflat"] = "Y";
                        }
                        break;
                }
            }
            $this->database_fields["photo_url"] = htmlentities((string)$tire->picture);
            $this->database_fields["price"] = htmlentities((string)$tire->price);
            $this->database_fields["price_retail"] = htmlentities((string)$tire->price_recommended);
            $this->add_database();
            $this->clear_value();
        }
    }
}