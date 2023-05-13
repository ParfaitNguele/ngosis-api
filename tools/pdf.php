<?php
require_once __DIR__ . '/vendor/autoload.php';

//Listening to post request
if(isset($_POST)){
  $json = file_get_contents('php://input');
  $data = json_decode($json);
  createDoc($data);
}

function createDoc($data){
  $mpdf = new \Mpdf\Mpdf();
  if($data){
    //setting document title
    $docTitle = setDocTitle($data);
    //building the file
    $psaumeTitle = "<h2 class='".$data->psaume_statut."'>".$data->psaume_title."</h2>";
    $psaumeBody = "<div class='psaume_body ".$data->psaume_statut."'>".$data->psaume_body."</div>";
    $prayerTitle = "<h2 class='".$data->prayer_statut."'>".$data->prayer_title."</h2>";
    $prayerBody = "<div class='prayer_body ".$data->prayer_statut."'>".$data->prayer_body."</div>";
    $docBody = "<body>".$psaumeTitle.$psaumeBody.$prayerTitle.$prayerBody."</body>";
    $docStart = '<!DOCTYPE html><html lang="fr" dir="ltr"><head><link rel="stylesheet" href="styles/doc.css"><title>'.$docTitle.'</title></head>';
    $docEnd = '</html>';
    $doc = $docStart.$docBody.$docEnd;
    $mpdf->WriteHTML($doc);
    //seting file name
    $docName = createDocName();
    //res obj
    $res = new stdClass();
    $res->filename = "";
    //make sure the pdf is saved
    $mpdf->Output('temp/'.$docName, \Mpdf\Output\Destination::FILE);
    $res->filename = $docName;
    echo json_encode($res);
  }
}
function setDocTitle($data){
  $title = "";
  if($data){
    if($data->psaume_statut === "display" && $data->prayer_statut === "display"){
      $title = $data->psaume_title;
    }else{
      if($data->psaume_statut === "display" && $data->prayer_statut === "hidden"){
        $title = $data->psaume_title;
      }else{
        $title = $data->prayer_title;
      }
    }
  }
  $pattern = '/<br\/>/i';
  $newTitle = preg_replace($pattern, '', $title);
  return $newTitle;
}
function createDocName(){
  $str_base = "nabbqejbbvsvgfgdpoityetccnfbfjqeadsczvgrtepfjncnbdbghhdzcntpqus";
  $time = time();
  $random_str = substr(str_shuffle($str_base), 0, 10);
  $random_name = $time.$random_str.".pdf";
  return $random_name;
}
