<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('detailpay', 'booking', 'booking.agent', 'booking.hotel')
            ->orderBy('created_at', 'desc')
            ->get();
        $bookingIdsWithPayments = Payment::pluck('id_booking')->toArray();
        $invoice = Booking::with('agent')
            ->whereNotIn('id_booking', $bookingIdsWithPayments)
            ->orderBy('created_at', 'desc')
            ->get();
        $data = array(
            'title' => 'Payment | ',
            'datapayment' => $payments,
            'datainvoice' => $invoice,
        );
        $title = 'Delete Payment!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.payment.index', $data);
    }

    public function show($id)
    {
        $payment = Payment::with('detailpay', 'booking', 'booking.agent', 'booking.hotel')->find($id);
        $booking_d = BookingDetail::with('room', 'user')->where('booking_id', $payment->booking->booking_id)->get();
        $data = array(
            'title' => 'Payment Detail| ',
            'datapayment' => $payment,
            'booking_d' => $booking_d,
        );
        // dd($booking_d);
        return view('backend.payment.lihat', $data);
    }

    public function store(Request $request)
    {
        Payment::create($request->all());

        Alert::success('Success', 'payment created successfully.');
        return redirect()->route('payment.index');
    }

    public function update(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->update($request->all());
            return response()->json($payment, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            // Retrieve the payment_id before deleting
            $paymentId = Payment::where('id_payment', $id)->value('id_payment');
            // Delete payment details associated with the retrieved payment_id
            PaymentDetail::where('id_payment', $paymentId)->delete();
            // Delete the payment
            Payment::where('id_payment', $id)->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Payment Not Found'], 404);
        }
    }
}
