<?php
namespace Helpers;
use \ZuluCrypto\StellarSdk\Server;
use \phpseclib\Math\BigInteger;
use \ZuluCrypto\StellarSdk\Horizon\ApiClient;
use \ZuluCrypto\StellarSdk\Model\Operation;
use \ZuluCrypto\StellarSdk\Keypair;
/**
 * Stellar Wrapper ZuluCrypto
 */
class StellarWrap
{
  public $server;
  public $originSk;
  public $originPk;
  public $destinationPk;
  public $asset = "xlm";
  function __construct()
  {
    $this->server = Server::publicNet();
    // if ($type !=  "public") {
    // }
  }
  public function setOrigin($sk="",$pk="")
  {
    $getPk = Keypair::newFromSeed($sk);
    $pk = $getPk->getPublicKey();
    // $cek = $this->server->accountExists($pk);
    // if ($cek) {
      $this->originSk = $sk;
      $this->originPk = $pk;
      // return $cek;
    // }else {
      // return false;
    // }
  }
  public function setDestination($pk="")
  {
    $cek = $this->server->accountExists($pk);
    // if ($cek) {
      $this->destinationPk = $pk;
      // return $cek;
    // }else {
      // return false;
    // }
  }
  public function instance()
  {
    return $this->server;
  }
  public function setAsset($symbol='',$pkIssuer='')
  {
     $this->asset = Asset::newCustomAsset($symbol, $pkIssuer);
  }
  public function send($qty,$memo=null)
  {
    $sourceKeypair = Keypair::newFromSeed($this->originSk);
    $destinationKeypair = Keypair::newFromPublicKey($this->destinationPk);
    if ($this->asset == "xlm") {
      if ($memo != null) {
        $txEnvelope = $this->server->buildTransaction($sourceKeypair)
        ->setTextMemo($memo)
        ->addLumenPayment($destinationKeypair, $qty)
        ->getTransactionEnvelope();
      }else {
        $txEnvelope = $this->server->buildTransaction($sourceKeypair)
        ->addLumenPayment($destinationKeypair, $qty)
        ->getTransactionEnvelope();
      }
      $txEnvelope->sign($sourceKeypair);
      $b64Tx = base64_encode($txEnvelope->toXdr());
    }else {
      if ($memo != null) {
        $txEnvelope = $this->server->buildTransaction($sourceKeypair)
        ->setTextMemo($memo)
        ->addCustomAssetPaymentOp($this->base, $qty,$destinationKeypair)
        ->getTransactionEnvelope();
      }else {
        $txEnvelope = $this->server->buildTransaction($sourceKeypair)
        ->addCustomAssetPaymentOp($this->base, $qty,$destinationKeypair)
        ->getTransactionEnvelope();
      }
      $txEnvelope->sign($sourceKeypair);
      $b64Tx = base64_encode($txEnvelope->toXdr());
    }
    return $this->server->submitB64Transaction($b64Tx);
  }

}
 ?>
