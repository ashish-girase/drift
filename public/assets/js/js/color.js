var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
    
$(".createColorModalStore").click(function(){
        $('#addColorModal').modal("show");
        
    });
    $('.edit-color').click(function(e) {
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        $.ajax({
            type:'POST',
            url:base_path+"/admin/edit_color",
            data: {
                id: userId,
                master_id: master_id
            },
            success:function(response){
                console.log("_id", response);
                // var res = JSON.parse(response);
                var colorData = response.success[0].color[0];
                // console.log("_id", response.success[0]); // Logging _id for debugging
                $('#color_editid').val(colorData._id); // Setting _id value
                $('#color_editname').val(colorData.color_name);
            }
        });
        $('#edit_colorModel').modal("show");
    });

    //Update User
    $(document).on("click", '#updatecolor', function(event) {
        console.log("Edit User")
        var c_id= $('#color_editid').val();
        // var companySubID= $('#up_comSubId').val();
        var color_editname= $('#color_editname').val();
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatencolor").val());
        formData.append('_id', c_id);
        formData.append('color_name', color_editname);
        formData.append('deleteStatus', "NO");
        $.ajax({
            url: base_path + "/admin/update_color",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(formData);
                $('#edit_colorModel').modal("hide");
                sessionStorage.setItem('successMessage_col', 'Color Updated successfully');
                window.location.href = base_path+"/color";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-color').click(function(e) {
        e.preventDefault();
        // var userId = $(this).data('user-ids').split(',');
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        console.log(userId);
        console.log(master_id);

        // var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_color",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            master_id: master_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            sessionStorage.setItem('successMessage_col', 'Color Deleted successfully');
            window.location.href = base_path+"/color";
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        });
        }
    });

});

$("#savecolor").click(function(){
    var color_name=$('#color_name').val();
    if(color_name=='')
    {
    Swal.fire( "Enter Company Name");
    $('#color_name').focus();
    return false;
    }
    var color_name=$('#color_name').val();
    $.ajax({
        url: base_path+"/admin/add_color",
        type: "POST",
        datatype:"JSON",
        data: {
            _token: $("#_tokencolor").val(),
            color_name: color_name,
        },
        cache: false,
        success: function(Result){
            // console.log(Result);
            $("#addColorModal").modal("hide");
            // Store the success message in session storage
            sessionStorage.setItem('successMessage_col', 'Color added successfully');
            window.location.href = base_path + "/color";
        }
    });
});

const successMessage_col = sessionStorage.getItem('successMessage_col');
if (successMessage_col) {
    Swal.fire(successMessage_col);
    sessionStorage.removeItem('successMessage_col');
}
