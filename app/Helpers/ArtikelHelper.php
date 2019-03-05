<?php
namespace Helpers;
use Helpers\StellarWrap;
use Helpers\IPFSKonektor;
/**
 * Resep
 */
class ArtikeHelper
{
  public $ipfs;
  public $horizon;
  public $xlm;
  function __construct($obj)
  {
    $this->ipfs = $obj;
    $this->xlm = new StellarWrap();
    $this->horizon = $this->xlm->getHorizon();
  }
  public function submit($data)
  {
    return $this->ipfs->add(json_encode($data));
  }
  public function get($hash='')
  {
    $res = $this->curl($this->horizon."/transactions/".$hash);
    $obj =  json_decode($res);
    if (!isset($obj->memo)) {
      return null;
    }
    $memo = $obj->memo;
    $cid = $this->ipfs->encodeSha($this->ipfs->decodeMemo($memo));
    $content = $this->ipfs->cat($cid);
    return $content;
    // return $cid;
  }
  public function stream($account='')
  {
    $data =  $this->xlm->streamTranscation($account);
    $article = [];
    foreach ($data as $key => $value) {
      if ($value["memo_type"] == "hash") {
          $cid = $this->ipfs->encodeSha($this->ipfs->decodeMemo($value["memo"]));
          $content = $this->ipfs->cat($cid);
          $content->hash = $value["hash"];
          if ($content != null) {
            $article[] = $content;
          }
      }
    }
    return $article;
  }
  private function curl ($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $output = curl_exec($ch);
    if ($output == FALSE) {
      //todo: when ipfs doesn't answer
    }
    curl_close($ch);

    return $output;
  }
}

?>
