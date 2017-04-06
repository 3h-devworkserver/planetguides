<?php
use App\Models\Access\User\User;
?>
@extends('backend.layouts.master')

@section('page-header')
    <h1>
        <small>My Commission</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li class="active"><i class="fa fa-money"></i> My Commission</li>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    @if ($bookings)
    <style>
      tr:nth-child(even){
        background-color: #dcdcdc;
      }
      tr:nth-child(odd){
        background-color: #aaaaaa;
      }
    </style>
      <table class="table">
        <tr style="background: #EEE;">
          <th>Traveler</th>
          <th>Guide</th>
          <th>Days</th>
          <th>Dates</th>
          <th>TXN ID</th>
          <th>Commission</th>
        </tr>
        @foreach ($bookings as $booking)
          @if (User::find($booking->uid) && User::find($booking->gid))
             <tr>
                <td>
                  {{ User::find($booking->uid)->fname.' '.User::find($booking->uid)->lname }}
                </td>
                <td>
                  {{ User::find($booking->gid)->fname.' '.User::find($booking->gid)->lname }}
                </td>
                <td>
                  {{ $booking->days }}
                </td>
                <td>
                  {!! str_replace(',', "<br />", $booking->dates) !!}
                </td>
                <td>
                  {!! $booking->transaction_id !!}
                </td>
                <td>
                  $ {{ $booking->service_charge+$booking->next_service_charge }}
                </td>
              </tr>
          @endif
        @endforeach
      </table>
    @else
      <h2 align="center">You have no commissions yet!</h2>
    @endif
  </div>
</div>
@endsection