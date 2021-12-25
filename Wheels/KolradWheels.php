<?php


class KolradWheels extends Wheels
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }
    public $path = "/home/c/cf08116/public_html/downloader/data/kolrad/";

    public function get_kolrad_data()
    {
        file_put_contents($this->path . "0.xml", file_get_contents($this->prepare_url(0)));
        $this->file_name = $this->path . "0.xml";
        $xml = simplexml_load_file($this->file_name);
        $pages = htmlentities((string)$xml->shop->pages);

        for ($i = 1; $i <= $pages; $i++) {
            $this->file_name = $this->path . $i . ".xml";
            file_put_contents($this->file_name, file_get_contents($this->prepare_url($i)));
        }
    }

    public function parse_files(){
        $dir_handle = opendir($this->path);
        while(($file_name = readdir($dir_handle)) !== FALSE){
            if($file_name == "." || $file_name == ".."){
                continue;
            }
            $this->file_name = $this->path.$file_name;
            $this->read_from_xml();
        }
    }

    private function prepare_url($page = 0)
    {
        return 'https://b2b.kolrad.ru/xml/hannover/page' . $page . '/contract68/?token=$1$yFX..9k0$LPP/k0VzO/Xb9tvMm0eIO0&vendor=0';
    }

    public function read_from_xml()
    {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->shop->offers->offer as $product) {
            $category_id = htmlentities((string)$product->categoryId);
            if ($category_id == 5 || $category_id == 7 || $category_id == 4 || $category_id == 1) {
                $type = "";
                switch ($category_id) {
                    case 5:
                        $type = "Литые";
                        break;
                    case 7:
                        $type = "Штампованные";
                        break;
                    case 4:
                        $type = "Легкогрузовые";
                        break;
                    case 1:
                        $type = "Грузовые";
                        break;
                    default:
                }
                $this->database_fields['source'] = __CLASS__;
                $this->database_fields['type'] = $type;
                $this->database_fields["brand"] = htmlentities((string)$product->vendor);
                $this->database_fields["cae"] = htmlentities((string)$product->vendorCode);

                foreach ($product->param as $cur_param) {
                    switch (htmlentities((string)$cur_param->attributes()->name)) {
                        case "Модель":
                            $this->database_fields["model"] = htmlentities((string)$cur_param);
                            break;
                        case "Цвет":
                            $this->database_fields["color"] = htmlentities((string)$cur_param);
                            break;
                        case "ET":
                            $this->database_fields["et"] = preg_replace('/[^0-9]/', '',htmlentities((string)$cur_param));
                            break;
                        case "PCD":
                            $this->database_fields["pcd"] = explode("/", htmlentities((string)$cur_param))[1];
                            $this->database_fields["pn"] = preg_replace('/[^0-9]/', '',explode("/", htmlentities((string)$cur_param))[0]);
                            break;
                        case "D (размер обода)":
                            $this->database_fields["diameter"] = preg_replace('/[^0-9]/', '',htmlentities((string)$cur_param));
                            break;
                        case "DIA":
                            $this->database_fields["dia"] = str_replace("d-","",htmlentities((string)$cur_param));
                            break;
                        case "LZ (ширина обода)":
                            $this->database_fields["width"] = htmlentities((string)$cur_param);
                            break;
                            /*
                        case "Код завода":
                            $this->database_fields["cae"] = htmlentities((string)$cur_param);
                            break;*/
                    }
                }
                $this->database_fields["price"] = htmlentities((string)$product->prices->b2b);
                $this->database_fields["price_retail"] = htmlentities((string)$product->prices->rrc);
                $this->database_fields["photo_url"] = htmlentities((string)$product->picture);
                $this->database_fields["amount"] = 0 ;
                foreach($product->stocks->stock as $stock){
                    $this->database_fields["amount"] += (int) htmlentities((int)$stock->quantity);
                }
                $this->add_database();
                $this->clear_value();
            }

        }
    }

}