<?php

require_once "../models/combine-search.model.php";

$combineSearchClass = new CombineSearch();
//POST REQUESTS
if(isset($_POST)){
  $json = file_get_contents('php://input');
  $data = json_decode($json);
  $combineSearchClass->launchCombineSearch($data);
}

/*
  * * DO NOT DELETE OR UNCOMMENT..
  * * It is for quick tests
*/

/*$data = new stdClass();
$data->query_string = ['AMOUR', 'AMOURS'];
$data->auth_name = 'cose';
$data->auth_value = 'MLsHZ1fp62S9AEQFNFMM';
$data->main_filters = ["psaumes", "prayers"];
$data->second_filters = ["michael", "gabriel","raphael", "ouriel"];
$combineSearchClass->launchCombineSearch($data);*/
