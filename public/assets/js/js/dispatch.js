$(document).ready(function() {

        $('.view-dispatched-order').click(function(e) {
            console.log("Dd");
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

