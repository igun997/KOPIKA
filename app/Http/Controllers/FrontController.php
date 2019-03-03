<?php

namespace Kopika\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
      return view("front.pages.home")->with(["title"=>"KOPIKA Recipes Board"]);
    }
}
