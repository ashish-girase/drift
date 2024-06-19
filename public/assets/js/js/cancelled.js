// console.log('cancelled.js loaded');

// function openModal(selectElement,orderId,oldStatus) {
//     console.log('openModalf called with', selectElement, orderId, oldStatus);
//     var newStatus = selectElement.value;
//     var selectedStatus = selectElement.value;
//     // var selectedStatus = selectElement.value;
//     console.log("dd");
    
//     if(newStatus === 'cancelled'){
//              console.log("can");
            
//             $.ajax({
//                 // url: '/orders/updateStatus',
//                 type: 'POST',
//                 data: {
//                     oldstatus: oldStatus,
//                     newstatus: newStatus,
//                     id:orderId,
//                     '_token': $('input[name="_token"]').val()
//                 },
//                 success: function(response) {
//                     // Handle success response  
//                     console.log(response);
//                     console.log("sucess");
        
//                     // window.location.href = base_path+"/order";
//                     // Swal.fire("sucess", "Order Sucessfully Processed");
//                     Swal.fire({
//                         title: "Success",
//                         text: "Order Successfully Move To Complete",
//                         icon: "success",
//                       }).then(() => {
//                         window.location.href = base_path + "/order";
//                       });
//                 },
//                 error: function(xhr, status, error) {
//                     // Handle error
//                     // console.error(xhr.responseText);
//                     console.error("Errorsd:", error);
//                     console.log("not sucess");
//                     // window.location.href = base_path+"/order";
//                     // Swal.fire("sucess", "Order Sucessfully Processed");
//                 }
//             });
            
//     }
// }