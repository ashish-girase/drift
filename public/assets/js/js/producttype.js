var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
 
    $(".createproducttypeModalStore").click(function(){
        $('#addproducttypeModal').modal("show");
       
    });

    $('.edit-producttype').click(function(e) {
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
    
        $.ajax({
            type:'POST',
            url:base_path+"/admin/edit_producttype",
            data: {
                id: userId,
                master_id: master_id
            },
            success:function(response){
                console.log("_id", response);
                // var res = JSON.parse(response);
                var producttypeData = response.success[0].producttype[0];
                
                // console.log("_id", response.success[0]); // Logging _id for debugging
                $('#producttype_editid').val(producttypeData._id); // Setting _id value
                $('#producttype_editname').val(producttypeData.producttype_name);
            }
        });
        $('#edit_producttypeModel').modal("show");
    });

    //Update User
    $(document).on("click", '#updateproducttype', function(event) {
        console.log("Edit User")
        var c_id= $('#producttype_editid').val();
        // var companySubID= $('#up_comSubId').val();
        var producttype_editname= $('#producttype_editname').val();
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatenproducttype").val());
        formData.append('_id', c_id);
        formData.append('producttype_name', producttype_editname);
        formData.append('deleteStatus', "NO");
        $.ajax({
            url: base_path + "/admin/update_producttype",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(formData);
                $('#edit_producttypeModel').modal("hide");

                window.location.href = base_path+"/producttype";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-producttype').click(function(e) {
        e.preventDefault();
        // var userId = $(this).data('user-ids').split(',');
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        console.log(userId);

        var confirmDelete = confirm("Are you sure you want to delete this Product Type?");
        if (confirmDelete) {
        $.ajax({
            url: base_path+"/admin/delete_producttype",
            type: "POST",
            dataType: "json",
            data: {
                id: userId,
                master_id: master_id,
                _token: "{{ csrf_token() }}", 
            },
            success: function(response) {
                window.location.href = base_path+"/producttype";
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        }
    });

});

$("#saveproducttype").click(function(){
    var producttype_name = $('#producttype_name').val();
    if(producttype_name===''){
    Swal.fire( "Enter Name");
    $('#producttype_name').focus();
    return false;
    }
    var producttype_name = $('#producttype_name').val();
    var tocken = $("#_tokenproducttype").val();
    console.log(tocken);
    $.ajax({
        url: base_path + "/admin/add_producttype",
        type: "POST",
        dataType:"JSON",
        data: {
            _token: $("#_tokenproducttype").val(),
            producttype_name: producttype_name
        },
        cache: false,
        success: function(Result){
            $("#addproducttypeModal").modal("hide");
            console.log(Result);
            // Store the success message in session storage
            sessionStorage.setItem('successMessage_pt', 'Product Type added successfully');
            window.location.href = base_path + "/producttype";
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            // Optionally, alert the user about the error
            Swal.fire("Error", "Failed to add product type. Please try again later.", "error");
        }
    });
});

const successMessage_pt = sessionStorage.getItem('successMessage_pt');
if (successMessage_pt) {
    Swal.fire(successMessage_pt);
    sessionStorage.removeItem('successMessage_pt');
}
