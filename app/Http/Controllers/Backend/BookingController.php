<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Backend\Booking\BookingStatusRequest;
use App\Http\Requests\Backend\Booking\BookingDeleteRequest;
use App\Http\Requests\Backend\Booking\BookingCancelRequest;
use App\Http\Requests\Backend\Booking\BookingGuidePaymentRequest;
use App\Http\Requests\Backend\Booking\BookingNextAttributesRequest;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Availability;
use Datatable;

class BookingController extends Controller {

    public function getUnapproved() {
        $table = $this->setDatatable(0);
        return view('backend.booking.all', compact('table'))->withBookingType('Unapproved Bookings');
    }

    public function commission() {
        $bookings = Booking::where('status', 'booked')->get();
        $bookings = $bookings->all();
        return view('backend.miscellaneous.earnings', compact('bookings'));
    }

    public function getApproved() {
        $table = $this->setDatatable(1);

        return view('backend.booking.all', compact('table'))->withBookingType('Approved Bookings');
    }

    public function status($id, $status, BookingStatusRequest $request) {
        $booking = Booking::find($id);
        //dd($booking);
        
        if (is_null($booking))
            throw new GeneralException('This booking does not exist.');

        $booking->verified = $status;

        if ($booking->save())
            return redirect()->back()->withFlashSuccess(trans("alerts.booking.status_updated"));

        throw new GeneralException("There was a problem updating this booking. Please try again.");
    }

    public function delete($id, BookingDeleteRequest $request) {
        $booking = Booking::find($id);
        if (is_null($booking))
            throw new GeneralException('This booking does not exist.');

        if ($booking->delete())
            return redirect()->back()->withFlashSuccess(trans("alerts.booking.deleted"));

        throw new GeneralException("There was a problem deleting this booking. Please try again.");
    }

//cancel booking by admin
    public function cancelBooking($id, BookingCancelRequest $request) {
        $booking = Booking::find($id);
        $dates = $booking->dates;
        $guide_id = $booking->gid;
        $traveler_id = $booking->uid;
        $avails = Availability::where('guide_id', $guide_id)->where('travler_id', $traveler_id)->update(['status' => 'free']);
        $booking->status = 'canceled';
        $booking->save();
        if (is_null($booking))
            throw new GeneralException('This booking does not exist.');
        $booking->status = 'canceled';
        if ($booking->save())
            return redirect()->back()->withFlashSuccess(trans("Booking has been canceled"));

        throw new GeneralException("There was a problem cancelling this booking. Please try again.");
    }



//change guide payment attributes in booking table
     public function changeGuidePayment($id, BookingGuidePaymentRequest $request) {
        $booking = Booking::find($id);
        if (is_null($booking))
            throw new GeneralException('This booking does not exist.');
        $booking->guide_payment_amount = $request->guide_payment_amount;
        $booking->guide_payment_status = $request->guide_payment_status;
        if ($booking->save())
            return redirect()->back()->withFlashSuccess(trans("Guide Payment attributes are changed"));

        throw new GeneralException("There was a problem changing this booking. Please try again.");
    }

//change next attributes in booking table
     public function changeNextAttributes($id, BookingNextAttributesRequest $request) {
        $booking = Booking::find($id);
        if (is_null($booking))
            throw new GeneralException('This booking does not exist.');
        
            $booking->next_id = $request->next_id;
        $booking->next_status = $request->next_status;
        if ($booking->save())
            return redirect()->back()->withFlashSuccess(trans("Next attributes are changed"));

        throw new GeneralException("There was a problem changing this booking. Please try again.");
    }


    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatable($status) {


        if ($status)
            $route = route('api.table.bookings.approved');
        else
            $route = route('api.table.bookings.unapproved');


        return Datatable::table()
                        ->addColumn(trans('crud.pages.id'), 'Booked By', 'Guide', 'Booked For','Transaction ID','Amount','Days', 'Dates','Payment Status', trans('crud.pages.created'))
                        ->addColumn(trans('crud.actions'))
                        ->setUrl($route)
                        ->setOptions(['oLanguage' => trans('crud.datatables'), 'fnInitComplete' => "function(oSettings, json) {formLoad()}"])
                        ->render();
    }

}
