  <div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-labelledby="myVideoLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Embed Your Video From Youtube</h4>
                    </div>
                    <div class="modal-body">
                    <div class="row">
                     <div class="video-message"></div>
                     
                        {!! Form::open(['url' => '#', 'role' => 'form', 'id'=>'myeditVideoForm']) !!}
                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        {!! Form::input('text', 'url',null, ['class' => 'form-control', 'id' => 'url','placeholder' => trans('validation.attributes.youtubeUrl'), 'required']) !!}
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-sm-6">
                                    <div class="form-group">    
                                        {!! Form::input('text', 'caption',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.caption')]) !!}
                                    </div>
                                  </div>
                                  {!! Form::hidden('id', $guide->id) !!}
                                  <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        {!! Form::submit(trans('labels.button.submit'), ['class' => 'btn btn-defaultn btn-primary']) !!}
                                    </div>
                                  </div>
                                     <div class="loader-overlay"><div class="custom-loader"></div></div>
                       {!! Form::close() !!}
                    </div>
                    </div>
            </div>
        </div>
</div>