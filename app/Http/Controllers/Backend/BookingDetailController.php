<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RealRashid\SweetAlert\Facades\Alert;

class BookingDetailController extends Controller
{
    public function index()
    {
        $booking_ds = BookingDetail::with('room', 'user')->get();
        return response()->json($booking_ds);
    }

    public function show($id)
    {
        try {
            $booking_d = BookingDetail::with('room', 'user')->find($id);
            return response()->json($booking_d);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Detail Booking not found'], 404);
        }
    }

    public function showInv($id_inv)
    {
        $idWithSlashes = preg_replace('/-(?!HTL)/', '/', $id_inv);
        try {
            $booking_d = BookingDetail::with('room') // Replace 'relationName' with the name of the relation
                ->where('booking_id', $idWithSlashes)
                ->get();
            if ($booking_d->isNotEmpty()) {
                return response()->json($booking_d);
            } else {
                // return response()->json(['error' => 'Detail Booking not found for INV: ' . $id_inv], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Detail Booking not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'booking_id' => 'required|exists:bookings,id',
            'room_id' => 'required|array',
            'room_id.*' => 'exists:rooms,id_kamar',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'malam' => 'integer|min:1',
            'tarif' => 'required|array',
            'tarif.*' => 'numeric|min:0',
            'discount' => 'required|array',
            'discount.*' => 'numeric|min:0',
            'subtotal' => 'required|array',
            'subtotal.*' => 'numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $bookingId = $request->input('booking_id');
        $userId = $request->input('user_id');

        $roomIds = $request->input('room_id');
        $quantities = $request->input('qty');
        $malamValues = $request->input('malam');
        $tarifs = $request->input('tarif');
        $discounts = $request->input('discount');
        $subtotals = $request->input('subtotal');

        foreach ($roomIds as $index => $roomId) {
            $bookingDetail = BookingDetail::create([
                'booking_id' => $bookingId,
                'room_id' => $roomId,
                'qty' => $quantities[$index],
                'malam' => $malamValues,
                'tarif' => $tarifs[$index],
                'discount' => $discounts[$index],
                'subtotal' => $subtotals[$index],
                'user_id' => $userId,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'room_keterangan' => $bookingDetail->room->keterangan,
                'qty' => $bookingDetail->qty,
                'malam' => $bookingDetail->malam,
                'tarif' => $bookingDetail->tarif,
                'discount' => $bookingDetail->discount,
                'subtotal' => $bookingDetail->subtotal,
            ],
            'deleteUrl' => route('bookingdetail.destroy', $bookingDetail->id_booking_detail)
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $booking_d = BookingDetail::findOrFail($id);
            $booking_d->update($request->all());
            return response()->json($booking_d, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Detail Booking not found'], 404);
        }
    }

    public function destroy($booking_d)
    {
        $booking_d = BookingDetail::findOrFail($booking_d);
        $booking_d->delete();
        return response()->json(['success' => true]);
    }
}
