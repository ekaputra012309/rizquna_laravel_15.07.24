<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;
use RealRashid\SweetAlert\Facades\Alert;

class CabangController extends Controller
{
    public function index()
    {
        $cabang = Cabang::all();
        $data = array(
            'title' => 'Cabang | ',
            'datacabang' => $cabang,
        );
        $title = 'Delete Cabang!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.cabang.index', $data);
    }

    public function create()
    {
        $lantai = Cabang::all();
        $data = array(
            'title' => 'Add Cabang | ',
            'datalantai' => $lantai,
        );
        return view('backend.cabang.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Cabang::create($request->all());
        Alert::success('Success', 'cabang created successfully.');

        return redirect()->route('cabang.index');
    }

    public function show(Cabang $cabang)
    {
        $data = array(
            'title' => 'View Cabang | ',
        );
        return view('backend.cabang.show', $data);
    }

    public function edit(Cabang $cabang)
    {
        $data = array(
            'title' => 'Edit Cabang | ',
            'cabang' => $cabang,
        );
        return view('backend.cabang.edit', $data);
    }

    public function update(Request $request, Cabang $cabang)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $cabang->update($request->all());
        Alert::success('Success', 'cabang updated successfully.');

        return redirect()->route('cabang.index');
    }

    public function destroy(Cabang $cabang)
    {
        $cabang->delete();
        Alert::success('Success', 'cabang deleted successfully.');

        return redirect()->route('cabang.index');
    }
}
