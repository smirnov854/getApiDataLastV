<?php

$wheel = new VianorWheels();
$wheel->file_name = "/home/c/cf08116/public_html/downloader/data/vianor/wheels.xml";
$wheel->read_from_xml();
$wheel->parse_amounts();

