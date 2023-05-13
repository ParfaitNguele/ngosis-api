<?php

require_once "../config/db-connexion.php";

//HELPERS OR SHARED METHODS

class Common extends DataBaseConnexion
{
  /*
    Make sure request origin is safe
  */
  public function isSafeOrigin($name, $value){
    $status = false;
    switch ($name) {
      case 'seen':
        ($value === "NKsGZ1ep22S8BEDFNIML") ? $status = true : $status = false;
        break;
      case 'cose':
        ($value === "MLsHZ1fp62S9AEQFNFMM") ? $status = true : $status = false;
        break;
      case 'dise':
        ($value === "ONsHZ8fp8299AEQRNFNN") ? $status = true : $status = false;
        break;
        default:
        $status = false;
        break;
      }
    return $status;
  }
  public function denyRessourceAccess(){
    $initRes = new stdClass();
    $initRes->main_error = true;
    $initRes->main_message = "Authentification API invalide";
    exit(json_encode($initRes));
  }
  /*
    END
  */
  /*
    sanitizer
  */
  public function sanitize($data){
    $newData = htmlspecialchars(trim($data), ENT_QUOTES);
    return $newData;
  }
  /*
    END
  */
  /*
    Transaction blocks
  */
  public function beginTransaction($db){
    $sql = "START TRANSACTION";
    $db->query($sql);
  }
  public function commitTransaction($db){
    $sql = "COMMIT";
    $db->query($sql);
  }
  public function rollbackTransaction($db){
    $sql = "ROLLBACK";
    $db->query($sql);
  }
  /*
    END
  */
  public function generateRandomNbr(){
    $int = rand(100, 1000000) + time();
    return $int;
  }
}
