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
            type:'POST',
            url:base_path+"/admin/edit_customer",
            data: {
                id: userId,
                master_id: master_id
            },
            success:function(response){
                // var res = JSON.parse(response);
                var customerData = response.success[0].customer[0];

                console.log("edit_id", customerData.factoryCode);
                // console.log("_id", response.success[0]); // Logging _id for debugging
                $('#edit_customer_id').val(customerData._id); // Setting _id value
                $('#edit_custName').val(customerData.custName);
                $('#edit_companyName').val(customerData.companyName);
                $('#edit_factoryCode').val(customerData.factoryCode);
                $('#edit_GstDetails').val(customerData.GstDetails);
                $('#edit_custName').val(customerData.custName);
                $('#edit_custEmail').val(customerData.custEmail);
                $('#edit_custAddress').val(customerData.custAddress);
                $('#edit_cust_Billing_address').val(customerData.cust_Billing_address);
                $('#edit_cust_Delivery_address').val(customerData.cust_Delivery_address);
                $('#edit_custCity').val(customerData.custCity);
                $('#edit_custState').val(customerData.custState);
                $('#edit_custCountry').val(customerData.custCountry);
                $('#edit_custZip').val(customerData.custZip);
                $('#edit_custTelephone').val(customerData.custTelephone);
                $('#edit_briefInformation').val(customerData.briefInformation);
            }
        });
        $('#edit_companyModel').modal("show");
    });

    //Update User
    $(document).on("click", '#updatecompany', function(event) {
        console.log("Edit User")
        var c_id= $('#customer_editid').val();
        // var companySubID= $('#up_comSubId').val();
        var company_editname= $('#company_editname').val();
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatencustomer").val());
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
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');

        // var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_company",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            master_id: master_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            window.location.href = base_path+"/company";
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
    var company_name=$('#company_name').val();
    var factoryCode=$('#factoryCode').val();
    var GstDetails=$('#GstDetails').val();
    var custEmail=$('#custEmail').val();
    var custAddress=$('#custAddress').val();
    var cust_Billing_address=$('#cust_Billing_address').val();
    var cust_Delivery_address=$('#cust_Delivery_address').val();
    var custCity=$('#custCity').val();
    var custState=$('#custState').val();
    var custCountry=$('#custCountry').val();
    var custZip=$('#custZip').val();
    var custTelephone=$('#custTelephone').val();
    var briefInformation=$('#briefInformation').val();
    var SalesRep=$('#SalesRep').val();
    $.ajax({
        url: base_path+"/admin/add_customer",
        type: "POST",
        datatype:"JSON",
        data: {
            _token: $("#_tokencustomer").val(),
            custName: custName,
            company_name: company_name,
            factoryCode: factoryCode,
            GstDetails: GstDetails,
            custEmail: custEmail,
            custAddress: custAddress,
            cust_Billing_address: cust_Billing_address,
            cust_Delivery_address: cust_Delivery_address,
            custCity: custCity,
            custState: custState,
            custCountry: custCountry,
            custZip: custZip,
            custTelephone: custTelephone,
            briefInformation: briefInformation,
            SalesRep: SalesRep,
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

function doSearch_sett(dom, funname, val) {
    var active_id = val;
    var func = funname;
    var dom = dom;
    var timeout;
    if (timeout) {
        clearTimeout(timeout);
      }
      timeout = setTimeout(function () {
        if (func == 'companylistcust') {
            companylistcust(dom, 'companylistcust1');
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
                var result = JSON.parse(response);
                if (result.length == 0) {
                  document.getElementById(id).innerHTML = "<option value='No results Found ...'></option>";
                } else {
                  var options = "";
                  for (var i = 0; i < result.length; i++) {
                    // console.log("result[i].parent",result[i].value)
                    options += `<option data-value = "${result[i].id}" data-parent = "${result[i].parent}" value="${result[i].value}"></option>`;
                  }
                  document.getElementById(id).innerHTML = options;
                }
              }
          });
        } else {
          Swal.fire('Please input alphanumeric characters only');
        }
      }
}