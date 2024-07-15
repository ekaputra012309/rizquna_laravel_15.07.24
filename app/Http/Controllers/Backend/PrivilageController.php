<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privilage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrivilageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $privilage = Privilage::with('user', 'role')->get();
        return response()->json($privilage);
    }

    public function show($id)
    {
        $privilageItem = Privilage::with('user', 'role')->findOrFail($id);
        return response()->json($privilageItem);
    }

    public function store(Request $request)
    {
        $privilage = Privilage::create($request->all());

        return response()->json($privilage, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $privilage = Privilage::findOrFail($id);
            $privilage->update($request->all());
            return response()->json($privilage, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Role not found'], 404);
        }
    }

    public function destroy($id)
    {
        $privilage = Privilage::findOrFail($id);
        $privilage->delete();
        return response()->json(null, 204);
    }
}
