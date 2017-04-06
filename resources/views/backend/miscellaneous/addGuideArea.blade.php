@extends ('backend.layouts.master')

@section ('title', trans('menus.guidearea_management'))

@section('page-header')
    <h1>
        {{ trans('menus.addguide_area') }}
        <!-- <small>Guide Area Reviews</small> -->
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">Guide Area Reviews</li>
@stop

@section('content')
<div class="row">
  <div class="col-md-7">
    <div class="box box-primary">
      <div class="box-header with-border">
          <h3 class="box-title">Guide Area Reviews</h3>
          <div class="box-tools pull-right">
              <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
                {!! Form::open(array('url'=>'admin/miscellaneous/addguide','method'=>'POST', 'files'=>false)) !!}
          <div class="form-group clearfix">
              <label class="col-md-4 control-label">Guide Area</label>
              <div class="col-md-8">
                {!! Form::input('text', 'guide_area',null, ['class' => 'form-control', 'id' => 'caption','placeholder' => trans('strings.addguide')]) !!}
              </div>
          </div> 
          <div class="form-group clearfix">
              <label class="col-md-4 control-label">Order</label>
              <div class="col-md-8">
                {!! Form::input('number', 'ordering',null, ['class' => 'form-control', 'min'=>'0', 'placeholder' => trans('Order')]) !!}
              </div>
          </div>
          <div class="col-md-8 col-md-offset-4">
              {!! Form::submit('Save', array('class'=>'send-btn btn btn-orange btn-sm')) !!}
          </div>
          {!! Form::close() !!}
        </div><!-- /.box-body -->
    </div>
  </div>
</div>
@stop



