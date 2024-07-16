<script>
    $(document).ready(function() {
        let previousValue = $('#pilih_konversi').val();
        $('#pilih_konversi').change(function() {
            // Get the values of the mandatory inputs
            var sar_idr = $('#sar_idr').val();
            var sar_usd = $('#sar_usd').val();
            var usd_idr = $('#usd_idr').val();

            // Check if any of the mandatory fields are empty
            if (!sar_idr || !sar_usd || !usd_idr) {
                // Show SweetAlert if any field is empty
                Swal.fire({
                    icon: 'warning',
                    title: 'Input Required',
                    text: 'Mohon isi data konversi terlebih dahulu.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reset the select back to the previous value
                    $('#pilih_konversi').val(previousValue);
                });
            } else {
                // If all fields are filled, display the selected value and call konversiHasil
                $('#hasil').html($(this).val());
                konversiHasil();
                previousValue = $(this).val();
            }
        });

        function konversiHasil() {
            var pilihkonversi = $('#pilih_konversi').val();
            var mata_uang = $('#mata_uang').val();
            var sar_idr = $('#sar_idr').val();
            var sar_usd = $('#sar_usd').val();
            var usd_idr = $('#usd_idr').val();
            var tarif = parseFloat($('#subtotal').val());
            var hasilKonversi = 0;

            if (pilihkonversi == 'SAR' && mata_uang == 'SAR') {
                hasilKonversi = tarif;
            } else if (pilihkonversi == 'USD' && mata_uang == 'SAR') {
                hasilKonversi = tarif / sar_usd;
            } else if (pilihkonversi == 'IDR' && mata_uang == 'SAR') {
                hasilKonversi = (tarif / sar_usd) * usd_idr;
            } else if (pilihkonversi == 'USD' && mata_uang == 'USD') {
                hasilKonversi = tarif;
            } else if (pilihkonversi == 'IDR' && mata_uang == 'USD') {
                hasilKonversi = tarif * usd_idr;
            }

            $('#hasil_konversi').val(hasilKonversi.toFixed(0));
            $('#hasil_konversi1').val(formatCurrencyID(hasilKonversi));
        }

        function formatCurrencyID(value) {
            var numericValue = parseFloat(value);
            if (isNaN(numericValue)) {
                return '';
            }
            return numericValue.toLocaleString('id-ID');
        }
    });
</script>