<?php


class TerminalYstWheels extends Wheels
{
    public static function get_data()
    {
        $wheels = "http://terminal.yst.ru/api/xml/disk/json/d6cd4b8c-5895-41cb-9f9a-66d944c60b7c";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/terminal_yst/wheels.json", file_get_contents($wheels));
    }

    public function read_from_json() {
        $file_handle = fopen($this->file_name, "r");
        $file_content = fread($file_handle, filesize($this->file_name));
        $json = json_decode($file_content);
        foreach ($json as $rim) {

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields["cae"] = $rim->article;
            $this->database_fields["brand"] = $rim->brand;
            $this->database_fields["model"] = $rim->model;
            $this->database_fields["type"] = $rim->wheelType;
            $this->database_fields["name"] = $rim->name;
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/', '',$rim->diametr);
            $this->database_fields["color"] = $rim->color;

            $this->database_fields["pn"] = $rim->bolts_count;
            $this->database_fields["pcd"] = $rim->bolts_spacing;
            $this->database_fields["dia"] = $rim->dia;
            $this->database_fields["et"] = $rim->et;
            $this->database_fields["price"] = $rim->price;
            $this->database_fields["price_retail"] = $rim->price_recomend_rozn;
            $this->database_fields["photo_url"] = $rim->picture;
            $this->database_fields["amount"] = $rim->restmsk;
            $this->add_database();
            $this->clear_value();
        }
        fclose($file_handle);
    }

}