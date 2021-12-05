<?php


class KolradPressureSensor extends PressureSensor
{
    public $path = "/home/c/cf08116/public_html/downloader/data/kolrad/";

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

    public function read_from_xml()
    {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->shop->offers->offer as $product) {
            $category_id = htmlentities((string)$product->categoryId);
            if ($category_id == 2 || $category_id == 8 ) {

                $this->database_fields["cae"] = htmlentities((string)$product->vendorCode);
                $this->database_fields['source'] = __CLASS__;
                $this->database_fields["name"] = htmlentities((string)$product->name);
                $this->database_fields["brand"] = htmlentities((string)$product->vendor);
                $this->database_fields["model"] = htmlentities((string)$product->param);
                $this->database_fields["price"] = htmlentities((string)$product->prices->b2b);
                $this->database_fields["price_retail"] = htmlentities((string)$product->prices->rrc);
                $this->database_fields["photo_url"] = htmlentities((string)$product->picture);
                $this->database_fields["description"] = htmlentities((string)$product->description);

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