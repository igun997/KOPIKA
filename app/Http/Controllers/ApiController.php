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
        $this->ipfs = new IPFSKonektor(env("NODE_ADDRESS",""),env("NODE_GT_PORT",""),env("NODE_API_PORT",""));
        $this->article = new ArtikeHelper($this->ipfs);
    }
    public function index()
    {
      // $obj = $this->ipfs;
      // $data = [
      //   "author"=>"Indra",
      //   "recipe_name"=>"Sample Recipes",
      //   "note"=>"Test With Pict",
      //   "pict"=>"",
      //   "time"=>date("H:i:s"),
      //   "created_at"=>date("Y-m-d H:i:s"),
      //   "difficulty"=>1,
      //   "servings"=>1,
      //   "ingredients"=>[["name"=>"Sample ingredients","qty"=>1]],
      //   "direction"=>["Step 1","Step 2","GStep 3"]
      // ];
      // $submit = $this->article->submit($data);
      // // echo $obj->encode("a4582ddad675e770e1ecf4a1930524fafd84f694351944a7484cbbd399d0f561");
      // // // return response()->json($obj->cat("QmYymVCBaeKS199ZrQcatFjyt9xHR73Mwju75wfhroL57v"));
      // // // return response()->json(["status"=>0])
      // $xlm = new StellarWrap();
      // $ins = $xlm->instance();
      // $xlm->setAsset(env("PAYMENT_SYMBOL"),env("PAYMENT_ISSUER"));
      // // // // $res = Keypair::newFromSeed("XX");
      // $cek1 = $xlm->setOrigin("SCOTHPZJXJ2OEYHLP3K2W3ITCEXJ4AFJ3VZNSTBG3T2HXJWSUSDN36PN");
      // $cek2 = $xlm->setDestination("GAZLELP7RSJ5TU3FDYLA2AE4QFUKSVWTOXQFJSCESI23J56PLXOIMORK");
      // if ($cek1 && $cek2) {
      //   $res = $xlm->send(0.1,hex2bin($submit));
      //   $operationResults = $res->getResult()->getOperationResults();
      //   if ($operationResults[0]->succeeded()) {
      //     return response()->json(["status"=>1,"msg"=>"succeess send","debug"=>($res->getRawData())["hash"]]);
      //   }else {
      //     return response()->json(["status"=>0,"msg"=>$operationResults[0]->getErrorCode()]);
      //   }
      // }else {
      //   return response()->json(["status"=>0,"msg"=>"Account not Exist"]);
      // }
      // // // return response()->json($res->getResult());
      // foreach ($operationResults as $operationResult) {
      //     // print "Operation result is a: " . get_class()) . PHP_EOL;
      //     var_dump($operationResult->succeeded());
      // }
      // var_dump($res);
      // echo $this->base58->encode("516d59745563346954436262665653444e4b76745171726679657a50506e467645333377466d757477395042426b");
      // $get = $this->article->get("228fb05d965e8e5859c85ad4b82b291e9b4580cbcc33b7598b1363d09fed6d49");
      // return response()->json(["status"=>0]);

    }
    public function getRecipes(Request $req)
    {
      $get = $this->article->stream($req->input("account"));
      return response()->json($get);
    }
    public function saveRecipes(Request $req)
    {
      $obj = $this->ipfs;
      $data = $req->all();
      $origin = $data["skOrigin"];
      $dest = $data["pkDestination"];
      $baseAmmout = $data["baseAmmout"];
      unset($data["skOrigin"]);
      unset($data["baseAmmout"]);
      unset($data["pkDestination"]);
      $submit = $this->article->submit($data);
      $xlm = new StellarWrap();
      $ins = $xlm->instance();
      $xlm->setAsset(env("PAYMENT_SYMBOL","TKKA"),env("PAYMENT_ISSUER","GDLQBMH33MSLWYEQITP6H2PKAJA3LJ3GZ3JXOWCB4S7HX6NATWM7M3KO"));
      $cek_origin = $xlm->setOrigin($origin);
      $cek_destination = $xlm->setDestination($dest);
      if ($cek_origin && $cek_destination) {
          $res = $xlm->send($baseAmmout,hex2bin($submit));
          $operationResults = $res->getResult()->getOperationResults();
          if ($operationResults[0]->succeeded()) {
            return response()->json(["status"=>1,"msg"=>"succeess send"]);
          }else {
            return response()->json(["status"=>0,"msg"=>$operationResults[0]->getErrorCode()]);
          }
      }else {
        return response()->json(["status"=>0,"msg"=>"Account Does'nt Exist on Stellar Networks"]);
      }
    }

}
