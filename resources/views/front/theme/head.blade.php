<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Basic meta info
  ==================== -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{$title}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{url('/assets/icon/logo.png')}}">
  <!-- CSS files
  ============== -->
  {!!(stylePack("style_front"))["css"]!!}


</head>

<body>

  <!-- Splash Screen
  ================== -->
  <div id="splash"></div>

  <!-- Website Logo
  ================= -->
  <section id="logo">
    <div class="container text-center wow pulse">
      <img src="{{url('/assets/icon/logo.png')}}" style="width:100px;height:100px" alt="logo" />
      <br />
      <h1>KOPIKA Recipe Repository</h1>
    </div>
  </section>

  <!-- Recipes Categories
  ======================= -->
  <section id="categories">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2>Categories</h2>
        </div>
      </div>

      <div class="row wow zoomIn">
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
          <div class="category-item text-center">
            <i class="fa fa-coffee fa-4x"></i>
            <br />
            Coffee
          </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
          <div class="category-item text-center">
            <i class="fa fa-cutlery fa-4x"></i>
            <br />
            Foods
          </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
          <div class="category-item text-center">
            <i class="fa fa-beer fa-4x"></i>
            <br />
            Drink
          </div>
        </div>
      </div>
    </div>
  </section>
