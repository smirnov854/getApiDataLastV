<?php
$tyres = new Okno2PresssureSensor();
$tyres->get_data();
$tyres->file_name = "/home/c/cf08116/public_html/downloader/data/okno2/press_sensor.xml";
$tyres->read_from_xml();