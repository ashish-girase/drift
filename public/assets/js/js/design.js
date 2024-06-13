var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
    // $('#designTable').DataTable();
 
    $(".createDesignModalStore").click(function(){
        $('#addDesignModal').modal("show");
       
    });

    $('.edit-design').click(function(e) {
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        $.ajax({
            type:'POST',
            url:base_path+"/admin/edit_design",
            data: {
                id: userId,
                master_id: master_id
            },
            success:function(response){
                console.log("_id", response);
                // var res = JSON.parse(response);
                var designData = response.success[0].design[0];
                // console.log("_id", response.success[0]); // Logging _id for debugging
                $('#design_editid').val(designData._id); // Setting _id value
                $('#design_editname').val(designData.design_name);
            }
        });
        $('#edit_designModel').modal("show");
    });

    //Update User
    $(document).on("click", '#updatedesign', function(event) {
        console.log("Edit User")
        var c_id= $('#design_editid').val();
        // var companySubID= $('#up_comSubId').val();
        var design_editname= $('#design_editname').val();
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatendesign").val());
        formData.append('_id', c_id);
        formData.append('design_name', design_editname);
        formData.append('deleteStatus', "NO");
        $.ajax({
            url: base_path + "/admin/update_design",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(formData);
                $('#edit_designModel').modal("hide");

                window.location.href = base_path+"/design";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-design').click(function(e) {
        e.preventDefault();
        // var userId = $(this).data('user-ids').split(',');
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        console.log(userId);
        console.log(master_id);

        // var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this design?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_design",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            master_id: master_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            window.location.href = base_path+"/design";
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        });
        }
    });

});


$("#savedesign").click(function(){
    var design_name=$('#design_name').val();
    var prod_id=$("#prod_id").val();
    var master_id=$("#master_id").val();

    if(design_name=='')
    {
    Swal.fire( "Enter Company Name");
    $('#design_name').focus();
    return false;
    }
    var design_name=$('#design_name').val();
    var dimensions=$('#dimensions').val();
    var thickness=$('#thickness').val();
    var weight_pcs=$('#weight_pcs').val();
    var weight_sqft=$('#weight_sqft').val();
    var pcs_sqft=$('#pcs_sqft').val();
    var sqft_pcs=$('#sqft_pcs').val();

    $.ajax({
        url: base_path+"/admin/adddesign",
        type: "POST",
        datatype:"JSON",
        data: {
            _token: $("#_tokendesign").val(),
            design_name: design_name,
            dimensions: dimensions,
            thickness: thickness,
            weight_pcs: weight_pcs,
            weight_sqft: weight_sqft,
            pcs_sqft: pcs_sqft,
            sqft_pcs: sqft_pcs,

            id:prod_id,
            maste_id:master_id
        },
        cache: false,
        success: function(Result){
            // console.log(Result);
            $("#addproducttypeModal").modal("hide");
            // Store the success message in session storage
            sessionStorage.setItem('successMessage_des', 'Design added successfully');
            // window.location.href = base_path + "/productdetils";
            location.reload();
        }
    });
});

const successMessage_des = sessionStorage.getItem('successMessage_des');
if (successMessage_des) {
    Swal.fire(successMessage_des);
    sessionStorage.removeItem('successMessage_des');
}
