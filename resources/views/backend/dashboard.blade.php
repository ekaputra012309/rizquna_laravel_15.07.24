@extends('backend/template/app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- You can add breadcrumb links here if needed -->
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Booking Today</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Pemesanan</th>
                                        <th>Tanggal Pemesanan</th>
                                        <th>Agen</th>
                                        <th>Total Subtotal</th>
                                        <th>Status</th>
                                        <th>User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($databooking as $booking)
                                    <tr>
                                        <td>{{ $booking->booking_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->tgl_booking)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td>{{ $booking->agent->nama_agent }}</td>
                                        <td>{{ $booking->total_subtotal }}</td>
                                        @php
                                        $statusClasses = [
                                        'Piutang' => 'btn btn-danger btn-sm',
                                        'DP' => 'btn btn-warning btn-sm',
                                        'Lunas' => 'btn btn-success btn-sm'
                                        ];
                                        $statusClass = $statusClasses[$booking->status] ?? 'btn btn-secondary btn-sm';
                                        @endphp

                                        <td>
                                            <span class="{{ $statusClass }}">{{ $booking->status }}</span>
                                        </td>
                                        <td>{{ $booking->user->name ?? '' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Calendar Card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Calendar</h3>
                        </div>
                        <div class="card-body">
                            <!-- Calendar -->
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>

<!-- Add JavaScript for initializing the calendar -->
<script src="{{ asset('backend/js/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/fullcalendar/main.js') }}"></script>
<script>
    $(function() {
        var Calendar = FullCalendar.Calendar;

        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            initialView: 'dayGridMonth',
            editable: true,
            droppable: true, // if needed
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '{{ route("events") }}',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        var events = data.map(function(event) {
                            return {
                                title: event.title,
                                start: event.start,
                                end: event.end || null, // Handle end date if present
                                backgroundColor: event.backgroundColor,
                                borderColor: event.borderColor,
                                textColor: event.textColor
                            };
                        });
                        successCallback(events);

                        // Check for bookings within 10 days
                        var today = new Date();
                        var tenDaysFromNow = new Date();
                        tenDaysFromNow.setDate(today.getDate() + 10);

                        var upcomingBookings = data.filter(function(event) {
                            var checkInDate = new Date(event.start);
                            return checkInDate >= today && checkInDate <= tenDaysFromNow && event.status !== 'Lunas';
                        });

                        if (upcomingBookings.length > 0) {
                            showModal(upcomingBookings);
                        }
                    },
                    error: function() {
                        failureCallback();
                    }
                });
            },
            eventRender: function(info) {
                // Ensure that the background color is applied
                $(info.el).css('background-color', info.event.backgroundColor);
                $(info.el).css('border-color', info.event.borderColor);
                $(info.el).css('color', info.event.textColor);
            }
        });

        calendar.render();

        // Function to format date in Indonesian format
        function formatDateIndonesian(date) {
            var monthNames = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            return date.getDate() + " " + monthNames[date.getMonth()] + " " + date.getFullYear();
        }

        // Function to show modal
        function showModal(bookings) {
            var modalContent = ''; // Initialize modal content

            bookings.forEach(function(booking, index) {
                var warna = booking.status == 'DP' ? 'warning' : 'danger';
                modalContent += "<p>Invoice No: " + booking.booking_id + "<br>";
                modalContent += "Agent Name: " + booking.title + "<br>";
                modalContent += "Status: <button class='btn btn-sm btn-" + warna + "'>" + booking.status + "</button><br>";
                modalContent += "Check In: " + formatDateIndonesian(new Date(booking.start)) + "<br>";
                if (booking.end) {
                    modalContent += "Check Out: " + formatDateIndonesian(new Date(booking.end)) + "<br>";
                }

                // Check if this is not the last booking
                if (index !== bookings.length - 1) {
                    modalContent += "<hr>"; // Add a horizontal line between each booking except the last one
                }
            });

            $('#myModalNotif .modal-body').html(modalContent);
            $('#myModalNotif').modal('show');
        }
    });

    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        "searching": false,
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 75, 100],
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>

<!-- Modal HTML -->
<div class="modal fade" id="myModalNotif" tabindex="-1" role="dialog" aria-labelledby="myModalNotifLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalNotifLabel">Upcoming Bookings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Modal content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection