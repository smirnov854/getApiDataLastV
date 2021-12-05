<?php


class KolradWheels extends Wheels
{

    public function get_from_api(){
        $this->file_name = "/home/c/cf08116/public_html/downloader/kolrad/cur_page.xml";        
        file_put_contents($this->file_name,file_get_contents($this->prepare_url(0)));
        
        $xml = simplexml_load_file($this->file_name);
        //$xml = simplexml_load_string($output);
        //var_dump($xml);
        $pages = htmlentities((string)$xml->shop->pages);
        
        /*
        for($i=1;$i<=$pages;$i++){
            file_put_contents($file_name,file_get_contents($this->prepare_url(0)));
        }
        */

        /*
        var_dump($total_pages);
        var_dump($total_pages->pages);*/
    }

    private function prepare_url($page = 0){
        return 'https://b2b.kolrad.ru/xml/hannover/page'.$page.'/contract68/?token=$1$yFX..9k0$LPP/k0VzO/Xb9tvMm0eIO0&vendor=0';
    }

    public function read_from_xml() {
        $xml = simplexml_load_file($this->file_name);
        foreach ($xml->shop->offers as $product) {
            $category_id = htmlentities((string)$product->categoryId);
            if($category_id ==5 || $category_id ==7 || $category_id == 4 || $category_id == 1){
                $this->database_fields['source'] = __CLASS__;
                $this->database_fields["brand"] = htmlentities((string)$product->brand);
                $this->database_fields["model"] = htmlentities((string)$product->model);
                $this->database_fields["diameter"] = "R" . htmlentities((string)$product->attributes()->D);
                $this->database_fields["season"] = htmlentities((string)$product->attributes()->season);
                $this->database_fields["width"] = htmlentities((string)$product->attributes()->W);
                $this->database_fields["profile"] = htmlentities((string)$product->attributes()->H);
                $this->database_fields["speed_index"] = htmlentities((string)$product->attributes()->SI);
                $this->database_fields["load_index"] = htmlentities((string)$product->attributes()->LI);
                $this->database_fields["pins"] = htmlentities((string)$product->attributes()->stud);
                $this->database_fields["runflat"] = htmlentities((string)$product->attributes()->run_flat) == "true" ? "Y" : "N";

                $this->database_fields["runflat"] = htmlentities((string)$product->attributes()->run_flat) == "true" ? "Y" : "N";
                var_dump($this->database_fields);
            }

            //$this->add_database();
            //$this->clear_value();
        }
    }

}