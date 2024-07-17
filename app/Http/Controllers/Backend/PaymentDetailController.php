<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use App\Models\Rekening;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class PaymentDetailController extends Controller
{
    public function index(Request $request)
    {
        $id_payment = $request->input('id_payment');
        $payments = PaymentDetail::with('payment')
            ->where('id_payment', $id_payment)
            ->get();

        return response()->json($payments);
    }

    public function show($id)
    {
        try {
            $payment = PaymentDetail::with('payment')->find($id);
            return response()->json($payment);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Payment Detail not found'], 404);
        }
    }

    public function showInv($id_inv)
    {
        try {
            $payment_d = PaymentDetail::with('payment')
                ->where('id_payment', $id_inv)
                ->get();
            if ($payment_d->isNotEmpty()) {
                return response()->json($payment_d);
            } else {
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Detail Payment not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'id_payment' => 'required|exists:payments,id_payment', // Ensure id_payment exists in payments table
            // Add other necessary validations
        ]);

        DB::beginTransaction();

        try {
            // Create the new payment detail first
            $paymentDetail = PaymentDetail::create($request->all());

            // Now check how many payment details exist with the given id_payment
            $existingPaymentDetailCount = PaymentDetail::where('id_payment', $validatedData['id_payment'])->count();

            // If exactly one existing payment detail matches, update the booking status to 'DP'
            if ($existingPaymentDetailCount === 1) {
                $payment = Payment::where('id_payment', $validatedData['id_payment'])->first();
                if ($payment) {
                    $id_booking = $payment->id_booking;
                    $booking = Booking::find($id_booking);
                    if ($booking) {
                        $booking->status = 'DP';
                        $booking->save();
                    }
                }
            }

            DB::commit();

            return response()->json($paymentDetail, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create payment detail: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $payment = PaymentDetail::findOrFail($id);
            $payment->update($request->all());
            return response()->json($payment, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Payment Detail not found'], 404);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $payment = PaymentDetail::findOrFail($id);
            $id_payment = $payment->id_payment; // Get the id_payment before deleting

            // Delete the payment detail
            $payment->delete();

            // Check the number of remaining payment details with the same id_payment
            $existingPaymentDetailCount = PaymentDetail::where('id_payment', $id_payment)->count();

            if ($existingPaymentDetailCount === 0) {
                // If there are no remaining payment details, update the booking status to 'Piutang'
                $paymentRecord = Payment::where('id_payment', $id_payment)->first();
                if ($paymentRecord) {
                    $id_booking = $paymentRecord->id_booking;
                    $booking = Booking::find($id_booking);
                    if ($booking) {
                        $booking->status = 'Piutang';
                        $booking->save();
                    }
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete payment detail: ' . $e->getMessage()], 500);
        }
    }

    public function cetakRizquna(Request $request)
    {
        $namabank = $request->input('bank');
        $idbooking = $request->input('idbooking');
        $payment = Payment::with('booking', 'detailpay')
            ->where('id_booking', $idbooking)
            ->first();
        $booking = Booking::with('details', 'details.room', 'agent', 'hotel')->find($idbooking);
        $bank = Rekening::where('rekening_id', 'like', '%' . $namabank . '%')->get();

        $totalQty = $booking->details->sum('qty');
        $totalSubtotal = $booking->details->sum('subtotal');
        $sar_usd = $payment->sar_usd;
        $usd_idr = $payment->usd_idr;

        $totalUsd = $totalSubtotal / $sar_usd;
        $totalIdr = $totalUsd * $usd_idr;

        $data = array(
            'databank' => $bank,
            'title' => 'Invoice | ',
            'datapayment' => $payment,
            'databooking' => $booking,
            'totalQty' => $totalQty,
            'totalSubtotal' => $totalSubtotal,
            'totalUsd' => $totalUsd,
            'totalIdr' => $totalIdr,
        );
        $pdf = FacadePdf::loadView('backend.payment.cetakrizquna', $data);
        return $pdf->stream('Invoice-.pdf');
    }
}
