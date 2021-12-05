<?php

class ResultPreparer extends Database_worker
{
    public function prepare_result_tyres(){
        $res = $this->do_sql("SELECT * FROM parsing_tyres");
        $res_file = "/home/c/cf08116/public_html/downloader/result/result_tyres.csv";
        $file_handle = fopen($res_file,"w");
        foreach($res as $row){
            fputcsv($file_handle,$row);
        }
    }

    public function prepare_result_wheels(){
        $res = $this->do_sql("SELECT * FROM parsing_wheels");
        $res_file = "/home/c/cf08116/public_html/downloader/result/result_wheels.csv";
        $file_handle = fopen($res_file,"w");
        foreach($res as $row){
            fputcsv($file_handle,$row);
        }
    }

}