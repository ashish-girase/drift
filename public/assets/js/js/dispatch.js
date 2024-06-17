$(document).ready(function() {

        $('#order-management-link').click(function(e) {
            // Toggle the visibility of the dispatch dropdown
            $('#dispatch-field').toggleClass('d-none');
    
            // Check if the dispatch dropdown is now visible
            var dispatchVisible = !$('#dispatch-field').hasClass('d-none');
    
            // If dispatch dropdown is visible, prevent default link behavior
            if (dispatchVisible) {
                e.preventDefault(); // Prevent default link behavior
            }
        });

        $('.view-dispatched-order').click(function(e) {
            e.preventDefault();
            var userId = $(this).data('user-ids');
            var master_id = $(this).data('user-master_id');
            
            $.ajax({
                type:'GET',
                url:base_path+"/dispatchdetails",
                data: {
                    id: userId,
                    master_id: master_id
                },
                success:function(response){
                    console.log("jr");
                    window.location.href = base_path + "/dispatchdetails?id=" + userId + "&master_id=" + master_id;
                }, error: function(xhr) {
                    console.log(xhr.responseText);
                }
                
            });
    
        });

});

function openModalf(selectElement,orderId,oldStatus) {
    var newStatus = selectElement.value;
    // var selectedStatus = selectElement.value;

    console.log("hh");

         if(newStatus === 'dispatch' || newStatus === 'completed'){

            $.ajax({
                url: base_path+'/orders/updateStatus',
                type: 'POST',
                data: {
                    oldstatus: oldStatus,
                    newstatus: newStatus,
                    id:orderId,
                    '_token': $('input[name="_token"]').val()
                },
                success: function(response) {
                    // Handle success response  
                    console.log(response);
                    console.log("sucess");
        
                    // window.location.href = base_path+"/order";
                    // Swal.fire("sucess", "Order Sucessfully Processed");
                    Swal.fire({
                        title: "Success",
                        text: "Order Successfully Move To Complete",
                        icon: "success",
                      }).then(() => {
                        window.location.href = base_path + "/order";
                      });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    // console.error(xhr.responseText);
                    console.error("Errorsd:", error);
                    console.log("not sucess");
                    // window.location.href = base_path+"/order";
                    // Swal.fire("sucess", "Order Sucessfully Processed");
                }
            });
            
    }
}