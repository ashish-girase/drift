$(document).ready(function() {

    $('#order-management-link').click(function(e) {
        // Toggle the visibility of the dispatch dropdown
        $('#complete-field').toggleClass('d-none');

        // Check if the dispatch dropdown is now visible
        var completeVisible = !$('#complete-field').hasClass('d-none');

        // If dispatch dropdown is visible, prevent default link behavior
        if (completeVisible) {
            e.preventDefault(); // Prevent default link behavior
        }
    });
});

