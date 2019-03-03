<?php

namespace Kopika\Http\Controllers;
use Helpers\IPFSKonektor;
use Helpers\ArtikeHelper;
use Helpers\StellarWrap;
use \ZuluCrypto\StellarSdk\Server;
use \phpseclib\Math\BigInteger;
use \ZuluCrypto\StellarSdk\Horizon\ApiClient;
use \ZuluCrypto\StellarSdk\Model\Operation;
use \ZuluCrypto\StellarSdk\Keypair;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public $article;
    public $ipfs;
    public function __construct()
    {
        $this->ipfs = new IPFSKonektor("134.209.104.197","8080","5001");
        $this->article = new ArtikeHelper($this->ipfs);
    }
    public function index()
    {
      // $obj = $this->ipfs;
      // $data = [
      //   "author"=>"GDCNB7WG4BC3GR6SRZIHFZSATTLIIYAQEOXVVY33NIAXX6HN6UNMFHDY",
      //   "recipe_name"=>"Roti Panggang",
      //   "note"=>"Catatan",
      //   "pict"=>"base64",
      //   "created_at"=>date("Y-m-d H:i:s"),
      //   "difficulty"=>3,
      //   "servings"=>1,
      //   "ingredients"=>[["name"=>"Eggs","qty"=>1]],
      //   "direction"=>["Step 1","Step 2","Step 3"]
      // ];
      // $submit = $this->article->submit($data);
      // return response()->json($obj->cat("QmYymVCBaeKS199ZrQcatFjyt9xHR73Mwju75wfhroL57v"));
      // return response()->json(["status"=>0])
      $xlm = new StellarWrap();
      $ins = $xlm->instance();
      // $res = Keypair::newFromSeed("XX");
      $xlm->setOrigin("XXXX");
      $xlm->setDestination("XXXX");
      $res = $xlm->send(0.1,"test send IPFS");
      return response()->json($res);

    }

}
