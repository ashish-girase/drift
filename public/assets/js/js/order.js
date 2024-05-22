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

$("#saveOrder").click(function() {
    // Retrieve and validate customer name
    var custName = $('#custName').val();
    if (custName === '') {
        Swal.fire("Enter Customer Name");
        $('#custName').focus();
        return false;
    }

    // Prepare order data
    var companylistcust = $('#companylistcust').val();
    var email = $('#email').val();
    var phoneno = $('#phoneno').val();
    var address = $('#address').val();
    var city = $('#city').val();
    var zipcode = $('#zipcode').val();
    var state = $('#state').val();
    var country = $('#country').val();
    var custref = $('#custref').val();
    var prodName = $('#prodName').val();
    var product_type = $('#product_type').val();
    var prod_code = $('#prod_code').val();
    var prod_qty = $('#prod_qty').val();
    var Thickness = $('#Thickness').val();
    var Width = $('#Width').val();
    var Roll_weight = $('#Roll_weight').val();
    var ColourName = $('#ColourName').val();
    var total_quantity = $('#total_quantity').val(); // Adjusted key to match the modal input
    var price = $('#price').val();
    var Billing_address = $('#Billing_address').val();
    var Delivery_address = $('#Delivery_address').val();
    var price_type = $('#price_type').val();
    var status = $('#status').val();
    var notes = $('#notes').val();

    // Send AJAX request to add order
    $.ajax({
        url: base_path+"/admin/add_order",
        type: "POST",
        dataType: "json",
        data: {
            _token: $("#_tokenOrder").val(),
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
            prodName: prodName,
            product_type: product_type,
            prod_code: prod_code,
            prod_qty: prod_qty,
            Thickness: Thickness,
            Width: Width,
            Roll_weight: Roll_weight,
            ColourName: ColourName,
            total_quantity: total_quantity, // Adjusted key to match the modal input
            price: price,
            Billing_address: Billing_address,
            Delivery_address: Delivery_address,
            price_type: price_type,
            status: status,
            notes: notes
        },
        cache: false,
        success: function(Result) {
            console.log(Result);
            if(Result){
                    swal.fire('order added successfully')
                    $("#addOrderModal").modal("hide");
                    sessionStorage.setItem('successMessage_ord', 'Order added successfully');
                    window.location.href = base_path + "/order";
        }},
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
            // Handle error here, such as showing an error message to the user
        }
    });
});

// Display success message if available in session storage





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
                $('#custName').val(customerData.custName || '');
                $('#companylistcust').val(customerData.companylistcust || ''); 
                $('#email').val(customerData.email || ''); 
                $('#phoneno').val(customerData.phoneno || ''); 
                $('#address').val(customerData.address || ''); 
                $('#city').val(customerData.city || ''); 
                $('#zipcode').val(customerData.custState || ''); 
                $('#state').val(customerData.zipcode || ''); 
                $('#country').val(customerData.country || ''); 
                $('#custref').val(customerData.custref || ''); 
           // console.log(customerData);
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
    $(document).ready(function() {
        $('#custName').on('input', function() {
            var customerName = $(this).val();
            if (customerName.length > 2) { // Wait until user has entered at least 3 characters
                $.ajax({
                    type: 'POST',
                    url: '/admin/get_customer_by_name',
                    data: {
                        name: customerName,
                        _token: $('#_tokeupdatencustomer').val() // Passing the CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            var companyData = response.success[0];
                            $('#custName').val(companyData.custName);
                            $('#companylistcust').val(companyData.companylistcust);
                            $('#email').val(companyData.email);
                            $('#phoneno').val(companyData.phoneno);
                            $('#address').val(companyData.address);
                            $('#city').val(companyData.city);
                            $('#zipcode').val(companyData.zipcode);
                            $('#state').val(companyData.state);
                            $('#country').val(companyData.country);
                            $('#custref').val(companyData.custref);
                        } else {
                            // Handle case where no data is found
                            console.log('No customer data found');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching customer data:', error);
                    }
                });
            }
        });
    });
    
    
}