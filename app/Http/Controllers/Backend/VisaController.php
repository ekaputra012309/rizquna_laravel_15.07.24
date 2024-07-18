<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\KursVisa;
use Illuminate\Http\Request;
use App\Models\Visa;
use App\Models\VisaDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RealRashid\SweetAlert\Facades\Alert;

class VisaController extends Controller
{
    public function index()
    {
        $visas = Visa::with('agent', 'details', 'kurs')
            ->orderBy('created_at', 'desc')
            ->get();
        $data = array(
            'title' => 'Visa | ',
            'datavisa' => $visas,
        );
        $title = 'Delete visa!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.visa.index', $data);
    }

    public function create()
    {
        $currentYear = date('Y');

        // Find the maximum ID from existing visas
        $maxId = Visa::max('visa_id');

        // Extract the numeric part and increment by 1
        $numericPart = (int)explode('/', $maxId)[0]; // Extract "002" from "002/INV-HTL/II/2024"
        $newNumericPart = $numericPart + 1;

        // Format the new ID to a 3-digit string
        $newId = str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);

        $autoId = $newId . '/INV-VISA/II/' . $currentYear;
        $agent = Agent::orderBy('nama_agent', 'asc')->get();
        $data = array(
            'title' => 'Add Visa | ',
            'dataagent' => $agent,
            'autoId' => $autoId,
        );
        return view('backend.visa.create', $data);
    }

    public function edit(Visa $visa)
    {
        $agent = Agent::orderBy('nama_agent', 'asc')->get();
        $data = array(
            'title' => 'Edit Visa | ',
            'dataagent' => $agent,
            'visa' => $visa,
        );
        return view('backend.visa.edit', $data);
    }

    public function show($id)
    {
        $visa = Visa::with('details', 'agent', 'kurs')->find($id);
        $data = array(
            'title' => 'Visa Detail | ',
            'datavisa' => $visa,
        );
        // dd($visa);
        return view('backend.visa.lihat', $data);
    }

    public function store(Request $request)
    {
        Visa::create($request->all());
        Alert::success('Success', 'visa created successfully.');
        return redirect()->route('visa.index');
    }

    public function update(Request $request, $id)
    {
        try {
            $visa = Visa::findOrFail($id);
            $visa->update($request->all());
            Alert::success('Success', 'visa updated successfully.');
            return redirect()->route('visa.index');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            // Retrieve the visa_id before deleting
            $visaId = Visa::where('id_visa', $id)->value('id_visa');
            // Delete visa details associated with the retrieved visa_id
            VisaDetail::where('id_visa', $visaId)->delete();
            // Delete the visa
            Visa::where('id_visa', $id)->delete();
            Alert::success('Success', 'visa deleted successfully.');

            return redirect()->route('visa.index');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa Not Found'], 404);
        }
    }

    public function updateStatus(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'id_visa' => 'required|exists:visas,id_visa', // Ensure the id_visa exists
            'status' => 'required|string|in:Lunas,DP,Piutang', // Ensure the status is valid
        ]);

        try {
            // Find the visa by id_visa
            // $visa = KursVisa::findOrFail($validatedData['id_visa']);
            // $id_booking = $visa->id_visa; // Get the id_booking from visa

            // Find the booking by id_booking
            $booking = Visa::findOrFail($validatedData['id_visa']);

            // Update the booking status
            $booking->status = $validatedData['status'];
            $booking->save();

            return response()->json(['success' => true, 'message' => 'Booking status updated successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update booking status: ' . $e->getMessage()], 500);
        }
    }
}
