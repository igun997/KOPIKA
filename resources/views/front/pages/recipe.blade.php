@include("front.theme.head")
<section id="recipe">
    <div class="container">
      <div class="row">
        <!-- Title -->
        <div class="col-12">
          <h2>{{$data->recipe_name}}</h2>
        </div>
      </div>
      <div class="row vertical-align">
        <div class="col-12">
          <!-- Picture -->
          <div class="col-md-8 pull-left wow swing">
            <img src="{{$data->pict}}" alt="{{$data->recipe_name}}" style="height:200px;width:auto;" onerror="this.src='https://via.placeholder.com/500x500?text=No%20Image'" class="recipe-picture" />
          </div>
          <!-- Info -->
          <div class="col-md-4 pull-right wow lightSpeedIn">
            <div class="recipe-info">
              <h3>Info</h3>
              <!-- Time -->
              <div class="row">
                <div class="col-2 text-center">
                  <i class="fa fa-clock-o" aria-hidden="true"></i>
                </div>
                <div class="col-6">Time</div>
                <div class="col-4">{{(isset($data->time))?$data->time:0}}</div>
              </div>
              <!-- Difficulty -->
              <div class="row">
                <div class="col-2 text-center">
                  <i class="fa fa-area-chart" aria-hidden="true"></i>
                </div>
                <div class="col-6">Difficulty</div>
                <div class="col-4">
                  @for($i = 1; $i <= $data->difficulty; $i++)
                  <i class="fa fa-star" aria-hidden="true"></i>
                  @endfor
                </div>
              </div>
              <!-- Serves -->
              <div class="row">
                <div class="col-2 text-center">
                  <i class="fa fa-users" aria-hidden="true"></i>
                </div>
                <div class="col-6">Servings</div>
                <div class="col-4">{{$data->servings}}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Ingredients -->
      <div class="row wow slideInUp">
        <div class="col-12">
          <div class="recipe-ingredients">
            <h3>Ingredients</h3>
            <dl class="ingredients-list">
              @foreach($data->ingredients as $k => $v)
              <dt>{{$v->qty}}</dt> <dd>{{$v->name}}</dd>
              @endforeach
            </dl>
          </div>
        </div>
      </div>
      <!-- Directions -->
      <div class="row wow slideInUp">
        <div class="col-12">
          <div class="recipe-directions">
            <h3>Directions</h3>
            <ol>
              @foreach($data->direction as $k => $v)
              <li>{{$v}}</li>
              @endforeach
            </ol>
          </div>
        </div>
      </div>
      <!-- Back to recipes -->
      <div class="row wow rollIn">
        <div class="col-12 text-center">
          <a href="{{url('/')}}">
            <i class="fa fa-backward" aria-hidden="true"></i>
            Go to back to recipes.
          </a>
        </div>
      </div>
    </div>
  </section>
@include("front.theme.foot")
