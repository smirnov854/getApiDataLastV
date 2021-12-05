<?php

class TrekTyreWheels extends Wheels
{
    public function __construct()
    {
        parent::__construct();
        $this->add_log_row(__CLASS__);
    }

}