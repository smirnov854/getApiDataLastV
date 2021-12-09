<?php

class OptWspitality extends Wheels
{

    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }

    public static function get_data()
    {
        $tyres = "https://wspitaly.ru/1c_price/stock_list_wspitaly.xls";
        file_put_contents("/home/c/cf08116/public_html/downloader/data/opt_wspitaly/wheels.xls", file_get_contents($tyres));
    }

    public function read_from_xls()
    {
        require_once "/home/c/cf08116/public_html/downloader/vendor/autoload.php";
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->file_name);
        $spreadsheet = $spreadsheet->getActiveSheet();
        $data_array = $spreadsheet->toArray();

        foreach ($data_array as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $this->database_fields["source"] = __CLASS__;
            $this->database_fields["brand"] = $row[0];
            $this->database_fields["cae"] = $row[2];
            $this->database_fields["name"] = $row[3];
            $this->database_fields["model"] = $row[4];

            $this->database_fields["type"] = "легковые";
            $this->database_fields["diameter"] = preg_replace('/[^0-9]/', '',$row[10]);
            $this->database_fields["color"] = $row[11];

            $this->database_fields["pn"] = explode("X",$row[8])[0];
            $this->database_fields["pcd"] = explode("X",$row[8])[1];
            $this->database_fields["et"] = $row[9];
            $this->database_fields["amount"] = $row[16];
            $this->database_fields["price"] = str_replace(",", "", $row[12]);
            $this->database_fields["price_retail"] = str_replace(",", "", $row[14]);
            $this->database_fields["photo_url"] = $row[17];
            /*echo "<pre>";
            var_dump($this->database_fields);*/

            $this->add_database();
            $this->clear_value();
        }

    }
}