<?php

require_once "../helpers/common.php";

/*
  Search engine class
*/
class DigitSearch extends Common
{
  private $db;
  /*
  * * Database connexion
  */
  public function __construct() {
    $this->db = $this->connect_to_db();
  }
  /*
  * * Methods for statments cration
  */
  //Psaumes
  public function buildMichDigitPsaumesStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrq3u8ej61rm7upmu0' OR id_livre = 'c4lrt1u8ej61uu70m3qg' OR id_livre = 'c4lrtpu8ej62b50tbsng' OR id_livre = 'c4lruje8ej61vc45uu60' OR id_livre = 'c4ls0b68ej62im4otvr0' OR id_livre = 'c4ls15u8ej62i71q59t0' OR id_livre = 'c4ls1o68ej61r55bu7sg' OR id_livre = 'c4ls2fu8ej608p4k64m0' OR id_livre = 'c4ls37e8ej628n2j2p30' OR id_livre = 'c4ls4be8ej60l44t02lg' OR id_livre = 'c4ls50e8ej627t1952h0') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildGabDigitPsaumesStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsde8ej608b7ko800' OR id_livre = 'c4lrt9e8ej61gk0pdta0' OR id_livre = 'c4lru1e8ej60ca7v2htg' OR id_livre = 'c4lrvme8ej61jm0vrh70' OR id_livre = 'c4ls0ku8ej62ma3ouprg' OR id_livre = 'c4ls19m8ej61fv2qga5g' OR id_livre = 'c4ls1te8ej630g7okp3g' OR id_livre = 'c4ls2ke8ej60o73el04g' OR id_livre = 'c4ls3b68ej62lj2rcpmg' OR id_livre = 'c4ls4gu8ej62g46kbfsg' OR id_livre = 'c4ls54m8ej61ta4kvc70') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildRaphDigitPsaumesStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrskm8ej62n16ma8j0' OR id_livre = 'c4lrte68ej611s5uq3gg' OR id_livre = 'c4lru7u8ej630n1gu6ng' OR id_livre = 'c4lrvse8ej62283342og' OR id_livre = 'c4ls0su8ej635r3ok4i0' OR id_livre = 'c4ls1cu8ej62dq741cd0' OR id_livre = 'c4ls24m8ej60a21vcsjg' OR id_livre = 'c4ls2tu8ej60vb69nklg' OR id_livre = 'c4ls3fu8ej60aq0utb1g' OR id_livre = 'c4ls4nu8ej619p77cn20' OR id_livre = 'c4ls58u8ej62cd08po30') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildOurDigitPsaumesStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsre8ej62g17ukqo0' OR id_livre = 'c4lrti68ej62ps2epkf0' OR id_livre = 'c4lrude8ej61752a3i3g' OR id_livre = 'c4ls06e8ej60k251v8rg' OR id_livre = 'c4ls1268ej620o47ppeg' OR id_livre = 'c4ls1h68ej62hd1siir0' OR id_livre = 'c4ls2c68ej62te35973g' OR id_livre = 'c4ls32m8ej61m415bbig' OR id_livre = 'c4ls3ou8ej60h30h390g' OR id_livre = 'c4ls4re8ej60v42e85sg' OR id_livre = 'c4ls5dm8ej620765h9ug') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1')";
    return $stmt;
  }
  //Prayers
  public function buildMichDigitPrayersStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrq3u8ej61rm7upmu0' OR id_livre = 'c4lrt1u8ej61uu70m3qg' OR id_livre = 'c4lrtpu8ej62b50tbsng' OR id_livre = 'c4lruje8ej61vc45uu60' OR id_livre = 'c4ls0b68ej62im4otvr0' OR id_livre = 'c4ls15u8ej62i71q59t0' OR id_livre = 'c4ls1o68ej61r55bu7sg' OR id_livre = 'c4ls2fu8ej608p4k64m0' OR id_livre = 'c4ls37e8ej628n2j2p30' OR id_livre = 'c4ls4be8ej60l44t02lg' OR id_livre = 'c4ls50e8ej627t1952h0') AND (contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildGabDigitPrayersStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsde8ej608b7ko800' OR id_livre = 'c4lrt9e8ej61gk0pdta0' OR id_livre = 'c4lru1e8ej60ca7v2htg' OR id_livre = 'c4lrvme8ej61jm0vrh70' OR id_livre = 'c4ls0ku8ej62ma3ouprg' OR id_livre = 'c4ls19m8ej61fv2qga5g' OR id_livre = 'c4ls1te8ej630g7okp3g' OR id_livre = 'c4ls2ke8ej60o73el04g' OR id_livre = 'c4ls3b68ej62lj2rcpmg' OR id_livre = 'c4ls4gu8ej62g46kbfsg' OR id_livre = 'c4ls54m8ej61ta4kvc70') AND (contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildRaphDigitPrayersStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrskm8ej62n16ma8j0' OR id_livre = 'c4lrte68ej611s5uq3gg' OR id_livre = 'c4lru7u8ej630n1gu6ng' OR id_livre = 'c4lrvse8ej62283342og' OR id_livre = 'c4ls0su8ej635r3ok4i0' OR id_livre = 'c4ls1cu8ej62dq741cd0' OR id_livre = 'c4ls24m8ej60a21vcsjg' OR id_livre = 'c4ls2tu8ej60vb69nklg' OR id_livre = 'c4ls3fu8ej60aq0utb1g' OR id_livre = 'c4ls4nu8ej619p77cn20' OR id_livre = 'c4ls58u8ej62cd08po30') AND (contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildOurDigitPrayersStmt($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsre8ej62g17ukqo0' OR id_livre = 'c4lrti68ej62ps2epkf0' OR id_livre = 'c4lrude8ej61752a3i3g' OR id_livre = 'c4ls06e8ej60k251v8rg' OR id_livre = 'c4ls1268ej620o47ppeg' OR id_livre = 'c4ls1h68ej62hd1siir0' OR id_livre = 'c4ls2c68ej62te35973g' OR id_livre = 'c4ls32m8ej61m415bbig' OR id_livre = 'c4ls3ou8ej60h30h390g' OR id_livre = 'c4ls4re8ej60v42e85sg' OR id_livre = 'c4ls5dm8ej620765h9ug') AND (contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  //Psaumes and prayers
  public function buildMichDigitPsaumesAndPrayers($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrq3u8ej61rm7upmu0' OR id_livre = 'c4lrt1u8ej61uu70m3qg' OR id_livre = 'c4lrtpu8ej62b50tbsng' OR id_livre = 'c4lruje8ej61vc45uu60' OR id_livre = 'c4ls0b68ej62im4otvr0' OR id_livre = 'c4ls15u8ej62i71q59t0' OR id_livre = 'c4ls1o68ej61r55bu7sg' OR id_livre = 'c4ls2fu8ej608p4k64m0' OR id_livre = 'c4ls37e8ej628n2j2p30' OR id_livre = 'c4ls4be8ej60l44t02lg' OR id_livre = 'c4ls50e8ej627t1952h0') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildGabDigitPsaumesAndPrayers($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsde8ej608b7ko800' OR id_livre = 'c4lrt9e8ej61gk0pdta0' OR id_livre = 'c4lru1e8ej60ca7v2htg' OR id_livre = 'c4lrvme8ej61jm0vrh70' OR id_livre = 'c4ls0ku8ej62ma3ouprg' OR id_livre = 'c4ls19m8ej61fv2qga5g' OR id_livre = 'c4ls1te8ej630g7okp3g' OR id_livre = 'c4ls2ke8ej60o73el04g' OR id_livre = 'c4ls3b68ej62lj2rcpmg' OR id_livre = 'c4ls4gu8ej62g46kbfsg' OR id_livre = 'c4ls54m8ej61ta4kvc70') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildRaphDigitPsaumesAndPrayers($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrskm8ej62n16ma8j0' OR id_livre = 'c4lrte68ej611s5uq3gg' OR id_livre = 'c4lru7u8ej630n1gu6ng' OR id_livre = 'c4lrvse8ej62283342og' OR id_livre = 'c4ls0su8ej635r3ok4i0' OR id_livre = 'c4ls1cu8ej62dq741cd0' OR id_livre = 'c4ls24m8ej60a21vcsjg' OR id_livre = 'c4ls2tu8ej60vb69nklg' OR id_livre = 'c4ls3fu8ej60aq0utb1g' OR id_livre = 'c4ls4nu8ej619p77cn20' OR id_livre = 'c4ls58u8ej62cd08po30') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  public function buildOurDigitPsaumesAndPrayers($str){
    $string = trim($str);
    $reg_1 = '[[:space:]]'.$string.'[[:space:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsre8ej62g17ukqo0' OR id_livre = 'c4lrti68ej62ps2epkf0' OR id_livre = 'c4lrude8ej61752a3i3g' OR id_livre = 'c4ls06e8ej60k251v8rg' OR id_livre = 'c4ls1268ej620o47ppeg' OR id_livre = 'c4ls1h68ej62hd1siir0' OR id_livre = 'c4ls2c68ej62te35973g' OR id_livre = 'c4ls32m8ej61m415bbig' OR id_livre = 'c4ls3ou8ej60h30h390g' OR id_livre = 'c4ls4re8ej60v42e85sg' OR id_livre = 'c4ls5dm8ej620765h9ug') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1')";
    return $stmt;
  }
  /*
  * * Methods for searches
  */
  //initialization
  public function launchDigitSearch($data){
    if($data){
      if(!$data->auth_name || !$data->auth_value || $this->isSafeOrigin($data->auth_name, $data->auth_value) === false){
        $this->denyRessourceAccess();
      }else{
        if(in_array('psaumes', $data->main_filters) && in_array('prayers', $data->main_filters)){
          $this->launchDigitDefalultSearch($data->query_string, $data->second_filters);
        }else{
          if(in_array('psaumes', $data->main_filters) && !in_array('prayers', $data->main_filters)){
            $this->launchDigitPsaumeSearch($data->query_string, $data->second_filters);
          }else{
            $this->launchDigitPrayerSearch($data->query_string, $data->second_filters);
          }
        }
      }
    }
  }
  //search per filter type : default
  public function launchDigitDefalultSearch($str, $secondFilters){
    $res = new stdClass();
    $res->error = false;
    $res->message = "";
    $res->psaumes_total = 0;
    $res->prayers_total = 0;
    $res->results_total = 0;
    $res->psaumes_and_prayers_total = 0;
    $res->occurrences = [];
    $res->content = [];
    if(!empty($str)){
      $michPsaumesPrayers = $this->getMichDigitPsaumesAndPrayers($str, $secondFilters);
      $gabPsaumesPrayers = $this->getGabDigitPsaumesAndPrayers($str, $secondFilters);
      $raphPsaumesPrayers = $this->getRaphDigitPsaumesAndPrayers($str, $secondFilters);
      $ourPsaumesPrayers = $this->getOurDigitPsaumesAndPrayers($str, $secondFilters);
      //mergin data
      $mergedArr = array_merge($michPsaumesPrayers, $gabPsaumesPrayers, $raphPsaumesPrayers, $ourPsaumesPrayers);
      //counting occurrences
      $tempContent = [];
      $tempContent = $this->countOccurrencesDefault($mergedArr, $str);
      $res->psaumes_total = $tempContent->psaumes_total;
      $res->prayers_total = $tempContent->prayers_total;
      $res->psaumes_and_prayers_total = $tempContent->psaumes_and_prayers_total;
      $res->occurrences = $tempContent->tempPsaumePsaumesAndPrayersOcc;
      $res->content = $tempContent->tempPsaumePsaumesAndPrayers;
      $res->results_total = count($res->occurrences);
      echo json_encode($res);
    }else{
      $res->error = true;
      $res->message = "Aucun mot-clé fourni";
      echo json_encode($res);
    }
  }
  //psaumes search initialization
  public function launchDigitPsaumeSearch($str, $secondFilters){
    $michPsaumes = $this->getMichDigitPsaumes($str, $secondFilters);
    $gabPsaumes = $this->getGabDigitPsaumes($str, $secondFilters);
    $raphPsaumes = $this->getRaphDigitPsaumes($str, $secondFilters);
    $ourPsaumes = $this->getOurDigitPsaumes($str, $secondFilters);
    $res = new stdClass();
    $res->error = false;
    $res->message = "";
    $res->psaumes_total = 0;
    $res->results_total = 0;
    $res->occurrences = [];
    $res->content = [];

    //merging arrays
    $tempContent = array_merge($michPsaumes, $gabPsaumes, $raphPsaumes, $ourPsaumes);
    //counting occurrences
    $psData = $this->countPsaumesOcc($tempContent, $str);
    $res->psaumes_total = $psData->psaumes_total;
    $res->content = $psData->tempPsaumes;
    $res->occurrences = $psData->tempPsaumesOcc;
    $res->results_total = count($res->occurrences);
    echo json_encode($res);
  }
  //prayers search initialization
  public function launchDigitPrayerSearch($str, $secondFilters){
    $michPrayers = $this->getMichDigitPrayers($str, $secondFilters);
    $gabPrayers = $this->getGabDigitPrayers($str, $secondFilters);
    $raphPrayers = $this->getRaphDigitPrayers($str, $secondFilters);
    $ourPrayers = $this->getOurDigitPrayers($str, $secondFilters);
    $res = new stdClass();
    $res->error = false;
    $res->message = "";
    $res->prayers_total = 0;
    $res->results_total = 0;
    $res->occurrences = [];
    $res->content = [];
    $tempContent = array_merge($michPrayers, $gabPrayers, $raphPrayers, $ourPrayers);
    $prData = $this->countPrayersOcc($tempContent, $str);
    $res->prayers_total = $prData->prayers_total;
    $res->occurrences = $prData ->tempPrayersOcc;
    $res->content = $prData ->tempPrayers;
    $res->results_total = count($res->occurrences);
    echo json_encode($res);
  }
  //get michael psaumes
  public function getMichDigitPsaumes($str, $secondFilters){
    if(in_array('michael', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildMichDigitPsaumesStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  //get gabriel psaumes
  public function getGabDigitPsaumes($str, $secondFilters){
    if(in_array('gabriel', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildGabDigitPsaumesStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  //get raphael psaumes
  public function getRaphDigitPsaumes($str, $secondFilters){
    if(in_array('raphael', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildRaphDigitPsaumesStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  //get ouriel psaumes
  public function getOurDigitPsaumes($str, $secondFilters){
    if(in_array('ouriel', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildOurDigitPsaumesStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  //get michael prayers
  public function getMichDigitPrayers($str, $secondFilters){
    if(in_array('michael', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildMichDigitPrayersStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  //get gabriel prayers
  public function getGabDigitPrayers($str, $secondFilters){
    if(in_array('gabriel', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildGabDigitPrayersStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  //get raphael prayers
  public function getRaphDigitPrayers($str, $secondFilters){
    if(in_array('raphael', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildRaphDigitPrayersStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  //get ouriel prayers
  public function getOurDigitPrayers($str, $secondFilters){
    if(in_array('ouriel', $secondFilters)){
      $query_str = $this->sanitize($str);
      $stmt = $this->buildOurDigitPrayersStmt($query_str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  /*
  * * To get psaumes and prayers for default search
  */
  public function getMichDigitPsaumesAndPrayers($str, $secondFilters){
    if(in_array('michael', $secondFilters)){
      $stmt = $this->buildMichDigitPsaumesAndPrayers($str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  public function getGabDigitPsaumesAndPrayers($str, $secondFilters){
    if(in_array('gabriel', $secondFilters)){
      $stmt = $this->buildGabDigitPsaumesAndPrayers($str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  public function getRaphDigitPsaumesAndPrayers($str, $secondFilters){
    if(in_array('raphael', $secondFilters)){
      $stmt = $this->buildRaphDigitPsaumesAndPrayers($str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  public function getOurDigitPsaumesAndPrayers($str, $secondFilters){
    if(in_array('ouriel', $secondFilters)){
      $stmt = $this->buildOurDigitPsaumesAndPrayers($str);
      $req = $this->db->query($stmt);
      if($req){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
      }else{
        return [];
      }
    }else{
      return [];
    }
  }
  /*
  * * Occurrences counter
  */
  public function countOccurrencesDefault($tempContent, $string){
    $str = trim($string);
    $psaumes_total = 0;
    $prayers_total = 0;
    $psaumes_and_prayers_total = 0;
    $tempPsaumePsaumesAndPrayers = [];
    $tempPsaumePsaumesAndPrayersOcc = [];
    //
    $res = new stdClass();
    $res->psaumes_total = 0;
    $res->prayers_total = 0;
    $res->psaumes_and_prayers_total = 0;
    $res->tempPsaumePsaumesAndPrayers = [];
    $res->tempPsaumePsaumesAndPrayersOcc = [];
    //
    $arrLength = count($tempContent);
    for ($i=0; $i < $arrLength; $i++) {
      $occ_name = $this->countThis($tempContent[$i]["nom_psaume"], $str);
      $occ_psaume = $this->countThis($tempContent[$i]["contenu_psaume"], $str);
      $occ_prayer = $this->countThis($tempContent[$i]["contenu_priere"], $str);
      $tempContent[$i]["occ_psaume"] = $occ_name + $occ_psaume;
      $tempContent[$i]["occ_priere"] = $occ_prayer;
      $tempContent[$i]["occ_total"] = $occ_name + $occ_psaume + $occ_prayer;
      //update total
      $psaumes_total+= $tempContent[$i]["occ_psaume"];
      $prayers_total+= $occ_prayer;
      //
      $random_nbr = $this->generateRandomNbr();
      $total = $occ_name + $occ_psaume + $occ_prayer;

      $token = "".$total.".".$random_nbr."";
      $unique_total = floatval($token);
      $tempContent[$i]["random_nbr"] = $random_nbr;
      $tempContent[$i]["token"] = $token;
      //
      array_push($tempPsaumePsaumesAndPrayers, $tempContent[$i]);
      array_push($tempPsaumePsaumesAndPrayersOcc, $unique_total);
    }

    $res->psaumes_total = $psaumes_total;
    $res->prayers_total = $prayers_total;
    $res->psaumes_and_prayers_total = $psaumes_total + $prayers_total;
    $res->tempPsaumePsaumesAndPrayers = $tempPsaumePsaumesAndPrayers;
    $res->tempPsaumePsaumesAndPrayersOcc = $tempPsaumePsaumesAndPrayersOcc;
    return $res;
  }
  public function countPsaumesOcc($tempContent, $string){
    $str = trim($string);
    $tempPsaumes = [];
    $tempPsaumesOcc = [];
    $psaumes_total = 0;
    $arrLength = count($tempContent);
    //
    $res = new stdClass();
    $res->tempPsaumes = [];
    $res->tempPsaumesOcc = [];
    $res->psaumes_total = 0;
    //
    for ($i=0; $i < $arrLength; $i++) {
      $occ_name = $this->countThis($tempContent[$i]["nom_psaume"], $str);
      $occ_psaume = $this->countThis($tempContent[$i]["contenu_psaume"], $str);
      $tempContent[$i]["occ_psaume"] = $occ_name + $occ_psaume;
      $tempContent[$i]["occ_total"] = $occ_name + $occ_psaume;
      //update totals
      $psaumes_total+= $occ_psaume;
      $psaumes_total+= $occ_name;
      //
      $random_nbr = $this->generateRandomNbr();
      $total = $occ_name + $occ_psaume;
      $token = "".$total.".".$random_nbr."";
      $unique_total = floatval($token);
      $tempContent[$i]["random_nbr"] = $random_nbr;
      $tempContent[$i]["token"] = $token;
      //
      array_push($tempPsaumes, $tempContent[$i]);
      array_push($tempPsaumesOcc, $unique_total);
    }

    $res->tempPsaumes = $tempPsaumes;
    $res->tempPsaumesOcc = $tempPsaumesOcc;
    $res->psaumes_total = $psaumes_total;

    return $res;
  }
  public function countPrayersOcc($tempContent, $string){
    $str = trim($string);
    $tempPrayers = [];
    $tempPrayersOcc = [];
    $prayers_total = 0;
    $arrLength = count($tempContent);
    //
    $res = new stdClass();
    $res->prayers_total = 0;
    $res->tempPrayersOcc = [];
    $res->tempPrayers = [];
    //
    for ($i=0; $i < $arrLength; $i++) {
      $occ_prayer = $this->countThis($tempContent[$i]["contenu_priere"], $str);
      $tempContent[$i]["occ_priere"] = $occ_prayer;
      $tempContent[$i]["occ_total"] = $occ_prayer;
      //update totals
      $prayers_total+= $occ_prayer;
      $random_nbr = $this->generateRandomNbr();
      $total = $occ_prayer;
      $token = "".$total.".".$random_nbr."";
      $unique_total = floatval($token);
      $tempContent[$i]["random_nbr"] = $random_nbr;
      $tempContent[$i]["token"] = $token;
      //
      array_push($tempPrayers, $tempContent[$i]);
      array_push($tempPrayersOcc, $unique_total);
    }
    $res->prayers_total = $prayers_total;
    $res->tempPrayersOcc = $tempPrayersOcc;
    $res->tempPrayers = $tempPrayers;
    return $res;
  }
  public function countThis($content, $str){
    $check_pattern = '/[0-9]/';
    $query_pattern = "/\s".$str."\s/i";
    if(preg_match($check_pattern , $str)){
      $count = preg_match_all($query_pattern, $content);
      return $count;
    }else{
      return 0;
    }
  }
}
