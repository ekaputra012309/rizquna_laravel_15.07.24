<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentDetailController extends Controller
{
    public function index(Request $request)
    {
        $id_payment = $request->input('id_payment'); // Assuming you pass id_payment as a query parameter
        $payments = PaymentDetail::with('payment')
            ->where('id_payment', $id_payment) // Filter by id_payment
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
                // return response()->json(['error' => 'Detail Payment not found for ID: ' . $id_inv], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Detail Payment not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $payment = PaymentDetail::create($request->all());

        return response()->json($payment, 201);
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
        try {
            $payment = PaymentDetail::findOrFail($id);
            $payment->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Payment Detail Not Found'], 404);
        }
    }
}
