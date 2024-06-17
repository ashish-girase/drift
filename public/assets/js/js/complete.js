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

    $('.view-completed-order').click(function(e) {
        e.preventDefault();
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        
        $.ajax({
            type:'GET',
            url:base_path+"/completedetails",
            data: {
                id: userId,
                master_id: master_id
            },
            success:function(response){
                console.log("jr");
                window.location.href = base_path + "/completedetails?id=" + userId + "&master_id=" + master_id;
            }, error: function(xhr) {
                console.log(xhr.responseText);
            }
            
        });

    });


});

