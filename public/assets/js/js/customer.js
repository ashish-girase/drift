var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {

$(".createCustomerModalStore").click(function(){
        $('#addCustomerModal').modal("show");
    });
    $('.edit-customer').click(function(e) {
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        $.ajax({
            type: 'POST',
            url: base_path + "/admin/edit_customer",
            data: {
                id: userId,
                master_id: master_id
            },
            success: function(response) {
                console.log("_id", response);
                // var res = JSON.parse(response);
                var companyData = response.success[0].customer[0];
                // console.log("_id", response.success[0]); // Logging _id for debugging
                $('#edit_customer_id').val(companyData._id); // Setting _id value
                $('#edit_custName').val(companyData.custName);
                $('#edit_companylistcust').val(companyData.companylistcust); 
                $('#edit_email').val(companyData.email);
                $('#edit_phoneno').val(companyData.phoneno); 
                $('#edit_address').val(companyData.address);
                $('#edit_city').val(companyData.city); 
                $('#edit_zipcode').val(companyData.zipcode);
                $('#edit_state').val(companyData.state); 
                $('#edit_country').val(companyData.country); 
                $('#edit_custref').val(companyData.custref); 
                
                // Show the modal after successfully setting the values
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log('Error:', error);
            }
        });
        $('#editCustomerModal').modal("show");
    });
    

    //Update User
    $(document).on("click", '#updatecustomer', function(event) {
        console.log("Edit Customer");
        var c_id= $('#edit_customer_id').val();
        var edit_custName= $('#edit_custName').val();
        var edit_companylistcust= $('#edit_companylistcust').val();
        var edit_email= $('#edit_email').val();
        var edit_phoneno= $('#edit_phoneno').val();
        var edit_address= $('#edit_address').val();
        var edit_city= $('#edit_city').val();
        var edit_zipcode= $('#edit_zipcode').val();
        var edit_state= $('#edit_state').val();
        var edit_country= $('#edit_country').val();
        var edit_custref= $('#edit_custref').val();
       /* var edit_custCountry= $('#edit_custCountry').val();
        var edit_custZip= $('#edit_custZip').val();
        var edit_custTelephone= $('#edit_custTelephone').val();
        var edit_briefInformation= $('#edit_briefInformation').val();*/
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatencustomer").val());
        formData.append('_id', c_id);
        formData.append('custName', edit_custName);
        formData.append('companylistcust', edit_companylistcust);
        formData.append('email', edit_email);
        formData.append('phoneno', edit_phoneno);
        formData.append('address', edit_address);
        formData.append('city', edit_city);
        formData.append('zipcode', edit_zipcode);
        formData.append('state', edit_state);
        formData.append('country', edit_country);
        formData.append('custref', edit_custref);
       /* formData.append('custCountry', edit_custCountry);
        formData.append('custZip', edit_custZip);
        formData.append('custTelephone', edit_custTelephone);
        formData.append('briefInformation', edit_briefInformation);
        formData.append('deleteStatus', "NO");*/
        $.ajax({
            url: base_path + "/admin/update_customer",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                $('#edit_customerModel').modal("hide");
                console.log(response);
                window.location.href = base_path+"/customer";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-customer').click(function(e) {
        e.preventDefault();
        // var userId = $(this).data('user-ids').split(',');
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');

        // var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_customer",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            master_id: master_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            window.location.href = base_path+"/customer";
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        });
        }
    });

});

$("#savecustomer").click(function(){

    var custName=$('#custName').val();
    if(custName=='')
    {
    Swal.fire( "Enter Company Name");
    $('#custName').focus();
    return false;
    }
    var custName=$('#custName').val();
    var companylistcust=$('#companylistcust').val();
    var email=$('#email').val();
    var phoneno=$('#phoneno').val();
    var address=$('#address').val();
    var city=$('#city').val();
    var zipcode=$('#zipcode').val();
    var state=$('#state').val();
    var country=$('#country').val();
    var custref=$('#custref').val();
    $.ajax({
        url: base_path+"/admin/add_customer",
        type: "POST",
        datatype:"JSON",
        data: {
            _token: $("#_tokencustomer").val(),
            custName: custName,
            companylistcust: companylistcust,
            email: email,
            phoneno: phoneno,
            address: address,
            city: city,
            zipcode: zipcode,
            state: state,
            country: country,
            custref: custref,
           /* custCountry: custCountry,
            custZip: custZip,
            custTelephone: custTelephone,
            briefInformation: briefInformation,
            SalesRep: SalesRep,*/
        },
        cache: false,
        success: function(Result){
            console.log(Result);
            $("#addCustomerModal").modal("hide");
            // Store the success message in session storage
            sessionStorage.setItem('successMessage_cus', 'Customer added successfully');
            window.location.href = base_path + "/customer";
        }
    });
});

const successMessage_cus = sessionStorage.getItem('successMessage_cus');
if (successMessage_cus) {
    Swal.fire(successMessage_cus);
    sessionStorage.removeItem('successMessage_cus');
}

function doSearch_customer(dom, funname, val) {
    var active_id = val;
    var func = funname;
    var dom = dom;
    var timeout;
    if (timeout) {
        clearTimeout(timeout);
      }
      timeout = setTimeout(function () {
        if (func == 'companylistcust') {
            companylistcust(dom, 'companylistcust');
          }
        }, 600);
  }

  function companylistcust(value, id) {
    // console.log("value",id)
    if (!value.includes(")")) {
        var formData = new FormData();
        formData.append('_token', $(".laravel_csrf_tokn").val());
        formData.append('value', value);
        formData.append('main', "admin");
        if (value.match(value) || value == '') {
          $.ajax({
            url: base_path + "/admin/get_companylist",
            type: "POST",
            datatype: "JSON",
            contentType: false,
            processData: false,
            data: formData,
            cache: false,
            success: function (response) {
                var result = response;
               // Assuming response is already parsed as JSON
                var dropdown = document.getElementById(id);
                if (dropdown) {
                    if (result.length == 0) {
                        dropdown.innerHTML = "<option value='No results Found ...'></option>";
                    } else {
                        var options = "";
                        for (var i = 0; i < result.length; i++) {
                            options += `<option data-value="${result[i].id}" data-parent="${result[i].parent}" value="${result[i].value}">${result[i].value}</option>`; // Added closing tag for <option> and displayed value inside the option
                        }
                        dropdown.innerHTML = options;
                    }
                } else {
                    console.error("Dropdown element not found with id:", id);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText); // Log error details for debugging
            }
          });
        } else {
          Swal.fire('Please input alphanumeric characters only');
        }
      }
}