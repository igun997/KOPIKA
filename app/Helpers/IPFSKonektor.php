<?php
namespace Helpers;

/**
 * IPFS Konektor
 */
class IPFSKonektor
{
  public $gatewayIP;
  public $gatewayPort;
  public $gatewayApiPort;
  public $ipfs;
  public $base58;
  function __construct($addr,$gateway,$api)
  {
    $this->gatewayIP = $addr;
    $this->gatewayPort = $gateway;
    $this->gatewayApiPort = $api;
    $this->base58 = new \StephenHill\Base58();
  }
  public function cat ($hash) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayPort;
		return json_decode($this->curl("http://$ip:$port/ipfs/$hash"));
	}
  public function decodeMemo($hash='')
  {
    return bin2hex(base64_decode($hash));
  }
  public function encodeSha($hash='')
  {
    $r = hex2bin($hash);
    $t = $this->base58->encode(chr(0x12).chr(strlen($r)).$r);
    return $t;
  }
	public function add ($content) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;
		$req = $this->curl("http://$ip:$port/api/v0/add?stream-channels=true", $content);
		$req = json_decode($req, TRUE);
    $t = $req['Hash'];
    $m = ( $this->base58->decode($t) );
    return bin2hex(substr($m,2));
		// return $req['Hash'];
	}
	public function ls ($hash) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;
		$response = $this->curl("http://$ip:$port/api/v0/ls/$hash");
		$data = json_decode($response, TRUE);
		return $data['Objects'][0]['Links'];
	}
	public function size ($hash) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;
		$response = $this->curl("http://$ip:$port/api/v0/object/stat/$hash");
		$data = json_decode($response, TRUE);
		return $data['CumulativeSize'];
	}
	public function pinAdd ($hash) {

		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;
		$response = $this->curl("http://$ip:$port/api/v0/pin/add/$hash");
		$data = json_decode($response, TRUE);
		return $data;
	}

	public function pinRm ($hash) {

		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;
		$response = $this->curl("http://$ip:$port/api/v0/pin/rm/$hash");
		$data = json_decode($response, TRUE);
		return $data;
	}

	public function version () {

		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;
		$response = $this->curl("http://$ip:$port/api/v0/version");
		$data = json_decode($response, TRUE);
		return $data['Version'];
	}

	public function id () {

		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;
		$response = $this->curl("http://$ip:$port/api/v0/id");
		$data = json_decode($response, TRUE);
		return $data;
	}
  private function curl ($url, $data = "") {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);

    if ($data != "") {
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; boundary=a831rwxi1a3gzaorw1w2z49dlsor'));
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "--a831rwxi1a3gzaorw1w2z49dlsor\r\nContent-Type: application/octet-stream\r\nContent-Disposition: file; \r\n\r\n" . $data . "\r\n--a831rwxi1a3gzaorw1w2z49dlsor");
    }
    $output = curl_exec($ch);
    if ($output == FALSE) {
      //todo: when ipfs doesn't answer
    }
    curl_close($ch);

    return $output;
  }
}
