<?php

require_once "../models/search.model.php";

$searchClass = new Search();

//POST REQUESTS
if(isset($_POST)){
  $json = file_get_contents('php://input');
  $data = json_decode($json);
  $searchClass->launchSearch($data);
}

/*
  * * DO NOT DELETE OR UNCOMMENT..
  * * It is for quick tests
*/


/*$data = new stdClass();
$data->query_string = 'dieux';
$data->auth_name = 'seen';
$data->auth_value = 'NKsGZ1ep22S8BEDFNIML';
$data->main_filters = ["psaumes", "prayers"];
$data->second_filters = ["michael", "gabriel","raphael", "ouriel"];
$searchClass->launchSearch($data);*/
