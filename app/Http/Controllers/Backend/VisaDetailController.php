<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use App\Models\Visa;
use Illuminate\Http\Request;
use App\Models\VisaDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class VisaDetailController extends Controller
{
    public function index(Request $request)
    {
        $id_visa = $request->input('id_visa');
        $visas = VisaDetail::with('visa')
            ->where('id_visa', $id_visa)
            ->get();

        return response()->json($visas);
    }

    public function show($id)
    {
        try {
            $visa = VisaDetail::with('visa')->find($id);
            return response()->json($visa);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa Detail not found'], 404);
        }
    }

    public function showInv($id_inv)
    {
        try {
            $visa_d = VisaDetail::with('visa')
                ->where('id_visa', $id_inv)
                ->get();
            if ($visa_d->isNotEmpty()) {
                return response()->json($visa_d);
            } else {
                // return response()->json(['error' => 'Detail visa not found for ID: ' . $id_inv], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Detail visa not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'id_visa' => 'required|exists:visas,id_visa',
        ]);

        DB::beginTransaction();

        try {
            // Create the new payment detail first
            $paymentDetail = VisaDetail::create($request->all());

            // Now check how many payment details exist with the given id_payment
            $existingPaymentDetailCount = VisaDetail::where('id_visa', $validatedData['id_visa'])->count();

            // If exactly one existing payment detail matches, update the booking status to 'DP'
            if ($existingPaymentDetailCount === 1) {
                $visa = Visa::where('id_visa', $validatedData['id_visa'])->first();
                if ($visa) {
                    $id_booking = $visa->id_visa;
                    $booking = Visa::find($id_booking);
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
            return response()->json(['error' => 'Failed to create visa detail: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $visa = VisaDetail::findOrFail($id);
            $visa->update($request->all());
            return response()->json($visa, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa Detail not found'], 404);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $payment = VisaDetail::findOrFail($id);
            $id_visa = $payment->id_visa; // Get the id_payment before deleting

            // Delete the payment detail
            $payment->delete();

            // Check the number of remaining payment details with the same id_payment
            $existingVisaDetailCount = VisaDetail::where('id_visa', $id_visa)->count();

            if ($existingVisaDetailCount === 0) {
                // If there are no remaining payment details, update the booking status to 'Piutang'
                $visa = Visa::where('id_visa', $id_visa)->first();
                if ($visa) {
                    $id_booking = $visa->id_visa;
                    $booking = Visa::find($id_booking);
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

    public function cetakVisa(Request $request)
    {
        $namabank = $request->input('bank');
        $idvisa = $request->input('idvisa');
        $visa = Visa::with('details', 'agent', 'kurs')->find($idvisa);
        $bank = Rekening::where('rekening_id', 'like', '%' . $namabank . '%')->get();

        $data = array(
            'databank' => $bank,
            'title' => 'Invoice | ',
            'databooking' => $visa,
        );
        // dd($visa);
        $pdf = FacadePdf::loadView('backend.visa.cetakvisa', $data);
        return $pdf->stream('Invoice-' . $visa->visa_id . '.pdf');
    }
}
