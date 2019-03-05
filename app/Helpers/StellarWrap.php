<?php
namespace Helpers;
use \ZuluCrypto\StellarSdk\Server;
use \phpseclib\Math\BigInteger;
use \ZuluCrypto\StellarSdk\Horizon\ApiClient;
use \ZuluCrypto\StellarSdk\Model\Operation;
use \ZuluCrypto\StellarSdk\Keypair;
use \ZuluCrypto\StellarSdk\XdrModel\Memo;
use \ZuluCrypto\StellarSdk\Model\Transaction;
use ZuluCrypto\StellarSdk\Model\Payment;
use \ZuluCrypto\StellarSdk\XdrModel\Asset;
/**
 * Stellar Wrapper ZuluCrypto
 */
class StellarWrap
{
  public $server;
  public $originSk;
  public $originPk;
  public $apiClient;
  public $destinationPk;
  public $asset = "xlm";
  public $horizon = "https://horizon-testnet.stellar.org";
  function __construct()
  {
    $this->server = Server::testNet();
    $this->apiClient = new apiClient($this->horizon,null);
    // if ($type !=  "public") {
    // }
  }
  public function getHorizon()
  {
    return $this->horizon;
  }
  public function setOrigin($sk="")
  {
    $getPk = Keypair::newFromSeed($sk);
    $pk = $getPk->getPublicKey();
    $cek = $this->server->accountExists($pk);
    if ($cek) {
      $this->originSk = $sk;
      $this->originPk = $pk;
      return $cek;
    }else {
      return false;
    }
  }
  public function setDestination($pk="")
  {
    $cek = $this->server->accountExists($pk);
    if ($cek) {
      $this->destinationPk = $pk;
      return $cek;
    }else {
      return false;
    }
  }
  public function streamTranscation($account='')
  {
    $cek = $this->server->accountExists($account);
    if ($cek) {
      $url = sprintf('/accounts/%s/transactions?order=desc&cursor=now&limit=200', $account);
      $response = $this->apiClient->get($url);
      return $response->getRecords();
    }else {
      return [];
    }
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
    $destinationKeypair = $this->destinationPk;
    if ($this->asset == "xlm") {
      if ($memo != null) {
        $txEnvelope = $this->server->buildTransaction($sourceKeypair)
        ->setMemo(new Memo(Memo::MEMO_TYPE_HASH, $memo))
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
        ->setMemo(new Memo(Memo::MEMO_TYPE_HASH, $memo))
        ->addCustomAssetPaymentOp($this->asset, $qty,$destinationKeypair)
        ->getTransactionEnvelope();
      }else {
        $txEnvelope = $this->server->buildTransaction($sourceKeypair)
        ->addCustomAssetPaymentOp($this->asset, $qty,$destinationKeypair)
        ->getTransactionEnvelope();
      }
      $txEnvelope->sign($sourceKeypair);
      $b64Tx = base64_encode($txEnvelope->toXdr());
    }
    return $this->server->submitB64Transaction($b64Tx);
  }

}
 ?>
