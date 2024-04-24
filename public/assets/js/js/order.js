var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
$(".createOrderModalStore").click(function(){
        $('#addOrderModal').modal("show");
    });
    $('.edit-product').click(function(e) {
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
        $.ajax({
            type:'POST',
            url:base_path+"/admin/edit_product",
            data: {
                id: userId,
                master_id: master_id
            },
            success:function(response){
                // var res = JSON.parse(response);
                var productData = response.success[0].product[0];
                console.log("_id", response.success[0]); // Logging _id for debugging
                $('#edit_prodid').val(productData._id); // Setting _id value
                $('#edit_prodName').val(productData.prodName); // Setting _id value
                $('#edit_colour_id').val(productData.colour_id);
                $('#edit_product_type').val(productData.product_type);
                $('#edit_prod_code').val(productData.prod_code);
                $('#edit_prod_qty').val(productData.prod_qty);
                $('#edit_Thickness').val(productData.Thickness);
                $('#edit_Width').val(productData.Width);
                $('#edit_Roll_weight').val(productData.Roll_weight);
            }
        });
        $('#edit_productModel').modal("show");
    });

    //Update User
    $(document).on("click", '#updateproduct', function(event) {
        console.log("Edit User")
        var c_id= $('#edit_prodid').val();
        // var companySubID= $('#up_comSubId').val();
        var pro_editname= $('#edit_prodid').val();
        var edit_prodName= $('#edit_prodName').val();
        var edit_colour_id= $('#edit_colour_id').val();
        var edit_product_type= $('#edit_product_type').val();
        var edit_prod_code= $('#edit_prod_code').val();
        var edit_prod_qty= $('#edit_prod_qty').val();
        var edit_Thickness= $('#edit_Thickness').val();
        var edit_Width= $('#edit_Width').val();
        var edit_Roll_weight= $('#edit_Roll_weight').val();
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
        formData.append('_token', $("#_tokeupdatenproduct").val());
        formData.append('_id', c_id);
        formData.append('prodName', edit_prodName);
        formData.append('colour_id', edit_colour_id);
        formData.append('product_type', edit_product_type);
        formData.append('prod_code', edit_prod_code);
        formData.append('prod_qty', edit_prod_qty);
        formData.append('Thickness', edit_Thickness);
        formData.append('Width', edit_Width);
        formData.append('Roll_weight', edit_Roll_weight);
        formData.append('deleteStatus', "NO");
        $.ajax({
            url: base_path + "/admin/update_product",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                $('#edit_productModel').modal("hide");

                window.location.href = base_path+"/product";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-product').click(function(e) {
        e.preventDefault();
        // var userId = $(this).data('user-ids').split(',');
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');

        // var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_product",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            master_id: master_id,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            window.location.href = base_path+"/product";
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        });
        }
    });

});

$("#saveproduct").click(function(){

    var prodName=$('#prodName').val();
    if(prodName=='')
    {
    Swal.fire( "Enter Product Name");
    $('#prodName').focus();
    return false;
    }
    var prodName=$('#prodName').val();
    var product_type=$('#product_type').val();
    var colour_id=$('#colour_id').val();
    var product_type=$('#product_type').val();
    var prod_code=$('#prod_code').val();
    var prod_qty=$('#prod_qty').val();
    var Thickness=$('#Thickness').val();
    var Width=$('#Width').val();
    var Roll_weight=$('#Roll_weight').val();
    $.ajax({
        url: base_path+"/admin/add_product",
        type: "POST",
        datatype:"JSON",
        data: {
            _token: $("#_tokenproduct").val(),
            prodName: prodName,
            product_type: product_type,
            colour_id: colour_id,
            prod_code: prod_code,
            prod_qty: prod_qty,
            Thickness: Thickness,
            Width: Width,
            Roll_weight: Roll_weight
        },
        cache: false,
        success: function(Result){
            console.log(Result);
            $("#addOrderModal").modal("hide");
            // Store the success message in session storage
            sessionStorage.setItem('successMessage_ord', 'Product added successfully');
            window.location.href = base_path + "/product";
        }
    });
});

