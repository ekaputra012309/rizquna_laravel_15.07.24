<script>
    $(document).ready(function() {
        $("#agentTable").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        function calculateSubtotal() {
            var harga_pax = parseFloat($('#harga_pax').val());
            var jumlah_pax = parseInt($('#jumlah_pax').val());
            var subtotal = harga_pax * jumlah_pax;
            $('#total').val(subtotal);
        }

        // Event listeners for 'harga_pax', 'jumlah_pax', and 'malam' input fields
        $('#harga_pax, #jumlah_pax').on('input', function() {
            calculateSubtotal();
        });

        calculateSubtotal();
    });
</script>