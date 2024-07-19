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
    });
</script>

@endsection