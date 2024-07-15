<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KursVisa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KursVisaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

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
        $visa = KursVisa::create($request->all());

        return response()->json($visa, 201);
    }
}
