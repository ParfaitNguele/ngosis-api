<?php

require_once "../models/digit-search.model.php";

$digitSearchClass = new DigitSearch();

//POST REQUESTS
if(isset($_POST)){
  $json = file_get_contents('php://input');
  $data = json_decode($json);
  $digitSearchClass->launchDigitSearch($data);
}

/*
  * * DO NOT DELETE OR UNCOMMENT..
  * * It is for quick tests
*/

/*$data = new stdClass();
$data->query_string = '6';
$data->auth_name = 'dise';
$data->auth_value = 'ONsHZ8fp8299AEQRNFNN';
$data->main_filters = ["psaumes", "prayers"];
$data->second_filters = ["michael", "gabriel","raphael", "ouriel"];
$digitSearchClass->launchDigitSearch($data);*/
