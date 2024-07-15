<script>
    $(document).ready(function() {

        // Function to format date
        function formatDate(dateTimeString) {
            var dateTime = new Date(dateTimeString);
            var day = ('0' + dateTime.getDate()).slice(-2);
            var month = ('0' + (dateTime.getMonth() + 1)).slice(-2);
            var year = dateTime.getFullYear();
            return day + '/' + month + '/' + year;
        }
    });
</script>