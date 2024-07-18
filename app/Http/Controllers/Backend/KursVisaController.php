<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KursVisa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RealRashid\SweetAlert\Facades\Alert;

class KursVisaController extends Controller
{
    public function index(Request $request)
    {
        $datenow = $request->input('datenow');
        if ($datenow) {
            $visas = KursVisa::whereDate('created_at', $datenow)->get();
        } else {
            $visas = KursVisa::all();
        }

        return response()->json($visas);
    }

    public function show($id)
    {
        try {
            $visa = KursVisa::find($id);
            return response()->json($visa);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Kurs Visa not found'], 404);
        }
    }

    public function store(Request $request)
    {
        KursVisa::create($request->all());

        Alert::success('Success', 'kurs created successfully.');
        return redirect()->route('visa.index');
    }
}