const successMessage_ord = sessionStorage.getItem('successMessage_ord');
if (successMessage_ord) {
    Swal.fire(successMessage_ord);
    sessionStorage.removeItem('successMessage_ord');
}

function doSearch_cust(dom, funname, val) {
    var active_id = val;
    var func = funname;
    var dom = dom;
    var timeout;
    if (timeout) {
        clearTimeout(timeout);
      }
      timeout = setTimeout(function () {
        if (func == 'colorlistcust') {
            colorlistcust(dom, 'colorlistcust1');
          } else if (func == 'customerlist') {
            customerlist(dom, 'customerlist');
          }
        }, 600);
  }
  

  function customerlist(value, id) {
    if (!value.includes(")")) {
        var formData = new FormData();
        formData.append('_token', $(".laravel_csrf_tokn").val());
        formData.append('value', value);
        formData.append('main', "admin");
        if (value.match(value) || value == '') {
          $.ajax({
            url: base_path + "/admin/searchCustomer",
            type: "POST",
            dataType: "JSON",
            contentType: false,
            processData: false,
            data: formData,
            cache: false,
            success: function (result) {
                var options = `<select class="form-control" id="companyfield" onchange="updatecustomerfield(this.value)">`;
            if (result.length == 0) {
                options += "<option value=''>No Record Found ...</option>";
            } else {
                options += "<option value='' disabled selected>---Select Customer---</option>";
                for (var i = 0; i < result.length; i++) {
                    options += `<option value="${result[i].id}">${result[i].custName}</option>`;
                }
            }
            options += `</select>`;
            $('#customer_list').html(options);
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText); // Log any errors
            }
          });
        } else {
          Swal.fire('Please input alphanumeric characters only');
        }
      }
    
}
function updatecustomerfield(value) {
    var customer_name = $('#customerlist [value="' + value + '"]').data('value');
    // var customer_name = 2;
    if(customer_name==undefined)
    {
        customer_name = value;
    }
    var data = {
        '_token': $(".laravel_csrf_tokn").val(),
        customer_name: customer_name,
    };
    $.ajax({
        url: base_path + "/admin/customerdataget_single",
        method: 'POST',
        data: data,
        cache: false,
        success: function (response) {
            if (response.length > 0) {
                var customerData = response;
                    console.log("Customer Data:", response.GstDetails);
                
                // Check if properties exist before accessing them
                $('#cust_GstDetails').val(customerData.GstDetails || '');
                $('#cust_custEmail').val(customerData.custEmail || ''); 
                $('#cust_custAddress').val(customerData.custAddress || ''); 
                $('#cust_cust_Billing_address').val(customerData.cust_Billing_address || ''); 
                $('#cust_cust_Delivery_address').val(customerData.cust_Delivery_address || ''); 
                $('#cust_custCity').val(customerData.custCity || ''); 
                $('#cust_custState').val(customerData.custState || ''); 
                $('#cust_custCountry').val(customerData.custCountry || ''); 
                $('#cust_custZip').val(customerData.custZip || ''); 
            } else {
                console.error('Empty response or missing data');
            }
        }
        
    });
}

  function colorlistcust(value, id) {
    // console.log("value",id)
    if (!value.includes(")")) {
        var formData = new FormData();
        formData.append('_token', $(".laravel_csrf_tokn").val());
        formData.append('value', value);
        formData.append('main', "admin");
        
        if (value.match(value) || value == '') {
            $.ajax({
                url: base_path + "/admin/get_colorlist",
                type: "POST",
                dataType: "JSON", // Fixed typo in 'dataType'
                contentType: false,
                processData: false,
                data: formData,
                cache: false,
                success: function (response) {
                    var result = response; // Assuming response is already parsed as JSON
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