<?php

require_once "../helpers/common.php";

/**
 * Combine search engine class
 */
class CombineSearch extends Common
{
  private $db;
  /*
  * * Database connexion
  */
  public function __construct(){
    $this->db = $this->connect_to_db();
  }

  /*
  * * To launch a combine searches
  */
  public function launchCombineSearch($data){
    if($data){
      if(!$data->auth_name || !$data->auth_value || $this->isSafeOrigin($data->auth_name, $data->auth_value) === false){
        $this->denyRessourceAccess();
      }else{
        if(in_array('psaumes', $data->main_filters) && in_array('prayers', $data->main_filters)){
          $this->launchcombineDefalultSearch($data->query_string, $data->second_filters);
        }else{
          if(in_array('psaumes', $data->main_filters) && !in_array('prayers', $data->main_filters)){
            $this->launchcombinePsaumeSearch($data->query_string, $data->second_filters);
          }else{
            $this->launchcombinePrayerSearch($data->query_string, $data->second_filters);
          }
        }
      }
    }
  }
  public function launchcombineDefalultSearch($query_string, $secondFilters){
    $res = new stdClass();
    $res->error = false;
    $res->message = "";
    $res->psaumes_total = 0;
    $res->prayers_total = 0;
    $res->psaumes_and_prayers_total = 0;
    $res->results_total = 0;
    $res->occurrences = [];
    $res->content = [];

    if(count($query_string) === 2){
      $michCombinePsaumesPrayers = $this->getCombineMichPsaumesAndPrayers($query_string, $secondFilters);
      $gabCombinePsaumesPrayers = $this->getCombineGabPsaumesAndPrayers($query_string, $secondFilters);
      $raphCombinePsaumesPrayers = $this->getCombineRaphPsaumesAndPrayers($query_string, $secondFilters);
      $ourCombinePsaumesPrayers = $this->getCombineOurPsaumesAndPrayers($query_string, $secondFilters);
      //mergin data
      $tempContent = array_merge($michCombinePsaumesPrayers, $gabCombinePsaumesPrayers, $raphCombinePsaumesPrayers, $ourCombinePsaumesPrayers);
      $ppData = $this->countOccurrencesDefault($tempContent, $query_string);
      $res->psaumes_total = $ppData->psaumes_total;
      $res->prayers_total = $ppData->prayers_total;
      $res->psaumes_and_prayers_total = $ppData->psaumes_and_prayers_total;
      $res->occurrences = $ppData->tempPsaumePsaumesAndPrayersOcc;
      $res->content = $ppData->tempPsaumePsaumesAndPrayers;
      $res->results_total = count($res->occurrences);
      echo json_encode($res);
    }else{
      $res->error = true;
      $res->message = "Aucun mot-clé fourni";
      echo json_encode($res);
    }
  }
  public function launchcombinePsaumeSearch($query_string, $second_filters){
    $michPsaumes = $this->getcombineMichPsaumes($query_string, $second_filters);
    $gabPsaumes = $this->getcombineGabPsaumes($query_string, $second_filters);
    $raphPsaumes = $this->getcombineRaphPsaumes($query_string, $second_filters);
    $ourPsaumes = $this->getcombineOurPsaumes($query_string, $second_filters);
    $res = new stdClass();
    $res->error = false;
    $res->psaumes_total = 0;
    $res->results_total = 0;
    $res->occurrences = [];
    $res->content = [];
    $res->message = "";
    //merging arrays
    $tempContent = array_merge($michPsaumes, $gabPsaumes, $raphPsaumes, $ourPsaumes);
    $psData = $this->countPsaumesOccDefault($tempContent, $query_string);
    $res->psaumes_total = $psData->psaumes_total;
    $res->occurrences = $psData->tempPsaumesOcc;
    $res->content = $psData->tempPsaumes;
    $res->results_total = count($res->occurrences);
    echo json_encode($res);
  }
  public function launchcombinePrayerSearch($query_string, $second_filters){
    $michPrayers = $this->getcombineMichPrayers($query_string, $second_filters);
    $gabPrayers = $this->getcombineGabPrayers($query_string, $second_filters);
    $raphPrayers = $this->getcombineRaphPrayers($query_string, $second_filters);
    $ourPrayers = $this->getcombineOurPrayers($query_string, $second_filters);
    $res = new stdClass();
    $res->error = false;
    $res->message = "";
    $res->prayers_total = 0;
    $res->results_total = 0;
    $res->occurrences = [];
    $res->content = [];

    //mergin arrays
    $tempContent = array_merge($michPrayers, $gabPrayers, $raphPrayers, $ourPrayers);
    $prData = $this->countPrayersOccDefault($tempContent, $query_string);
    $res->prayers_total = $prData->prayers_total;
    $res->occurrences = $prData->tempPrayersOcc;
    $res->content = $prData->tempPrayers;
    $res->results_total = count($res->occurrences);
    echo json_encode($res);
  }

