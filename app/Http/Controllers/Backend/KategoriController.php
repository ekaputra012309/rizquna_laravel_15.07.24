<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index()
    {
        $Kategori = KategoriModel::all();
        $data = array(
            'title' => 'Kategori | ',
            'datakategori' => $Kategori,
        );
        $title = 'Delete Kategori!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.kategori.index', $data);
    }

    public function create()
    {
        $lantai = KategoriModel::all();
        $data = array(
            'title' => 'Add Kategori | ',
            'datalantai' => $lantai,
        );
        return view('backend.kategori.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryname' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'hashtag' => 'required|string|max:50',
        ]);

        KategoriModel::create($request->all());
        Alert::success('Success', 'Kategori created successfully.');

        return redirect()->route('kategori.index');
    }

    public function show(KategoriModel $Kategori)
    {
        $data = array(
            'title' => 'View Kategori | ',
        );
        return view('backend.kategori.show', $data);
    }

    public function edit(KategoriModel $Kategori)
    {
        $data = array(
            'title' => 'Edit Kategori | ',
            'kategori' => $Kategori,
        );
        return view('backend.kategori.edit', $data);
    }

    public function update(Request $request, KategoriModel $Kategori)
    {
        $request->validate([
            'categoryname' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'hashtag' => 'required|string|max:50',
        ]);

        $Kategori->update($request->all());
        Alert::success('Success', 'Kategori updated successfully.');

        return redirect()->route('kategori.index');
    }

    public function destroy(KategoriModel $Kategori)
    {
        $Kategori->delete();
        Alert::success('Success', 'Kategori deleted successfully.');

        return redirect()->route('kategori.index');
    }
}
