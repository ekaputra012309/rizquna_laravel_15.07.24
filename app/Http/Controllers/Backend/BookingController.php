<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Hotel;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RealRashid\SweetAlert\Facades\Alert;

class BookingController extends Controller
{
    private function toRoman($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $result = '';

        foreach ($map as $roman => $value) {
            $matches = intval($number / $value);
            $result .= str_repeat($roman, $matches);
            $number = $number % $value;
        }

        return $result;
    }

    public function index(Request $request)
    {
        $query = Booking::with('agent', 'hotel', 'details', 'user');

        // Apply conditions based on request parameters
        if ($request->filled('tgl_from')) {
            $query->whereDate('tgl_booking', '>', $request->tgl_from);
        }
        if ($request->filled('tgl_to')) {
            $query->whereDate('tgl_booking', '<', $request->tgl_to);
        }
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }

        // If no parameters passed, order by created_at
        if (!$request->has('tgl_from') && !$request->has('tgl_to') && !$request->has('agent_id')) {
            $query->orderBy('created_at', 'desc');
        }

        // Execute the query
        $bookings = $query->get();
        $data = array(
            'title' => 'Booking | ',
            'databooking' => $bookings,
        );
        $title = 'Delete Booking!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.booking.index', $data);
    }

    public function create()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Find the maximum ID from existing bookings created in the current month and year
        $maxId = Booking::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->max('booking_id');

        // Extract the month from the last stored auto ID, if it exists
        $lastStoredMonth = $maxId ? explode('/', $maxId)[2] : null;
        // Convert the month number to Roman numeral
        $romanMonth = $this->toRoman($currentMonth);
        $numericPart = (int)explode('/', $maxId)[0];
        // If there are no existing bookings for the current month and year, start from 1
        if ($maxId === null || $lastStoredMonth !== $romanMonth) {
            $newNumericPart = 1;
        } else {
            // Extract the numeric part and increment by 1
            $newNumericPart = $numericPart + 1;
        }

        // Format the new ID to a 3-digit string
        $newId = str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);

        // Construct the auto ID with the Roman numeral month, year, and the new numeric part
        $autoId = $newId . '/INV-HTL/' . $romanMonth . '/' . $currentYear;
        $agent = Agent::all();
        $hotel = Hotel::all();
        $room = Room::all();
        $booking_d = BookingDetail::with('room', 'user')->where('booking_id', $autoId)->get();
        $data = array(
            'title' => 'Add Booking | ',
            'autoId' => $autoId,
            'dataagent' => $agent,
            'datahotel' => $hotel,
            'dataroom' => $room,
            'booking_d' => $booking_d,
        );
        return view('backend.booking.create', $data);
    }

    public function notInPayment()
    {
        $bookingIdsWithPayments = Payment::pluck('id_booking')->toArray();

        $bookingsWithoutPayments = Booking::with('agent', 'hotel', 'details')
            ->whereNotIn('booking_id', $bookingIdsWithPayments)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookingsWithoutPayments);
    }


    public function show($id)
    {
        try {
            $booking = Booking::with('agent', 'hotel', 'details', 'user')->find($id);
            return response()->json($booking);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
    }

    public function store(Request $request)
    {
        Booking::create($request->all());
        Alert::success('Success', 'booking created successfully.');

        return redirect()->route('booking.index');
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update($request->all());
            return response()->json($booking, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            // Retrieve the booking_id before deleting
            $bookingId = Booking::where('id_booking', $id)->value('booking_id');
            // Delete booking details associated with the retrieved booking_id
            BookingDetail::where('booking_id', $bookingId)->delete();
            // Delete the payment
            $paymentId = Payment::where('id_booking', $bookingId)->value('id_payment');
            PaymentDetail::where('id_payment', $paymentId)->delete();
            Payment::where('id_payment', $paymentId)->delete();
            // Delete the booking
            Booking::where('id_booking', $id)->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking Not Found'], 404);
        }
    }

    public function updateStatusToLunas(Request $request, $id)
    {
        $idWithSlashes = preg_replace('/-(?!HTL)/', '/', $id);
        try {
            // $booking = Booking::where('id_booking', $idWithSlashes)->firstOrFail();

            // Update only the status field
            // $booking->status = $request->status;
            // $booking->save();

            $bookingId = Booking::where('booking_id', $idWithSlashes)->value('id_booking');
            $booking = Booking::findOrFail($bookingId);
            $booking->status = $request->status;
            $booking->save();

            return response()->json($booking, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking not found', 'id booking' => $idWithSlashes, 'status' => $request->status], 404);
        }
    }
}
