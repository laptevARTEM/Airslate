<?php
class Db {
   public function getConnect()
   {
       $conn = null;
       try {
           $conn = mysqli_connect("mysql", "root", "root", "airslate");
       } catch (Exception $e) {
           echo "Could not connect MySQL.";
           echo "<br>Error code errno: " . mysqli_connect_errno();
           echo "<br>Error: " . mysqli_connect_error();
       }
      return $conn;
  }
}
