<?php
function datatablesConvert($res=[],$select="")
{
  $data = [];
  $data["data"] = [];
  foreach ($res as $key => $value) {
    $inner = [];
    $exp = explode(",",$select);
    foreach ($exp as $k => $v) {
      $inner[] = $value["$v"];
    }
    $data["data"][] = $inner;
  }
  return $data;
}
function select2Convert($data=[],$op=[])
{
  $s = [];
  $s[] = ["text"=>"== Pilih ==","id"=>""];
  foreach ($data as $key => $value) {
    $s[] = ["text"=>$value[$op["text"]],"id"=>$value[$op["id"]]];
  }
  return $s;
}
function alpha()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pin = mt_rand(1000000, 9999999)
        . mt_rand(1000000, 9999999)
        . $characters[rand(0, strlen($characters) - 1)];
    $string = str_shuffle($pin);
    return $string;
}
function stylePack($type='style')
{
  $symbol = explode("symbol","\symbol");
  $symbol = $symbol[0];
  $baseassets = str_replace($symbol,"/",base_path())."/style/";
  if (!file_exists($baseassets.$type)) {
    exit("Default Style Wrong");
    die();
  }
  $readfile = file_get_contents($baseassets.$type);
  $readfile = explode("[CSS]",$readfile);
  $readfile = explode("[JS]",$readfile[1]);
  $css = explode("\n",$readfile[0]);
  $js = explode("\n",$readfile[1]);
  foreach ($js as $key => &$value) {
    if ($value == "" || $value == "\n" || $value == "\r") {
      unset($js[$key]);
    }
  }
  foreach ($css as $key => &$value) {
    if ($value == "" || $value == "\n" || $value == "\r") {
      unset($css[$key]);
    }
  }
  foreach ($css as $key => &$value) {
    $baseexp = explode("-|",$value);
    if (count($baseexp) > 1) {
      $value = '<link rel="stylesheet" href="'.url($baseexp[1]).'">';
    }else {
      $value = '<link rel="stylesheet" href="'.str_replace("\n","",$value).'">';
    }
  }
  foreach ($js as $key => &$value) {
    $baseexp = explode("-|",$value);
    if (count($baseexp) > 1) {
      $value = '<script src="'.url($baseexp[1]).'"></script>';
    }else {
      $value = '<script src="'.str_replace("\n","",$value).'"></script>';
    }
  }
  return ["css"=>implode("\n",$css),"js"=>implode("\n",$js)];
}
