<?php

include_once __DIR__ . '/../Models/Address.php';

class IndexController
{

    public $conn;

   public function __construct($db)
   {
        $this->conn = $db->getConnect();
   }

   public function index()
   {
       $addresses = (new Address())->getAll($this->conn);

       include_once __DIR__ . '/../../views/home.php';
   }
}
