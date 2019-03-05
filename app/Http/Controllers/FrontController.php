<?php

namespace Kopika\Http\Controllers;
use Helpers\ArtikeHelper;
use Helpers\IPFSKonektor;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public $article;
    public function __construct()
    {

      $this->article = new ArtikeHelper(new IPFSKonektor(env("NODE_ADDRESS",""),env("NODE_GT_PORT",""),env("NODE_API_PORT","")));
    }
    public function index()
    {
      $data = $this->article->stream(env("MAIN_ARTICLE",""));
      return view("front.pages.home")->with(["title"=>"KOPIKA Recipes Board","data"=>$data]);
    }
    public function getrecipe(Request $req,$id)
    {
      $get = $this->article->get($id);
      if ($get != null) {
        return view("front.pages.recipe")->with(["title"=>"Recipes- {$get->recipe_name}","data"=>$get]);
      }else {
        return redirect("/404");
      }
    }
}
