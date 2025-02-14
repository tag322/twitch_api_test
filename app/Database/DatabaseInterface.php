<?php

namespace App\Database;

class DatabaseInterface {
    private $DBinstance;

    public function __construct($DBinstance) {
        $this->DBinstance = $DBinstance;
    }

    public function exec_request($sql) {
        $getData = $this->DBinstance->exec($sql);

        $data = $getData->fetchAll();

        return $data;
    }
}