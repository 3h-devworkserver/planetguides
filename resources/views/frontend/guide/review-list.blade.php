
  
      @foreach($reviews as $review)
      <div class="media">
        <div class="media-left">
          <a href="#">
            <img class="media-object" src="{{ asset($review->user->Picture) }}" alt="">
          </a>
        </div>
        <div class="media-body">
          <h5 class="media-heading">
          <a href="#">{{ $review->user ? $review->user->name : 'Anonymous'}}</a>
          <span class="rating remarkable">
            <span>{{$review->rating}}</span>
          </span>
          </h5>
          <time>{{$review->timeago}}</time>
        </div>
        <p>{{$review->comment}}</p>
      </div>
      @endforeach

  
  @if($reviews->nextPageUrl()) 
    <nav class="btn btn-primary cust-btn-lg" id="loadmore-pagination">
      <a id="loadmore-review" href="{!! $reviews->nextPageUrl() !!}">Load More</a>
      <img id="loadmore-loader" style="display: none;" src="{{asset('images/ajax-loader.gif')}}">
    </nav>
  @endif