    <div class="review" id="reviews-anchor">
              <div class="row">
                <div class="col-md-12">
                   @include('includes.partials.messages')
                </div>
              </div>
                <div class="row">
                    <div class="col-md-12">
                    <strong>Leave your review here</strong>
                    @if (!Auth::guest())
                      <script>
                      $(document).ready(function() {
                        $("#post-review-box").show();
                        $(".review-form-textarea").hide();
                      });
                      </script>
                    @endif
                    <div id="<?php if(Auth::guest()): ?>loginM<?php else: ?>open-review-box<?php endif ?>">
                      <div class="review-form-textarea">
                          Please write at least 140 characters about your personal experience at this guide. The guide  is expecting this review, please mention so.
                      </div>
                    </div>
                  @if (!Auth::guest())
                    <div id="post-review-box" style="display:none;">    
                        {!! Form::open(['class'=>'list-review-form']) !!}
                        {!! Form::hidden('rating', null, array('id'=>'ratings-hidden')) !!}
                        <div class="form-group">
                        {!! Form::textarea('comment', null, array('rows'=>'5','id'=>'new-review','class'=>'form-control','id'=>'Review','placeholder'=>'Your review here...', "max" => '140','required')) !!}
                        </div>
                        <div class="text-right">
                            <div class="stars starrr" data-rating="{{Input::old('rating',0)}}"></div>
                            <a href="#" class="btn btn-danger" id="close-review-box" style="display:none; margin-right:10px;">Cancel</a>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                        {!! Form::close() !!} 
                    </div>   
                  @endif                            
                    </div>
                </div>
                <div class="review-list">
                  <div class="row">
                    <div class="col-md-12" id="reviews-listing">
                      @include('frontend.guide.review-list')
                    </div>
                  </div>
                </div>
      </div>