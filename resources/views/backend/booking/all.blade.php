@extends ('backend.layouts.master')

@section ('title', trans('menus.booking_management'))

@section('page-header')
    <h1>
        {{ trans('menus.booking_management') }}
        <small>{{ $booking_type }}</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ $booking_type }}</li>
@stop

@section('content')
    {!! $table !!}

<!-- Modal -->
<div class="modal fade guidepayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
  {!!Form::open(['method'=>'patch', 'class'=>'guidePaymentForm']) !!}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Guide Payment Attributes</h4>
      </div>
      <div class="modal-body">
      	<div class="form-group">
      	<label>Guide Payment Amount</label>
        {!!Form::input('number','guide_payment_amount', null, ['class'=>'form-control guideAmount', 'min'=>0, 'step'=>'any'] ) !!}
        </div>
     	 <div class="form-group">
     	 <label>Guide Payment Status</label>
        {!!Form::select('guide_payment_status', ['not paid'=>'Not paid', 'partial paid'=>'Partial Paid', 'full paid'=>'Full Paid'], null, ['class'=>'form-control guideStatus']) !!}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-orange">Save</button>
      </div>
    </div>
    {!!Form::close() !!}
  </div>
</div>


<!-- Modal -->
<div class="modal fade nextStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
  <div class="modal-dialog" role="document">
  {!!Form::open(['method'=>'patch', 'class'=>'nextForm']) !!}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel2">Change Next Attributes</h4>
      </div>
      <div class="modal-body">
      	<div class="form-group">
      	<label>Next Id (Transaction Id)</label>
        {!!Form::text('next_id', null, ['class'=>'form-control nextId'] ) !!}
        </div>
     	 <div class="form-group">
     	 <label>Status</label>
        {!!Form::select('next_status', ['remaining'=>'Remaining', 'paid'=>'Paid'], null, ['class'=>'form-control nextStat', 'placeholder'=>'Payment Transaction Id']) !!}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-orange">Save</button>
      </div>
    </div>
    {!!Form::close() !!}
  </div>
</div>

    <div class="clearfix"></div>

  

@stop


