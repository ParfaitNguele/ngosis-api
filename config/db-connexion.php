<?php

class DataBaseConnexion
{
  public function connect_to_db(){
    $db = new PDO("mysql:host=localhost;dbname=lok;charset=utf8","root","",array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
    if($db){
      return $db;
    }else{
      die("Une erreur est survenue !");
    }
  }
}
