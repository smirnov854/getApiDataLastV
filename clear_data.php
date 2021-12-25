<?php
require_once "Common/Database_worker.php";
$db = new Database_worker();
@$db->do_sql("TRUNCATE TABLE parsing_tyres");
@$db->do_sql("TRUNCATE TABLE parsing_wheels");
@$db->do_sql("TRUNCATE TABLE parsing_sensor");
@$db->do_sql("TRUNCATE TABLE parsing_fitting");
@$db->do_sql("UPDATE parsing_source_list SET total_goods=NULL");

