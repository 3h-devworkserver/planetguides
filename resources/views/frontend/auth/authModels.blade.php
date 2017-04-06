@section('login')
    <div class="modal fade" id="login-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">{{trans('labels.login_box_title')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 user-option">
                                <h4>Use other accounts</h4>
                                <p>You can also sign in using your Facebook Account or Google Account </p>
                                <a href="" class="btn btn-primary btn-lg btn-facebook">
                                    <i class="fa fa-facebook"></i>
                                    Login with Facebook
                                </a>
                            </div>
                            <div class="col-md-6 user-login">
                               {!! Form::open(['url' => 'auth/login', 'role' => 'form']) !!}
                                    <div class="form-group">
                                       {!! Form::label('email', trans('validation.attributes.email')) !!}
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                                                
                                            </div>
                                    </div>
                                    <div class="form-group">
                                      {!! Form::label('password', trans('validation.attributes.password')) !!}
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </div>
                                                {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password')]) !!}
                                                
                                            </div>
                                    </div>

                                                      
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox('remember') !!} {{ trans('labels.remember_me') }}
                                        </label>
                                     
                                           {!! link_to('password/email', trans('labels.forgot_password'), ['class' => 'pull-right']) !!}
                                        
                                    </div>
                                     {!! Form::submit(trans('labels.login_button'), ['class' => 'btn btn-default']) !!}
                                    
                                {!! Form::close() !!}
                                <em>Don't have an account yet? <a href="#" id="next">Sign up</a></em>
                            </div> <!--end user login-->
                        </div> <!--end row-->
                    </div> <!-- end modal-body-->
                </div> <!-- end modal-content -->
            </div> <!-- end modal-dialog -->
        </div> <!-- end modal -->

@endsection

@section('signupOption')
    <div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">SIGN UP</h4>
                    </div>
                    <div class="modal-body">
                        <button class="btn btn-primary btn-lg" id="become-host">Become a Guide</button>

                        <div class="or-divider">
                            <span>or</span>
                        </div>

                        <button class="btn btn-primary btn-lg" id="travel">I Want to Travel</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('guideSignup')
    <div class="modal fade" id="host-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('labels.become_guide') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-7 new-registration">
                           {!! Form::open(['to' => 'auth/register', 'role' => 'form']) !!}
                                    <div class="form-group">
                                       {!! Form::label('fname', trans('validation.attributes.fname')) !!}
                                       {!! Form::input('fname', 'fname', old('fname'), ['class' => 'form-control','placeholder' => trans('validation.attributes.fname')]) !!}
                                        
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('lname', trans('validation.attributes.lname')) !!}
                                       {!! Form::input('lname', 'lname', old('lname'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.lname')]) !!}
                                        
                                    </div>
                                    <div class="form-group">
                                    {!! Form::label('email', trans('validation.attributes.email')) !!}
                                    {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                                   
                                    </div>
                                    <div class="form-group">
                                    {!! Form::label('password', trans('validation.attributes.password')) !!}
                                    {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password')]) !!}
                                        
                                    </div>
                                    <div class="form-group">
                                    {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation')) !!}
                                    {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password_confirmation')]) !!}
                                        
                                    </div>
                                    {!! Form::submit(trans('labels.register_button'), ['class' => 'btn btn-default', 'data-dismiss' =>'modal']) !!}
                                    
                               {!! Form::close() !!}
                        </div>
                        <div class="col-md-5 fb-login text-center">
                            <span class="badge pull-right">or</span>
                            <div class="fb-logo"></div>
                            <p>You may also login through your existing Facebook by clicking the button below and entering your username and password. </p>
                            <a href="" class="btn btn-primary btn-lg btn-facebook">
                                <i class="fa fa-facebook"></i>Login with Facebook
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                    
                    <button type="button" class="back btn btn-defualt pull-left">Back</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('travellerSignup')
    <div class="modal fade" id="travel-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('labels.traveller') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-7 new-registration">
                            {!! Form::open(['to' => 'auth/register', 'role' => 'form']) !!}
                                    <div class="form-group">
                                       {!! Form::label('fname', trans('validation.attributes.fname')) !!}
                                       {!! Form::input('fname', 'fname', old('fname'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.fname')]) !!}
                                        
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('lname', trans('validation.attributes.lname')) !!}
                                       {!! Form::input('lname', 'lname', old('lname'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.lname')]) !!}
                                        
                                    </div>
                                    <div class="form-group">
                                    {!! Form::label('email', trans('validation.attributes.email')) !!}
                                    {!! Form::input('email', 'email', old('email'), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                                   
                                    </div>
                                    <div class="form-group">
                                    {!! Form::label('password', trans('validation.attributes.password')) !!}
                                    {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password')]) !!}
                                        
                                    </div>
                                    <div class="form-group">
                                    {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation')) !!}
                                    {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.password_confirmation')]) !!}
                                        
                                    </div>
                                    {!! Form::submit(trans('labels.register_button'), ['class' => 'btn btn-default', 'data-dismiss' =>'modal']) !!}
                                    
                               {!! Form::close() !!}
                        </div>
                        <div class="col-md-5 fb-login text-center">
                            <span class="badge pull-right">or</span>
                            <div class="fb-logo">
                                
                            </div>
                            <p>You may also login through your existing Facebook by clicking the button below and entering your username and password.</p>
                            <a href="" class="btn btn-primary btn-lg btn-facebook">
                                <i class="fa fa-facebook"></i>Login with Facebook
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="back btn btn-defualt pull-left">Back</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
