<script>
    $(document).ready(function() {
        $('.selectHotelBtn').on('click', function() {
            // Get hotel details from the button's data attributes
            var hotelId = $(this).data('hotel-id');
            var hotelName = $(this).data('hotel-name');
            var hotelContact = $(this).data('hotel-contact');

            // Set hotel details in the input field
            $('#hotel_id').val(hotelId);
            $('#hotel_nama').val(hotelName + ' - ' + hotelContact);

            // Close the modal
            $('#hotelSearchModal').modal('hide');
        });
    });
</script>