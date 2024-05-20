var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
     $('#companyTable').DataTable();
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
                $('#company_editname').val(companyData.company_name);
                $('#company_editccode').val(companyData.ccode); 
                $('#company_editcaddress').val(companyData.caddress);
                $('#company_editcity').val(companyData.city); 
                $('#company_editzipcode').val(companyData.zipcode);
                $('#company_editstate').val(companyData.state); 
                $('#company_editcountry').val(companyData.country);
                $('#company_edittaxgstno').val(companyData.taxgstno); 
                $('#company_editphoneno').val(companyData.phoneno); 
                $('#company_editemail').val(companyData.email); 
                $('#company_editwebsite').val(companyData.website);
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
        var company_editccode= $('#company_editccode').val();
        var company_editcaddress= $('#company_editcaddress').val();
        var company_editcity= $('#company_editcity').val();
        var company_editzipcode= $('#company_editzipcode').val();
        var company_editstate= $('#company_editstate').val();
        var company_editcountry= $('#company_editcountry').val();
        var company_edittaxgstno= $('#company_edittaxgstno').val();
        var company_editphoneno= $('#company_editphoneno').val();
        var company_editemail= $('#company_editemail').val();
        var company_editwebsite= $('#company_editwebsite').val();
      
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatencompany").val());
        formData.append('_id', c_id);
        formData.append('company_name', company_editname);
        formData.append('ccode', company_editccode);
        formData.append('caddress', company_editcaddress);
        formData.append('city', company_editcity);
        formData.append('zipcode', company_editzipcode);
        formData.append('state', company_editstate);
        formData.append('country', company_editcountry);
        formData.append('taxgstno', company_edittaxgstno);
        formData.append('phoneno', company_editphoneno);
        formData.append('email', company_editemail);
        formData.append('website', company_editwebsite);
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
    var ccode=$('#ccode').val();
    var caddress=$('#caddress').val();
    var city=$('#city').val();
    var zipcode=$('#zipcode').val();
    var state=$('#state').val();
    var country=$('#country').val();
    var taxgstno=$('#taxgstno').val();
    var phoneno=$('#phoneno').val();
    var email=$('#email').val();
    var website=$('#website').val();
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
            ccode:ccode,
            caddress:caddress,
            city:city,
            zipcode:zipcode,
            state:state,
            country:country,
            taxgstno:taxgstno,
            phoneno:phoneno,
            email:email,
            website:website,
           

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
