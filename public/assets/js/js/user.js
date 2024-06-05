var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
    // $('#userTable').DataTable();
$(".createUserModalStore").click(function(){
        $('#addUserModal').modal("show");
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
                $('#user_edittype').val(res.user_type);
                $('#user_editfirstname').val(res.userFirstName);
                $('#user_editlastname').val(res.userLastName);
                $('#user_editaddress').val(res.userAddress);
                $('#user_editcode').val(res.userCode);
                $('#user_editdob').val(res.userDob);
                $('#user_edittypework').val(res.typework);
                $('#user_editphoneno').val(res.userTelephone);
                $('#user_editdepartment').val(res.department);
                $('#user_editnote').val(res.userNote);
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

   ////DELETE USER/////////
    $('.delete-user').click(function(e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/delete_user",
        type: "POST",
        dataType: "JSON",
        data: {
            id: userId,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            Swal.fire('USER DELETED SUCCESSFULLY')
            window.location.href = base_path+"/user";
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        });
        }
    });

});

//////////////SAVE USER///////////////
// $("#saveuser").click(function(){

// var user_firstname=$('#user_firstname').val();
// if(user_firstname=='')
// {
// Swal.fire( "Enter First Name");
// $('#user_firstname').focus();
// return false;
// }

// var user_lastname=$('#user_lastname').val();
// if(user_lastname=='')
// {
// Swal.fire( "Enter Last Name");
// $('#user_lastname').focus();
// return false;
// }

// var user_email=$('#user_email').val();
// if(user_email=='')
// {
// Swal.fire( "Enter Email Address");
// $('#user_email').focus();
// return false;
// }
// var user_password=$('#user_password').val();
// if(user_password=='')
// {
// Swal.fire( "Enter Password");
// $('#user_email').focus();
// return false;
// }
// var user_phoneno=$('#user_phoneno').val();
// var user_department=$('#user_department').val();
// var user_note=$('#user_note').val();
// var user_dob=$('#user_dob').val();
// var user_code=$('#user_code').val();
// var user_type=$('#user_type').val();
// var user_address=$('#user_address').val();


// //alert(currencyName);
// // $('body').append(loadfunct);

// $.ajax({
// url: base_path+"/admin/add_user",
// type: "POST",
// datatype:"JSON",
// data: {
//     _token: $("#_tokenuser").val(),
//     user_firstname: user_firstname,
//     user_lastname: user_lastname,
//     user_email: user_email,
//     user_password: user_password,
//     user_type: user_type,
//     user_address: user_address,
//     user_code: user_code,
//     user_dob: user_dob,
//     user_phoneno: user_phoneno,
//     user_department: user_department,
//     user_note: user_note,
// },
// cache: false,
// success: function(Result){
//     if(Result){
//         Swal.fire('User added successfully')
//         // $("#addLeadboardModal").css("z-index","");
//         // $("#editLeadboardModal").css("z-index","");
//         $("#addUserModal").modal("hide");
//         $("#addUserModal form").trigger("reset");
//         window.location.href = base_path + "/user";
//         // if ($("#departmentModal").is(":visible")) {
//         //     $.ajax({
//         //         type: "GET",
//         //         url: base_path+"/admin/view_user",

//         //         success: function(text) {
//         //         var res = JSON.parse(text);
//         //         createdepartmentRows(res);
//         //         }
//         //     });
//         //     $('#departmentModal').modal('show');
//         // }
//     }else{
//         Swal.fire("department Type not added successfully.");
//     }
// }
// });
// // loadfunct.remove();
// });





$("#saveuser").click(function(){

    var user_firstname=$('#user_firstname').val();
    if(user_firstname=='')
    {
    Swal.fire( "Enter First Name");
    $('#user_firstname').focus();
    return false;
    }

    var user_lastname=$('#user_lastname').val();
    if(user_lastname=='')
    {
    Swal.fire( "Enter Last Name");
    $('#user_lastname').focus();
    return false;
    }

    var user_email=$('#user_email').val();
    if(user_email=='')
    {
    Swal.fire( "Enter Email Address");
    $('#user_email').focus();
    return false;
    }
    var user_password=$('#user_password').val();
    if(user_password=='')
    {
    Swal.fire( "Enter Password");
    $('#user_email').focus();
    return false;
    }
    var user_phoneno=$('#user_phoneno').val();
    var user_department=$('#user_department').val();
    var user_note=$('#user_note').val();
    var user_dob=$('#user_dob').val();
    var user_code=$('#user_code').val();
    var user_type=$('#user_type').val();
    var user_address=$('#user_address').val();
   
    
    //alert(currencyName);
    // $('body').append(loadfunct);

    $.ajax({
    url: base_path+"/admin/add_user",
    type: "POST",
    datatype:"JSON",
    data: {
        _token: $("#_tokenuser").val(),
        user_firstname: user_firstname,
        user_lastname: user_lastname,
        user_email: user_email,
        user_password: user_password,
        user_type: user_type,
        user_address: user_address,
        user_code: user_code,
        user_dob: user_dob,
        user_phoneno: user_phoneno,
        user_department: user_department,
        user_note: user_note,
    },
    cache: false,
    success: function(Result){
        if(Result){
            $("#addLeadboardModal").css("z-index","");
        $("#editLeadboardModal").css("z-index","");
            Swal.fire('User added successfully')

            $("#addUserModal").modal("hide");
            // $("#addUserModal form").trigger("reset");
            window.location.href = base_path + "/user";

        }else{
            Swal.fire("department Type not added successfully.");
        }
    }
    });
    // loadfunct.remove();
    });