  /*
  * * To build combine seaches statments
  */
  public function buildCombineSimpleDefaultStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    //
    $stmt = "SELECT * FROM psaumes WHERE (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildcombineMichPsaumesStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrq3u8ej61rm7upmu0' OR id_livre = 'c4lrt1u8ej61uu70m3qg' OR id_livre = 'c4lrtpu8ej62b50tbsng' OR id_livre = 'c4lruje8ej61vc45uu60' OR id_livre = 'c4ls0b68ej62im4otvr0' OR id_livre = 'c4ls15u8ej62i71q59t0' OR id_livre = 'c4ls1o68ej61r55bu7sg' OR id_livre = 'c4ls2fu8ej608p4k64m0' OR id_livre = 'c4ls37e8ej628n2j2p30' OR id_livre = 'c4ls4be8ej60l44t02lg' OR id_livre = 'c4ls50e8ej627t1952h0') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildcombineGabPsaumesStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsde8ej608b7ko800' OR id_livre = 'c4lrt9e8ej61gk0pdta0' OR id_livre = 'c4lru1e8ej60ca7v2htg' OR id_livre = 'c4lrvme8ej61jm0vrh70' OR id_livre = 'c4ls0ku8ej62ma3ouprg' OR id_livre = 'c4ls19m8ej61fv2qga5g' OR id_livre = 'c4ls1te8ej630g7okp3g' OR id_livre = 'c4ls2ke8ej60o73el04g' OR id_livre = 'c4ls3b68ej62lj2rcpmg' OR id_livre = 'c4ls4gu8ej62g46kbfsg' OR id_livre = 'c4ls54m8ej61ta4kvc70') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2')";
      return $stmt;
  }
  public function buildcombineRaphPsaumesStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrskm8ej62n16ma8j0' OR id_livre = 'c4lrte68ej611s5uq3gg' OR id_livre = 'c4lru7u8ej630n1gu6ng' OR id_livre = 'c4lrvse8ej62283342og' OR id_livre = 'c4ls0su8ej635r3ok4i0' OR id_livre = 'c4ls1cu8ej62dq741cd0' OR id_livre = 'c4ls24m8ej60a21vcsjg' OR id_livre = 'c4ls2tu8ej60vb69nklg' OR id_livre = 'c4ls3fu8ej60aq0utb1g' OR id_livre = 'c4ls4nu8ej619p77cn20' OR id_livre = 'c4ls58u8ej62cd08po30') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildcombineOurPsaumesStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsre8ej62g17ukqo0' OR id_livre = 'c4lrti68ej62ps2epkf0' OR id_livre = 'c4lrude8ej61752a3i3g' OR id_livre = 'c4ls06e8ej60k251v8rg' OR id_livre = 'c4ls1268ej620o47ppeg' OR id_livre = 'c4ls1h68ej62hd1siir0' OR id_livre = 'c4ls2c68ej62te35973g' OR id_livre = 'c4ls32m8ej61m415bbig' OR id_livre = 'c4ls3ou8ej60h30h390g' OR id_livre = 'c4ls4re8ej60v42e85sg' OR id_livre = 'c4ls5dm8ej620765h9ug') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildcombineMichPrayersStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrq3u8ej61rm7upmu0' OR id_livre = 'c4lrt1u8ej61uu70m3qg' OR id_livre = 'c4lrtpu8ej62b50tbsng' OR id_livre = 'c4lruje8ej61vc45uu60' OR id_livre = 'c4ls0b68ej62im4otvr0' OR id_livre = 'c4ls15u8ej62i71q59t0' OR id_livre = 'c4ls1o68ej61r55bu7sg' OR id_livre = 'c4ls2fu8ej608p4k64m0' OR id_livre = 'c4ls37e8ej628n2j2p30' OR id_livre = 'c4ls4be8ej60l44t02lg' OR id_livre = 'c4ls50e8ej627t1952h0') AND (contenu_priere REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildcombineGabPrayersStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsde8ej608b7ko800' OR id_livre = 'c4lrt9e8ej61gk0pdta0' OR id_livre = 'c4lru1e8ej60ca7v2htg' OR id_livre = 'c4lrvme8ej61jm0vrh70' OR id_livre = 'c4ls0ku8ej62ma3ouprg' OR id_livre = 'c4ls19m8ej61fv2qga5g' OR id_livre = 'c4ls1te8ej630g7okp3g' OR id_livre = 'c4ls2ke8ej60o73el04g' OR id_livre = 'c4ls3b68ej62lj2rcpmg' OR id_livre = 'c4ls4gu8ej62g46kbfsg' OR id_livre = 'c4ls54m8ej61ta4kvc70') AND (contenu_priere REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildcombineRaphPrayersStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrskm8ej62n16ma8j0' OR id_livre = 'c4lrte68ej611s5uq3gg' OR id_livre = 'c4lru7u8ej630n1gu6ng' OR id_livre = 'c4lrvse8ej62283342og' OR id_livre = 'c4ls0su8ej635r3ok4i0' OR id_livre = 'c4ls1cu8ej62dq741cd0' OR id_livre = 'c4ls24m8ej60a21vcsjg' OR id_livre = 'c4ls2tu8ej60vb69nklg' OR id_livre = 'c4ls3fu8ej60aq0utb1g' OR id_livre = 'c4ls4nu8ej619p77cn20' OR id_livre = 'c4ls58u8ej62cd08po30') AND (contenu_priere REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildcombineOurPrayersStmt($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsre8ej62g17ukqo0' OR id_livre = 'c4lrti68ej62ps2epkf0' OR id_livre = 'c4lrude8ej61752a3i3g' OR id_livre = 'c4ls06e8ej60k251v8rg' OR id_livre = 'c4ls1268ej620o47ppeg' OR id_livre = 'c4ls1h68ej62hd1siir0' OR id_livre = 'c4ls2c68ej62te35973g' OR id_livre = 'c4ls32m8ej61m415bbig' OR id_livre = 'c4ls3ou8ej60h30h390g' OR id_livre = 'c4ls4re8ej60v42e85sg' OR id_livre = 'c4ls5dm8ej620765h9ug') AND (contenu_priere REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  //psaumes and prayers
  public function buildMichCombinePsaumesAndPrayers($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrq3u8ej61rm7upmu0' OR id_livre = 'c4lrt1u8ej61uu70m3qg' OR id_livre = 'c4lrtpu8ej62b50tbsng' OR id_livre = 'c4lruje8ej61vc45uu60' OR id_livre = 'c4ls0b68ej62im4otvr0' OR id_livre = 'c4ls15u8ej62i71q59t0' OR id_livre = 'c4ls1o68ej61r55bu7sg' OR id_livre = 'c4ls2fu8ej608p4k64m0' OR id_livre = 'c4ls37e8ej628n2j2p30' OR id_livre = 'c4ls4be8ej60l44t02lg' OR id_livre = 'c4ls50e8ej627t1952h0') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildGabCombinePsaumesAndPrayers($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsde8ej608b7ko800' OR id_livre = 'c4lrt9e8ej61gk0pdta0' OR id_livre = 'c4lru1e8ej60ca7v2htg' OR id_livre = 'c4lrvme8ej61jm0vrh70' OR id_livre = 'c4ls0ku8ej62ma3ouprg' OR id_livre = 'c4ls19m8ej61fv2qga5g' OR id_livre = 'c4ls1te8ej630g7okp3g' OR id_livre = 'c4ls2ke8ej60o73el04g' OR id_livre = 'c4ls3b68ej62lj2rcpmg' OR id_livre = 'c4ls4gu8ej62g46kbfsg' OR id_livre = 'c4ls54m8ej61ta4kvc70') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  public function buildRaphCombinePsaumesAndPrayers($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrskm8ej62n16ma8j0' OR id_livre = 'c4lrte68ej611s5uq3gg' OR id_livre = 'c4lru7u8ej630n1gu6ng' OR id_livre = 'c4lrvse8ej62283342og' OR id_livre = 'c4ls0su8ej635r3ok4i0' OR id_livre = 'c4ls1cu8ej62dq741cd0' OR id_livre = 'c4ls24m8ej60a21vcsjg' OR id_livre = 'c4ls2tu8ej60vb69nklg' OR id_livre = 'c4ls3fu8ej60aq0utb1g' OR id_livre = 'c4ls4nu8ej619p77cn20' OR id_livre = 'c4ls58u8ej62cd08po30') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }

  public function buildOurCombinePsaumesAndPrayers($query_str){
    $string_1 = $this->sanitize($query_str[0]);
    $string_2 = $this->sanitize($query_str[1]);
    $reg_1 = '[[:<:]]'.$string_1.'[[:>:]]';
    $reg_2 = '[[:<:]]'.$string_2.'[[:>:]]';
    $stmt = "SELECT * FROM psaumes WHERE (id_livre = 'c4lrsre8ej62g17ukqo0' OR id_livre = 'c4lrti68ej62ps2epkf0' OR id_livre = 'c4lrude8ej61752a3i3g' OR id_livre = 'c4ls06e8ej60k251v8rg' OR id_livre = 'c4ls1268ej620o47ppeg' OR id_livre = 'c4ls1h68ej62hd1siir0' OR id_livre = 'c4ls2c68ej62te35973g' OR id_livre = 'c4ls32m8ej61m415bbig' OR id_livre = 'c4ls3ou8ej60h30h390g' OR id_livre = 'c4ls4re8ej60v42e85sg' OR id_livre = 'c4ls5dm8ej620765h9ug') AND (nom_psaume REGEXP '$reg_1' OR contenu_psaume REGEXP '$reg_1' OR contenu_priere REGEXP '$reg_1' OR nom_psaume REGEXP '$reg_2' OR contenu_psaume REGEXP '$reg_2' OR contenu_priere REGEXP '$reg_2')";
    return $stmt;
  }
  /*
  * * To get psaumes
  */
  public function getcombineMichPsaumes($str, $secondFilters){
    if(in_array('michael', $secondFilters)){
      $stmt = $this->buildcombineMichPsaumesStmt($str);
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
  public function getcombineGabPsaumes($str, $secondFilters){
    if(in_array('gabriel', $secondFilters)){
      $stmt = $this->buildcombineGabPsaumesStmt($str);
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
  public function getcombineRaphPsaumes($str, $secondFilters){
    if(in_array('raphael', $secondFilters)){
      $stmt = $this->buildcombineRaphPsaumesStmt($str);
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
  public function getcombineOurPsaumes($str, $secondFilters){
    if(in_array('ouriel', $secondFilters)){
      $stmt = $this->buildcombineOurPsaumesStmt($str);
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
  * * To get prayers
  */
  public function getcombineMichPrayers($query_string, $second_filters){
    if(in_array('michael', $second_filters)){
      $stmt = $this->buildcombineMichPrayersStmt($query_string);
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
  public function getcombineGabPrayers($query_string, $second_filters){
    if(in_array('gabriel', $second_filters)){
      $stmt = $this->buildcombineGabPrayersStmt($query_string);
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
  public function getcombineRaphPrayers($query_string, $second_filters){
    if(in_array('raphael', $second_filters)){
      $stmt = $this->buildcombineRaphPrayersStmt($query_string);
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
  public function getcombineOurPrayers($query_string, $second_filters){
    if(in_array('ouriel', $second_filters)){
      $stmt = $this->buildcombineOurPrayersStmt($query_string);
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
  * * To get psaumes and prayers
  */
  public function getCombineMichPsaumesAndPrayers($str, $secondFilters){
    if(in_array('michael', $secondFilters)){
      $stmt = $this->buildMichCombinePsaumesAndPrayers($str);
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
  public function getCombineGabPsaumesAndPrayers($str, $secondFilters){
    if(in_array('gabriel', $secondFilters)){
      $stmt = $this->buildGabCombinePsaumesAndPrayers($str);
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
  public function getCombineRaphPsaumesAndPrayers($str, $secondFilters){
    if(in_array('raphael', $secondFilters)){
      $stmt = $this->buildRaphCombinePsaumesAndPrayers($str);
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
  public function getCombineOurPsaumesAndPrayers($str, $secondFilters){
    if(in_array('ouriel', $secondFilters)){
      $stmt = $this->buildOurCombinePsaumesAndPrayers($str);
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
  * * To count occurrences
  */
  public function countThis($content, $str){
    $check_pattern = '/[a-zA-Z]/';
    $query_pattern = "/\b".$str."\b/iu";
    if(preg_match($check_pattern , $str)){
      $count = preg_match_all($query_pattern, $content);
      return $count;
    }else{
      return 0;
    }
  }
  public function countOccurrencesDefault($tempContent, $query_string){
    $tempPsaumePsaumesAndPrayers = [];
    $tempPsaumePsaumesAndPrayersOcc = [];
    $psaumes_total = 0;
    $prayers_total = 0;
    $psaumes_and_prayers_total = 0;
    //
    $arrLength = count($tempContent);
    $str_1 = trim($query_string[0]);
    $str_2 = trim($query_string[1]);
    //
    $res = new stdClass();
    $res->psaumes_total = 0;
    $res->prayers_total = 0;
    $res->psaumes_and_prayers_total = 0;
    $res->tempPsaumePsaumesAndPrayersOcc = [];
    $res->tempPsaumePsaumesAndPrayers = [];

    for ($i=0; $i < $arrLength; $i++) {
      //str 1
      $occ_name_str_1 = $this->countThis($tempContent[$i]["nom_psaume"], $str_1);
      $occ_psaume_str_1 = $this->countThis($tempContent[$i]["contenu_psaume"], $str_1);
      $occ_prayer_str_1 = $this->countThis($tempContent[$i]["contenu_priere"], $str_1);
      $tempContent[$i]["occ_psaume_str_1"] = $occ_name_str_1 + $occ_psaume_str_1;
      $tempContent[$i]["occ_priere_str_1"] = $occ_prayer_str_1;
      $tempContent[$i]["occ_total_str_1"] = $occ_name_str_1 + $occ_psaume_str_1 + $occ_prayer_str_1;
      //update totals
      $str_1_psaume_total = $occ_name_str_1 + $occ_psaume_str_1;
      $psaumes_total+= $str_1_psaume_total;
      $prayers_total+= $occ_prayer_str_1;
      //str_2
      $occ_name_str_2 = $this->countThis($tempContent[$i]["nom_psaume"], $str_2);
      $occ_psaume_str_2 = $this->countThis($tempContent[$i]["contenu_psaume"], $str_2);
      $occ_prayer_str_2 = $this->countThis($tempContent[$i]["contenu_priere"], $str_2);
      $tempContent[$i]["occ_psaume_str_2"] = $occ_name_str_2 + $occ_psaume_str_2;
      $tempContent[$i]["occ_priere_str_2"] = $occ_prayer_str_2;
      $tempContent[$i]["occ_total_str_2"] = $occ_name_str_2 + $occ_psaume_str_2 + $occ_prayer_str_2;
      //update totals
      $str_2_psaume_total = $occ_name_str_2 + $occ_psaume_str_2;
      $psaumes_total+= $str_2_psaume_total;
      $prayers_total+= $occ_prayer_str_2;
      //total for the two str
      $tempContent[$i]["occ_total"] = $tempContent[$i]["occ_total_str_1"] + $tempContent[$i]["occ_total_str_2"];
      //
      $random_nbr = $this->generateRandomNbr();
      $total = $occ_name_str_1 + $occ_psaume_str_1 + $occ_prayer_str_1 + $occ_name_str_2 + $occ_psaume_str_2 + $occ_prayer_str_2;
      $token = "".$total.".".$random_nbr."";
      $unique_total = floatval($token);
      $tempContent[$i]["random_nbr"] = $random_nbr;
      $tempContent[$i]["token"] = $token;
      //
      array_push($tempPsaumePsaumesAndPrayers, $tempContent[$i]);
      array_push($tempPsaumePsaumesAndPrayersOcc, $unique_total);
      //
    }
    $res->psaumes_total = $psaumes_total;
    $res->prayers_total = $prayers_total;
    $res->psaumes_and_prayers_total = $psaumes_total + $prayers_total;
    $res->tempPsaumePsaumesAndPrayersOcc = $tempPsaumePsaumesAndPrayersOcc;
    $res->tempPsaumePsaumesAndPrayers = $tempPsaumePsaumesAndPrayers;
    return $res;
  }
  public function countPsaumesOccDefault($tempContent, $query_string){
    $tempPsaumes = [];
    $tempPsaumesOcc = [];
    $psaumes_total = 0;
    //
    $res = new stdClass();
    $res->tempPsaumesOcc = [];
    $res->tempPsaumes = [];
    $res->psaumes_total = 0;
    //
    $arrLength = count($tempContent);
    $str_1 = trim($query_string[0]);
    $str_2 = trim($query_string[1]);
    //
    for ($i=0; $i < $arrLength; $i++) {
      //str_1
      $occ_name_str_1 = $this->countThis($tempContent[$i]["nom_psaume"], $str_1);
      $occ_psaume_str_1 = $this->countThis($tempContent[$i]["contenu_psaume"], $str_1);
      $tempContent[$i]["occ_psaume_str_1"] = $occ_name_str_1 + $occ_psaume_str_1;
      //update totals
      $psaumes_total+= $occ_psaume_str_1;
      $psaumes_total+= $occ_name_str_1;
      //str_2
      $occ_name_str_2 = $this->countThis($tempContent[$i]["nom_psaume"], $str_2);
      $occ_psaume_str_2 = $this->countThis($tempContent[$i]["contenu_psaume"], $str_2);
      $tempContent[$i]["occ_psaume_str_2"] = $occ_name_str_2 + $occ_psaume_str_2;
      //update totals
      $psaumes_total+= $occ_psaume_str_2;
      $psaumes_total+= $occ_name_str_2;
      //set total
      $tempContent[$i]["occ_total"] = $tempContent[$i]["occ_psaume_str_1"] + $tempContent[$i]["occ_psaume_str_2"];
      //
      $random_nbr = $this->generateRandomNbr();
      $total = $tempContent[$i]["occ_total"];
      $token = "".$total.".".$random_nbr."";
      $unique_total = floatval($token);
      $tempContent[$i]["random_nbr"] = $random_nbr;
      $tempContent[$i]["token"] = $token;
      //
      array_push($tempPsaumes, $tempContent[$i]);
      array_push($tempPsaumesOcc, $unique_total);
    }

    $res->tempPsaumesOcc = $tempPsaumesOcc;
    $res->tempPsaumes = $tempPsaumes;
    $res->psaumes_total = $psaumes_total;
    return $res;
  }
  public function countPrayersOccDefault($tempContent, $query_string){
    $tempPrayers = [];
    $tempPrayersOcc = [];
    $prayers_total = 0;
    //
    $arrLength = count($tempContent);
    $str_1 = trim($query_string[0]);
    $str_2 = trim($query_string[1]);
    //
    $res = new stdClass();
    $res->prayers_total = 0;
    $res->tempPrayersOcc = [];
    $res->tempPrayers = [];
    //
    for ($i=0; $i < $arrLength; $i++) {
      //str_1
      $occ_prayer_str_1 = $this->countThis($tempContent[$i]["contenu_priere"], $str_1);
      $tempContent[$i]["occ_priere_str_1"] = $occ_prayer_str_1;
      //update totals
      $prayers_total+= $occ_prayer_str_1;
      //str_2
      $occ_prayer_str_2 = $this->countThis($tempContent[$i]["contenu_priere"], $str_2);
      $tempContent[$i]["occ_priere_str_2"] = $occ_prayer_str_2;
      //update totals
      $prayers_total+= $occ_prayer_str_2;
      //set total
      $tempContent[$i]["occ_total"] = $occ_prayer_str_1 + $occ_prayer_str_2;
      //
      $random_nbr = $this->generateRandomNbr();
      $total = $tempContent[$i]["occ_total"];
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
}
