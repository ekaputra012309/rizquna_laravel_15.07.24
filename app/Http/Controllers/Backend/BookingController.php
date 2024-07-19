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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
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


        if ($request->filled('tgl_from')) {
            $query->whereDate('tgl_booking', '>', $request->tgl_from);
        }
        if ($request->filled('tgl_to')) {
            $query->whereDate('tgl_booking', '<', $request->tgl_to);
        }
        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->agent_id);
        }


        if (!$request->has('tgl_from') && !$request->has('tgl_to') && !$request->has('agent_id')) {
            $query->orderBy('created_at', 'desc');
        }


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
        $userId = auth()->user()->id;

        $maxId = Booking::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->max('booking_id');


        $lastStoredMonth = $maxId ? explode('/', $maxId)[2] : null;

        $romanMonth = $this->toRoman($currentMonth);
        $numericPart = (int)explode('/', $maxId)[0];

        if ($maxId === null || $lastStoredMonth !== $romanMonth) {
            $newNumericPart = 1;
        } else {

            $newNumericPart = $numericPart + 1;
        }


        $newId = str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);


        $autoId = $newId . '/INV-HTL/' . $romanMonth . '/' . $currentYear . '.' . $userId;
        $agent = Agent::orderBy('nama_agent', 'asc')->get();
        $hotel = Hotel::orderBy('nama_hotel', 'asc')->get();
        $bookedRoomIds = BookingDetail::where('booking_id', $autoId)->pluck('room_id');
        $room = Room::whereNotIn('id_kamar', $bookedRoomIds)->get();
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

    public function edit(Booking $booking)
    {
        $booking->load('agent', 'hotel');
        $autoId = $booking->booking_id;
        $agent = Agent::orderBy('nama_agent', 'asc')->get();
        $hotel = Hotel::orderBy('nama_hotel', 'asc')->get();
        $bookedRoomIds = BookingDetail::where('booking_id', $autoId)->pluck('room_id');
        $room = Room::whereNotIn('id_kamar', $bookedRoomIds)->get();
        $booking_d = BookingDetail::with('room', 'user')->where('booking_id', $autoId)->get();
        $data = array(
            'title' => 'Edit Booking | ',
            'autoId' => $autoId,
            'dataagent' => $agent,
            'datahotel' => $hotel,
            'dataroom' => $room,
            'booking_d' => $booking_d,
            'booking' => $booking,
        );
        return view('backend.booking.edit', $data);
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

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Booking::create($data);
        // dd($data);
        Alert::success('Success', 'booking created successfully.');

        return redirect()->route('booking.index');
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update($request->all());
            Alert::success('Success', 'booking updated successfully.');

            return redirect()->route('booking.index');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            // Retrieve the booking_id using the provided id_booking
            $booking = Booking::where('id_booking', $id)->firstOrFail();

            // Delete related booking details
            BookingDetail::where('booking_id', $booking->booking_id)->delete();

            // Retrieve payment_id related to the booking
            $paymentId = Payment::where('id_booking', $booking->id_booking)->value('id_payment');

            if ($paymentId) {
                // Delete related payment details
                PaymentDetail::where('id_payment', $paymentId)->delete();
                // Delete payment
                Payment::where('id_payment', $paymentId)->delete();
            }

            // Finally, delete the booking
            $booking->delete();
        });
        Alert::success('Success', 'booking deleted successfully.');

        return redirect()->route('booking.index');
    }

    public function updateStatus(Request $request)
    {

        $validatedData = $request->validate([
            'id_payment' => 'required|exists:payments,id_payment',
            'status' => 'required|string|in:Lunas,DP,Piutang',
        ]);

        try {

            $payment = Payment::findOrFail($validatedData['id_payment']);
            $id_booking = $payment->id_booking;


            $booking = Booking::findOrFail($id_booking);


            $booking->status = $validatedData['status'];
            $booking->save();

            return response()->json(['success' => true, 'message' => 'Booking status updated successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update booking status: ' . $e->getMessage()], 500);
        }
    }

    public function getEvents()
    {
        $events = Booking::with('agent')->get()->map(function ($booking) {
            // Ensure `tgl_booking` and `end_date` are Carbon instances
            $start = $booking->tgl_booking instanceof Carbon ? $booking->tgl_booking : Carbon::parse($booking->tgl_booking);
            $end = $booking->end_date ? ($booking->end_date instanceof Carbon ? $booking->end_date : Carbon::parse($booking->end_date)) : null;

            return [
                'title' => $booking->agent->nama_agent,
                'start' => $start->format('Y-m-d\TH:i:s'),
                'end' => $end ? $end->format('Y-m-d\TH:i:s') : null,
                'backgroundColor' => $this->getStatusColor($booking->status),
                'borderColor' => $this->getStatusColor($booking->status),
                'textColor' => '#fff'
            ];
        });

        return response()->json($events);
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'Lunas':
                return '#28a745'; // Success
            case 'DP':
                return '#ffc107'; // Warning
            case 'Piutang':
                return '#dc3545'; // Danger
            default:
                return '#6c757d'; // Default
        }
    }
}
