<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visa;
use App\Models\VisaDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VisaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $visas = Visa::with('agent', 'details', 'kurs')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($visas);
    }

    public function show($id)
    {
        try {
            $visa = Visa::with('agent', 'details', 'kurs')
                ->orderBy('created_at', 'desc')
                ->findOrFail($id);
            return response()->json($visa);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $visa = Visa::create($request->all());

        return response()->json($visa, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $visa = Visa::findOrFail($id);
            $visa->update($request->all());
            return response()->json($visa, 200);
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
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa Not Found'], 404);
        }
    }

    public function updateStatusToLunas(Request $request, $id)
    {
        try {
            $visaId = Visa::where('id_visa', $id)->value('id_visa');
            $visa = Visa::findOrFail($visaId);
            $visa->status = $request->status;
            $visa->save();

            return response()->json($visa, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa not found', 'id visa' => $id, 'status' => $request->status], 404);
        }
    }
}
