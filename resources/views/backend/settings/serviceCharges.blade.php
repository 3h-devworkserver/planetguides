@extends('backend.layouts.master')

@section('page-header')
    <h1>
        <small>{{ trans('menus.service_charge') }}</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li class="active"><i class="fa fa-money"></i> {{ trans('menus.service_charge') }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-7">
    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('menus.service_charge') }}</h3>
          <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
           {!! Form::model($settings, ['class' => 'form-inline']) !!}
                   <div class="form-group">

                    {!! Form::label('charges', 'Service Charge') !!}
                    {!! Form::text('charges', $settings->charges, ['class' => 'form-control']) !!}
                    <p class="help-block">Note: Put 1 if you don't want any sevice charge.</p>
                    {!! Form::hidden('id', $settings->id) !!}
                    {!! Form::submit('Save', ['class' => 'btn btn-orange']) !!}
                    
                    </div>
          {!! Form::close() !!}

        </div><!-- /.box-body -->
    </div><!--box box-primary-->
  </div>
</div>
@endsection