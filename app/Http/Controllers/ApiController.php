<?php

namespace Kopika\Http\Controllers;
use Helpers\IPFSKonektor;
use Helpers\ArtikeHelper;
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
      $obj = $this->ipfs;
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
      return response()->json($obj->cat("QmYymVCBaeKS199ZrQcatFjyt9xHR73Mwju75wfhroL57v"));
    }
}
