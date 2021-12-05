<?php


class TerminalYstTyres extends Tyres
{
    public static function get_data()
    {
        $tyres = "http://terminal.yst.ru/api/xml/tyre/json/d6cd4b8c-5895-41cb-9f9a-66d944c60b7c";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/terminal_yst/tyres.json", file_get_contents($tyres));
    }

    public function read_from_json() {
        $file_handle = fopen($this->file_name, "r");
        var_dump(filesize($this->file_name));
        $file_content = fread($file_handle, filesize($this->file_name));
        $json = json_decode($file_content);
        foreach ($json as $tire) {
            $this->database_fields["source"] = __CLASS__;
            $this->database_fields["cae"] = $tire->article;
            $this->database_fields["name"] = $tire->name;
            $this->database_fields["type"] = $tire->type;
            $this->database_fields["brand"] = $tire->brand;
            $this->database_fields["model"] = $tire->model;
            $this->database_fields["diameter"] = $tire->diametr;
            $this->database_fields["season"] = $tire->season == "Зимняя" ? "W" : "S";
            $this->database_fields["width"] = $tire->width;
            $this->database_fields["profile"] = $tire->height;
            $this->database_fields["speed_index"] = $tire->speed_index;
            $this->database_fields["load_index"] = $tire->load_index;
            $this->database_fields["photo_url"] = $tire->picture;
            $this->database_fields["price"] = $tire->price_b2b;
            $this->database_fields["price_retail"] = $tire->price_recomend_im;
            $this->database_fields["amount"] = $tire->restmsk;
            $this->database_fields["runflat"] = $tire->runflat == 1 ? "Y" : "N";
            $this->add_database();
            $this->clear_value();
        }
        fclose($file_handle);
    }


}
