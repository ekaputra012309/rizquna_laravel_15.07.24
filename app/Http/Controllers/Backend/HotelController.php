<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use RealRashid\SweetAlert\Facades\Alert;

class HotelController extends Controller
{
    public function index()
    {
        $hotel = Hotel::all();
        $data = array(
            'title' => 'Hotel | ',
            'datahotel' => $hotel,
        );
        $title = 'Delete Hotel!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.hotel.index', $data);
    }

    public function create()
    {
        $lantai = Hotel::all();
        $data = array(
            'title' => 'Add Hotel | ',
            'datalantai' => $lantai,
        );
        return view('backend.hotel.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_hotel' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Hotel::create($request->all());
        Alert::success('Success', 'hotel created successfully.');

        return redirect()->route('hotel.index');
    }

    public function show(Hotel $hotel)
    {
        $data = array(
            'title' => 'View Hotel | ',
        );
        return view('backend.hotel.show', $data);
    }

    public function edit(Hotel $hotel)
    {
        $data = array(
            'title' => 'Edit Hotel | ',
            'hotel' => $hotel,
        );
        return view('backend.hotel.edit', $data);
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nama_hotel' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $hotel->update($request->all());
        Alert::success('Success', 'hotel updated successfully.');

        return redirect()->route('hotel.index');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        Alert::success('Success', 'hotel deleted successfully.');

        return redirect()->route('hotel.index');
    }
}
