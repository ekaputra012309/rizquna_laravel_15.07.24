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

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            return new Intl.DateTimeFormat('id-ID', options).format(date);
        }

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
            toggleAddPaymentButton();
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
                            '<td><button class="delete-btn btn btn-sm btn-danger" data-id="' + payment.id_payment_detail + '"><i class="fas fa-trash-alt"></i></button></td>' + // Delete button
                            '<td>' + formatDate(payment.tgl_payment) + '</td>' +
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

        $('#listPembayaran tbody').on('click', '.delete-btn', function() {
            var id_payment_detail = $(this).data('id');
            var $row = $(this).closest('tr');
            const url = "{{ url('paymentdetail') }}/" + id_payment_detail;

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        $row.remove();
                        Swal.fire('Deleted!', 'Payment detail has been deleted.', 'success');
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                    loadPembayaranTable(id_payment);
                },
                error: function(response) {
                    Swal.fire('Error!', 'An error occurred while deleting the payment detail.', 'error');
                }
            });
        });

        $('#detailPembayaranForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Retrieve the deposit value from the input
            let depositValue = parseFloat($('#deposit').val()) || 0; // Assuming #deposit is your input for the deposit
            let batasValue = parseFloat($('#bawah').text()) || 0; // Get the value from #bawah

            // Validate that deposit cannot be more than #bawah
            if (depositValue > batasValue) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Deposit cannot be more than the allowed amount!',
                    confirmButtonText: 'OK'
                });
                return; // Stop the form submission if validation fails
            }

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

        function toggleAddPaymentButton() {
            let batasValue = parseFloat($('#bawah').text()) || 0; // Get the value from #bawah
            let normalValue = parseFloat($('#bawah1').text()) || 0;
            let id_payment = $('#id_payment').val(); // Get id_payment
            let status;

            if (batasValue === 0) {
                status = 'Lunas'; // If batasValue is 0, set status to 'Lunas'
            } else if (batasValue === normalValue) {
                status = 'Piutang'; // If batasValue equals normalValue, set status to 'Piutang'
            } else {
                status = 'DP'; // Otherwise, set status to 'DP'
            }

            $('.button-bayar').prop('disabled', batasValue === 0); // Disable button if batasValue is 0

            $.ajax({
                url: '{{ route("update.booking.status") }}', // Use the named route
                type: 'POST',
                data: {
                    id_payment: id_payment,
                    status: status,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Optional: Handle success (if needed)
                },
                error: function(xhr) {
                    // Handle error
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Failed to update booking status.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

        // Initial load of the table data and calculate hasil konversi on page load
        loadPembayaranTable(id_payment);
    });
</script>