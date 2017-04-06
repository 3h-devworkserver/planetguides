<section class="banner">
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
@foreach ($sliders as $key => $slider)
      <!-- <img src="{{ asset($slider->path) }}" alt="background Image slider"> -->
    <div class="item @if($key == '1'){{'active'}}@endif" style="background-image:url('{{ asset($slider->path) }}');"></div>
    @endforeach

  </div>

  <!-- Controls -->
  <!-- <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a> -->
</div>
    <div class="search-wrap">
      <div class="container">
             <div class="row">
                  <div class="col-md-12">
                        <h2 class="text-center">Looking for a Guide? <small>Lorem ipsum dolor sit amet.</small></h2>
                        @include('frontend.includes.searchbar')
          </div>
        </div>
      </div>
    </div><!--end search wrap-->
    </section>