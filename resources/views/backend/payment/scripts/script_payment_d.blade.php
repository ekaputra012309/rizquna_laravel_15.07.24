<script>
    $(document).ready(function() {
        $("#example1, #invoiceTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#detailPembayaranModal').on('show.bs.modal', function() {
            $(this).find('input[type="number"]').val(''); // Clear input fields
            $('#customSwitch1').prop('checked', false); // Reset checkbox
            $('#metode_bayar').val('Tunai'); // Reset the metode_bayar hidden input to default value
        });

        $('#customSwitch1').change(function() {
            if ($(this).is(':checked')) {
                $('#metode_bayar').val('Kredit');
            } else {
                $('#metode_bayar').val('Tunai');
            }
        });

        function calculateAndUpdateHasilKonversi() {
            let totalDeposit = 0;

            $('#listPembayaran tbody tr').each(function() {
                let depositValue = parseFloat($(this).find('td:nth-child(3)').text()) || 0; // Get the deposit value from the table
                totalDeposit += depositValue; // Accumulate the total deposit
            });

            let hasilKonversi = parseFloat($('#bawah1').text()) || 0; // Get the existing hasil konversi

            // Calculate the result as the difference
            let result = hasilKonversi - totalDeposit;
            $('#bawah').text(result.toFixed(2)); // Update the display
        }

        let id_payment = $('#id_payment').val();

        function loadPembayaranTable(id_payment) {
            $.ajax({
                url: '{{ route("paymentdetail.index") }}?id_payment=' + id_payment,
                type: 'GET',
                success: function(data) {
                    $('#listPembayaran tbody').empty();
                    $.each(data, function(index, payment) {
                        let depositValue = payment.deposit || 0;
                        $('#listPembayaran tbody').append(
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + payment.tgl_payment + '</td>' +
                            '<td>' + parseFloat(depositValue).toFixed(2) + '</td>' + // Use parseFloat to ensure it's a number
                            '<td>' + payment.metode_bayar + '</td>' +
                            '</tr>'
                        );
                    });
                    // Calculate and update hasil konversi after loading table data
                    calculateAndUpdateHasilKonversi();
                },
                error: function(xhr) {
                    // Handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load payment details.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        $('#detailPembayaranForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Hide the modal
                    $('#detailPembayaranModal').modal('hide');

                    // Refresh the table
                    loadPembayaranTable(id_payment);

                    // Optional: Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Pembayaran added successfully!',
                        confirmButtonText: 'OK'
                    });

                    // Calculate and update hasil konversi
                    calculateAndUpdateHasilKonversi();
                },
                error: function(xhr) {
                    // Handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error processing your request.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Initial load of the table data and calculate hasil konversi on page load
        loadPembayaranTable(id_payment);
    });
</script>