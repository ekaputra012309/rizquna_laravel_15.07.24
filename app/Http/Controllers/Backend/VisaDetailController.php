<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisaDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VisaDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $visas = VisaDetail::with('visa')->get();
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
        $visa = VisaDetail::create($request->all());

        return response()->json($visa, 201);
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
        try {
            $visa = VisaDetail::findOrFail($id);
            $visa->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Visa Detail Not Found'], 404);
        }
    }
}
