<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rekening;
use RealRashid\SweetAlert\Facades\Alert;

class RekeningController extends Controller
{
    public function index()
    {
        $rekening = Rekening::all();
        $data = array(
            'title' => 'Rekening | ',
            'datarekening' => $rekening,
        );
        $title = 'Delete Rekening!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.rekening.index', $data);
    }

    public function create()
    {
        $data = array(
            'title' => 'Add Rekening | ',
        );
        return view('backend.rekening.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rekening_id' => 'required|string|max:255',
            'no_rek' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Rekening::create($request->all());
        Alert::success('Success', 'rekening created successfully.');

        return redirect()->route('rekening.index');
    }

    public function show(Rekening $rekening)
    {
        $data = array(
            'title' => 'View Rekening | ',
        );
        return view('backend.rekening.show', $data);
    }

    public function edit(Rekening $rekening)
    {
        $data = array(
            'title' => 'Edit Rekening | ',
            'rekening' => $rekening,
        );
        return view('backend.rekening.edit', $data);
    }

    public function update(Request $request, Rekening $rekening)
    {
        $request->validate([
            'rekening_id' => 'required|string|max:255',
            'no_rek' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $rekening->update($request->all());
        Alert::success('Success', 'rekening updated successfully.');

        return redirect()->route('rekening.index');
    }

    public function destroy(Rekening $rekening)
    {
        $rekening->delete();
        Alert::success('Success', 'rekening deleted successfully.');

        return redirect()->route('rekening.index');
    }
}
