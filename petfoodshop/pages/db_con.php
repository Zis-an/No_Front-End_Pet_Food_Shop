<?php
class DBController {
  private $host = "localhost";
  private $user = "root";
  private $password = "";
  private $database = "pet_food_shop_db";
  private $conn;
  
  function __construct() {
    $this->conn = $this->connectDB();
  }
  
  function connectDB() {
    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
    return $conn;
  }
  
  function runQuery($query) {
    $result = mysqli_query($this->conn,$query);
    while($row=mysqli_fetch_assoc($result)) {
      $resultset[] = $row;
    }   
    if(!empty($resultset))
      return $resultset;
    else
      return False;
  }

  function updateQuery($query) {
    $result = mysqli_query($this->conn,$query);   
    if($result)
      return $result;
    else
      return False;
  }

  function registerUser($query) {
    $result = mysqli_query($this->conn,$query);
    if($result)
      return mysqli_insert_id($this->conn);
    else
      return False;
  }
  
  function numRows($query) {
    $result  = mysqli_query($this->conn,$query);
    $rowcount = mysqli_num_rows($result);
    return $rowcount; 
  }
}
?>