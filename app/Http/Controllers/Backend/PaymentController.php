<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $payments = Payment::with('detailpay','booking', 'booking.agent', 'booking.hotel')->get();
        return response()->json($payments);
    }

    public function show($id)
    {
        try {
            $payment = Payment::with('detailpay','booking', 'booking.agent', 'booking.hotel')->find($id);
            return response()->json($payment);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $payment = Payment::create($request->all());

        return response()->json($payment, 201);
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
