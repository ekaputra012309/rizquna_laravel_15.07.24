<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket;
use RealRashid\SweetAlert\Facades\Alert;

class PaketController extends Controller
{
    public function index()
    {
        $paket = Paket::all();
        $data = array(
            'title' => 'Paket | ',
            'datapaket' => $paket,
        );
        $title = 'Delete paket!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.paket.index', $data);
    }

    public function create()
    {
        $lantai = Paket::all();
        $data = array(
            'title' => 'Add Paket | ',
            'datalantai' => $lantai,
        );
        return view('backend.paket.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_paket' => 'required|string|max:255',
            'nama_paket' => 'required|string|max:255',
            'harga_paket' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        Paket::create($request->all());
        Alert::success('Success', 'paket created successfully.');

        return redirect()->route('paket.index');
    }

    public function show(Paket $paket)
    {
        $data = array(
            'title' => 'View Paket | ',
        );
        return view('backend.paket.show', $data);
    }

    public function edit(Paket $paket)
    {
        $data = array(
            'title' => 'Edit Paket | ',
            'paket' => $paket,
        );
        return view('backend.paket.edit', $data);
    }

    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'kode_paket' => 'required|string|max:255',
            'nama_paket' => 'required|string|max:255',
            'harga_paket' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $paket->update($request->all());
        Alert::success('Success', 'paket updated successfully.');

        return redirect()->route('paket.index');
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();
        Alert::success('Success', 'paket deleted successfully.');

        return redirect()->route('paket.index');
    }
}
