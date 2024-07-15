<script>
    $("#example1, #agentTable, #hotelTable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#detailPesananTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>

<script>
    $(document).ready(function() {
        // Function to check the value of the "malam" field and enable/disable the button
        function toggleDetailPemesananBtn() {
            const malamValue = $('#malam').val();
            if (malamValue && malamValue > 0) {
                $('#detailPemesananBtn').prop('disabled', false);
            } else {
                $('#detailPemesananBtn').prop('disabled', true);
            }
        }

        // Initially disable the button
        toggleDetailPemesananBtn();

        // Monitor changes in the "malam" input field
        $('#check_in, #check_out').on('change', function() {
            // Calculate the number of nights (malam) if both dates are selected
            const checkIn = $('#check_in').val();
            const checkOut = $('#check_out').val();

            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const timeDiff = checkOutDate - checkInDate;
                const malam = timeDiff / (1000 * 60 * 60 * 24);
                if (malam > 0) {
                    $('#malam').val(malam);
                    $('#malam1').val(malam);
                } else {
                    $('#malam').val(0);
                    $('#malam1').val(0);
                }
            } else {
                $('#malam').val(0);
                $('#malam1').val(0);
            }

            // Toggle the button based on the "malam" field value
            toggleDetailPemesananBtn();
        });
    });
</script>