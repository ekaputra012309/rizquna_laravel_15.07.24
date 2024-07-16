<script>
    $(document).ready(function() {
        $('.selectInvoiceBtn').on('click', function() {
            // Get agent details from the button's data attributes
            var invoiceId = $(this).data('invoice-id');
            var invoiceKode = $(this).data('invoice-kode');
            var invoiceMatauang = $(this).data('invoice-matauang');
            var invoiceSubtotal = $(this).data('invoice-subtotal');

            // Set agent details in the input field
            $('#id_booking').val(invoiceId);
            $('#inv_number').val(invoiceKode);
            $('#mata_uang').val(invoiceMatauang);
            $('#subtotal').val(invoiceSubtotal);
            $('#subtotal1').val(formatCurrencyID(invoiceSubtotal));

            // Close the modal
            $('#invoiceModal').modal('hide');
        });

        function formatCurrencyID(value) {
            var numericValue = parseFloat(value);
            if (isNaN(numericValue)) {
                return '';
            }
            return numericValue.toLocaleString('id-ID');
        }
    });
</script>