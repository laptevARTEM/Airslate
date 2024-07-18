<?php
class Db {
   public function getConnect()
   {
       $conn = mysqli_connect("mysql", "root", "root", "airslate");

      if (!$conn) {
          echo "Could not connect MySQL.";
          echo "Код ошибки errno: " . mysqli_connect_errno();
          echo "Текст ошибки error: " . mysqli_connect_error();
          exit;
      }
      return $conn;
  }
}
