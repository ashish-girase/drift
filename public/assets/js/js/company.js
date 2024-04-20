var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
$(".createCompanyModalStore").click(function(){
        $('#addCompanyModal').modal("show");
    });
    $('.edit-user').click(function(e) {
        var userId = $(this).data('user-id');
        $.ajax({
            type:'POST',
            url:base_path+"/admin/edit_user",
            data:{id:userId},
            success:function(response){
                var res = JSON.parse(response);
                console.log("_id",res._id)
                $('#user_editid').val(res._id);
                $('#user_editemail').val(res.userEmail);
            }
        });
        $('#edit_userModel').modal("show");
    });

    //Update User
    $(document).on("click", '#updateuser', function(event) {
        console.log("Edit User")
        var user_id= $('#user_editid').val();
        // var companySubID= $('#up_comSubId').val();
        var user_firstname= $('#user_editfirstname').val();
        var user_lastname= $('#user_editlastname').val();
        var user_email= $('#user_editemail').val();
        var user_type= $('#user_edittype').val();
        var user_address= $('#user_editaddress').val();
        var user_code= $('#user_editcode').val();
        var user_dob= $('#user_editdob').val();
        var user_phoneno=$('#user_editphoneno').val();
        var user_department=$('#user_editdepartment').val();
        var user_note=$('#user_editnote').val();
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatenuser").val());
        formData.append('user_id', user_id);
        formData.append('user_firstname', user_firstname);
        formData.append('user_lastname', user_lastname);
        formData.append('user_email', user_email);
        formData.append('user_type', user_type);
        formData.append('user_address', user_address);
        formData.append('user_code', user_code);
        formData.append('user_dob', user_dob);
        formData.append('user_phoneno', user_phoneno);
        formData.append('user_department', user_department);
        formData.append('user_note', user_note);
        formData.append('deleteStatus', "NO");
        $.ajax({
            url: base_path + "/admin/update_user",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                $('#edit_userModel').modal("hide");

                window.location.href = base_path+"/user";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-user').click(function(e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/delete_user",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            window.location.href = base_path+"/user";
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        });
        }
    });

});

$("#savecompany").click(function(){

    var company_name=$('#company_name').val();
    if(company_name=='')
    {
    Swal.fire( "Enter Company Name");
    $('#company_name').focus();
    return false;
    }
    var company_name=$('#company_name').val();
    $.ajax({
        url: base_path+"/admin/add_company",
        type: "POST",
        datatype:"JSON",
        data: {
            _token: $("#_tokencompany").val(),
            company_name: company_name,
        },
        cache: false,
        success: function(Result){
            console.log(Result);
            $("#addCompanyModal").modal("hide");
            // Store the success message in session storage
            sessionStorage.setItem('successMessage', 'Company added successfully');
            window.location.href = base_path + "/company";
        }
    });
});

const successMessage = sessionStorage.getItem('successMessage');
if (successMessage) {
    Swal.fire(successMessage);
    sessionStorage.removeItem('successMessage');
}
