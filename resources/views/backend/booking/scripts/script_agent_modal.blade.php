<script>
    $(document).ready(function() {
        $('.selectAgentBtn').on('click', function() {
            // Get agent details from the button's data attributes
            var agentId = $(this).data('agent-id');
            var agentName = $(this).data('agent-name');
            var agentContact = $(this).data('agent-contact');

            // Set agent details in the input field
            $('#agent_id').val(agentId);
            $('#agent_nama').val(agentName + ' - ' + agentContact);

            // Close the modal
            $('#agentModal').modal('hide');
        });
    });
</script>