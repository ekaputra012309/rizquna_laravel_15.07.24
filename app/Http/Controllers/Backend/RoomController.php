<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
{
    public function index()
    {
        $room = Room::all();
        $data = array(
            'title' => 'Room | ',
            'dataroom' => $room,
        );
        $title = 'Delete Room!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.room.index', $data);
    }

    public function create()
    {
        $data = array(
            'title' => 'Add Room | ',
        );
        return view('backend.room.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Room::create($request->all());
        Alert::success('Success', 'room created successfully.');

        return redirect()->route('room.index');
    }

    public function show(room $room)
    {
        $data = array(
            'title' => 'View Room | ',
        );
        return view('backend.room.show', $data);
    }

    public function edit(room $room)
    {
        $data = array(
            'title' => 'Edit Room | ',
            'room' => $room,
        );
        return view('backend.room.edit', $data);
    }

    public function update(Request $request, room $room)
    {
        $request->validate([
            'kamar_id' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $room->update($request->all());
        Alert::success('Success', 'room updated successfully.');

        return redirect()->route('room.index');
    }

    public function destroy(room $room)
    {
        $room->delete();
        Alert::success('Success', 'room deleted successfully.');

        return redirect()->route('room.index');
    }
}
