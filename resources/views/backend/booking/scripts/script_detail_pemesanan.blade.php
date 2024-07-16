<script>
    $(document).ready(function() {
        $('#detailPemesananModal').on('show.bs.modal', function() {
            // Reset the form
            $('#detailPemesananForm')[0].reset();

            // Set your desired action URL here
            const actionUrl = "{{ route('bookingdetail.store') }}";
            $('#detailPemesananForm').attr('action', actionUrl);

            $('.room-select').closest('tr').find('input').not(':checkbox').prop('disabled', true);
        });

        // Enable or disable form fields based on checkbox selection
        $('.room-select').on('change', function() {
            var isChecked = $(this).is(':checked');
            $(this).closest('tr').find('input').not(':checkbox').prop('disabled', !isChecked);
        });

        // Calculate subtotal based on qty, tarif, and discount
        $('input[name="qty[]"], input[name="tarif[]"], input[name="discount[]"]').on('input', function() {
            var $row = $(this).closest('tr');
            var qty = parseFloat($row.find('input[name="qty[]"]').val()) || 0;
            var tarif = parseFloat($row.find('input[name="tarif[]"]').val()) || 0;
            var discount = parseFloat($row.find('input[name="discount[]"]').val()) || 0;
            var subtotal = (qty * tarif) - discount;
            $row.find('input[name="subtotal[]"]').val(subtotal.toFixed(2));
        });

        // Handle form submission
        $('#detailPemesananModal').on('show.bs.modal', function() {
            const actionUrl = "{{ route('bookingdetail.store') }}"; // Set your desired action URL here
            $('#detailPemesananForm').attr('action', actionUrl);
        });

        $('#detailPemesananForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: form.attr('action'), // Use the action URL from the form
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Clear the form inputs
                        form.trigger('reset');

                        // Append the new data to the table
                        var newRow = `
                            <tr>
                                <td>
                                    <a class="btn btn-danger btn-sm deleteBookingDetail" data-id="${response.data.id_booking_detail}" href="#" data-confirm-delete="true">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                                <td>${response.data.room_keterangan}</td>
                                <td>${response.data.qty}</td>
                                <td>${response.data.malam}</td>
                                <td>${response.data.tarif}</td>
                                <td>${response.data.discount}</td>
                                <td>${response.data.subtotal}</td>
                            </tr>
                        `;

                        $('#detailPesananTable tbody').append(newRow);

                        $('#detailPemesananModal').modal('hide');
                        window.location.reload();
                        // Show success message
                        Swal.fire('Success', 'Booking details added successfully.', 'success');
                    } else {
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    }
                },
                error: function(response) {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }
            });
        });
        updateTotals();

        function updateTotals() {
            let totalDiscount = 0;
            let totalSubtotal = 0;

            $('#detailPesananTable tbody tr').each(function() {
                const discount = parseFloat($(this).find('td:nth-child(6)').text()) || 0;
                const subtotal = parseFloat($(this).find('td:nth-child(7)').text()) || 0;

                totalDiscount += discount;
                totalSubtotal += subtotal;
            });

            $('#total_discount').val(totalDiscount.toFixed(2));
            $('#total_subtotal').val(totalSubtotal.toFixed(2));
        }


        $('.deleteBookingDetail').on('click', function(e) {
            e.preventDefault(); // Prevent default anchor behavior

            const id = $(this).data('id');
            const url = "{{ url('bookingdetail') }}/" + id; // Adjust based on your route

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // If deletion is successful, remove the corresponding row
                            Swal.fire(
                                'Deleted!',
                                'Your item has been deleted.',
                                'success'
                            );
                            $('a[data-id="' + id + '"]').closest('tr').remove(); // Remove the row
                            window.location.reload();
                            updateTotals();
                        },
                        error: function(xhr) {
                            // Handle error
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the item.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>