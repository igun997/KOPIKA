@include("front.theme.head")
<!-- Recipes Items
================== -->
<section id="items">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2>Recipes</h2>
      </div>
    </div>
    <div class="row">
      @foreach($data as $k => $v)
      <div class="col-lg-4 col-md-6 col-sm-12 wow fadeIn">
        <a href="{{url("/getrecipe/".$v->hash)}}">
        <div class="recipe-item text-center">
            <img src="{{$v->pict}}" alt="{{$v->recipe_name}}" onerror="this.src='https://via.placeholder.com/500x500?text=No%20Image'" />
          <br />
          <h3>{{$v->recipe_name}}</h3>
        </div>
      </a>
      </div>
      @endforeach
    </div>
  </div>
</section>
@include("front.theme.foot")
