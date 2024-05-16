var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
    // $('#companyTable').DataTable();
$(".createCompanyModalStore").click(function(){
        $('#addCompanyModal').modal("show");
    });
    $('.edit-company').click(function(e) {
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        $.ajax({
            type:'POST',
            url:base_path+"/admin/edit_company",
            data: {
                id: userId,
                master_id: master_id
            },
            success:function(response){
                console.log("_id", response);
                // var res = JSON.parse(response);
                var companyData = response.success[0].company[0];
                // console.log("_id", response.success[0]); // Logging _id for debugging
                $('#company_editid').val(companyData._id); // Setting _id value
                $('#company_editname').val(companyData.companyName);
            }
        });
        $('#edit_companyModel').modal("show");
    });

    //Update User
    $(document).on("click", '#updatecompany', function(event) {
        console.log("Edit User")
        var c_id= $('#company_editid').val();
        // var companySubID= $('#up_comSubId').val();
        var company_editname= $('#company_editname').val();
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatencompany").val());
        formData.append('_id', c_id);
        formData.append('company_name', company_editname);
        formData.append('deleteStatus', "NO");
        $.ajax({
            url: base_path + "/admin/update_company",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                $('#edit_companyModel').modal("hide");

                window.location.href = base_path+"/company";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-company').click(function(e) {
        e.preventDefault();
        // var userId = $(this).data('user-ids').split(',');
        var compan_id = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
// console.log("master_id",compan_id)
        // var compan_id = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_company",
        type: "POST",
        dataType: "json",
        data: {
            id: compan_id,
            master_id: master_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            Swal.fire('COMPANY DELETED SUCCESSFULLY')
            window.location.href = base_path+"/company";
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
