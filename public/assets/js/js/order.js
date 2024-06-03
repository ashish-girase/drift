// const { method } = require("lodash");

var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {

$("#chan").click(function(){
    $('#statusChange').modal("show");
});
    
   
$(".createOrderModalStore").click(function(){
        // populateBrowserList();
        $('#addOrderModal').modal("show");
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.edit-order').click(function(e) {
        var userId = $(this).data('user-ids');
        var master_id = $(this).data('user-master_id');
    
        $.ajax({
            type: 'POST',
            url: base_path + "/admin/edit_order",
            data: {
                id: userId,
                master_id: master_id
            },
            success: function(response) {
                if (response.success && response.success.length > 0) {
                    var orderData = response.success[0]; // Assuming first item in success array
                    var productData = orderData.product && orderData.product.length > 0 ? orderData.product[0] : null;
                    console.log(orderData);
                    if (orderData) {
                        // console.log("_id", orderData); // Logging _id for debugging
                        $('#edit_prodid').val(orderData._id);
                        $('#edit_custName').val(orderData.customer.custName); // Added customer name
                        $('#edit_companylistcust').val(orderData.customer.companylistcust);
                        $('#edit_email').val(orderData.customer.email);
                        $('#edit_phoneno').val(orderData.customer.phoneno);
                        $('#edit_address').val(orderData.customer.address);
                        $('#edit_city').val(orderData.customer.city);
                        $('#edit_zipcode').val(orderData.customer.zipcode);
                        $('#edit_state').val(orderData.customer.state);
                        $('#edit_country').val(orderData.customer.country);
                        $('#edit_custref').val(orderData.customer.custref);
                        $('#edit_prodName').val(orderData.product.prodName);
                        $('#edit_product_type').val(orderData.product.product_type);
                        $('#edit_prod_code').val(orderData.product.prod_code);
                        $('#edit_prod_qty').val(orderData.product.prod_qty);
                        $('#edit_Thickness').val(orderData.product.Thickness);
                        $('#edit_Width').val(orderData.product.Width);
                        $('#edit_Roll_weight').val(orderData.product.Roll_weight);
                        $('#edit_ColourName').val(orderData.product.ColourName);
                        $('#edit_total_quantity').val(orderData.total_quantity);
                        $('#edit_price').val(orderData.price);
                        $('#edit_Billing_address').val(orderData.Billing_address);
                        $('#edit_Delivery_address').val(orderData.Delivery_address);
                        $('#edit_price_type').val(orderData.price_type);
                        $('#edit_status').val(orderData.status);
                        $('#edit_notes').val(orderData.notes);
                        
                    } else {
                        console.error('Product data is missing or empty');
                        // Handle missing product data case
                    }
                } else {
                    console.error('No record found');
                    // Handle no record case
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        $('#editordermodal').modal("show");
    });

     $('#custNamedrop').change(function() {
        var selectedName = $(this).val();
        // console.log(selectedName);
        $.ajax({
            url: base_path+"/order",
            method: 'GET',
            data: {name: selectedName},
            success: function(response) {
                $('#companylistcust').val(response.email);
                $('#email').val(response.phone);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
            
        });
    });

    //Update User
    $(document).on("click", '#updateOrder', function(event) {
        console.log("Edit Customer");
        var c_id= $('#edit_prodid').val();
        // var companySubID= $('#up_comSubId').val();
        var edit_custName = $('#edit_custName').val();
        var edit_companylistcust = $('#edit_companylistcust').val();
        var edit_email = $('#edit_email').val();
        var edit_phoneno = $('#edit_phoneno').val();
        var edit_address = $('#edit_address').val();
        var edit_city = $('#edit_city').val();
        var edit_zipcode = $('#edit_zipcode').val();
        var edit_state = $('#edit_state').val();
        var edit_country = $('#edit_country').val();
        var edit_custref = $('#edit_custref').val();
        var edit_prodName = $('#edit_prodName').val();
        var edit_product_type = $('#edit_product_type').val();
        var edit_prod_code = $('#edit_prod_code').val();
        var edit_prod_qty = $('#edit_prod_qty').val();
        var edit_Thickness = $('#edit_Thickness').val();
        var edit_Width = $('#edit_Width').val();
        var edit_Roll_weight = $('#edit_Roll_weight').val();
        var edit_ColourName = $('#edit_ColourName').val();
        var edit_total_quantity = $('#edit_total_quantity').val();
        var edit_price = $('#edit_price').val();
        var edit_Billing_address = $('#edit_Billing_address').val();
        var edit_Delivery_address = $('#edit_Delivery_address').val();
        var edit_price_type = $('#edit_price_type').val();
        var edit_status = $('#edit_status').val();
        var edit_notes = $('#edit_notes').val();
          
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();
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
        formData.append('prodName', edit_prodName);
        formData.append('product_type', edit_product_type);
        formData.append('prod_code', edit_prod_code);
        formData.append('prod_qty', edit_prod_qty);
        formData.append('Thickness', edit_Thickness);
        formData.append('Width', edit_Width);
        formData.append('Roll_weight', edit_Roll_weight);
        formData.append('ColourName', edit_ColourName);
        formData.append('total_quantity', edit_total_quantity);
        formData.append('price', edit_price);
        formData.append('Billing_address', edit_Billing_address);
        formData.append('Delivery_address', edit_Delivery_address);
        formData.append('price_type', edit_price_type);
        formData.append('status', edit_status);
        formData.append('notes', edit_notes);
                   
         
        $.ajax({
            url: base_path + "/admin/update_order",
            type: 'post',
            datatype: "JSON",
            contentType: false,
            data: formData,
            processData: false,
            cache: false,
            success: function (response) {
                console.log("formData");
                $('#editordermodal').modal("hide");

                window.location.href = base_path+"/order";

            },
            error: function (data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    Swal.fire("Error!", value[0], "error");
                });
            }
        });
    });

    //delete user
    $('.delete-order').click(function(e) {
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
        url: base_path+"/admin/delete_order",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            master_id: master_id,
            // _token: "{{ csrf_token() }}" 
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
            window.location.href = base_path+"/order";
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
        });
        }
    });


        function populateCustomerList() {
        $.ajax({
            url: base_path +'/admin/searchcustomerdata',
            method: 'GET',
            
            success: function(data){
                var datalist = $('#customer_list');
                datalist.empty();
                data.forEach(function(customer){
                    datalist.append('<option value="'+customer.customer.custName+'" data-email="'+customer.customer.email+'"data-phoneno="'+customer.customer.phoneno+'"data-companylistcust="'+customer.customer.companylistcust+'"data-address="'+customer.customer.address+'"data-city="'+customer.customer.city+'"data-zipcode="'+customer.customer.zipcode+'"data-state="'+customer.customer.state+'"data-country="'+customer.customer.country+'"data-custref="'+customer.customer.custref+'"data-custid="'+customer.customer._id+'">');   
                });
                
                // Event listener for selecting an option
                $('#customerInput').on('input', function() {
                    var selectedName = $(this).val();
                    var selectedOption = $('option[value="' + selectedName + '"]');
                    var selectedEmail = selectedOption.data('email');
                    var selectedPhone = selectedOption.data('phoneno');
                    var selectedcompanylistcust = selectedOption.data('companylistcust');
                    var selectedaddress = selectedOption.data('address');
                    var selectedcity = selectedOption.data('city');
                    var selectedzipcode = selectedOption.data('zipcode');
                    var selectedstate = selectedOption.data('state');
                    var selectedcountry = selectedOption.data('country');
                    var selectedcustref = selectedOption.data('custref');
                    var selectedcustid = selectedOption.data('custid');

                    
                
                    $('#email').val(selectedEmail);
                    $('#phoneno').val(selectedPhone);
                    $('#companylistcust').val(selectedcompanylistcust);
                    $('#address').val(selectedaddress);
                    $('#city').val(selectedcity);
                    $('#zipcode').val(selectedzipcode);
                    $('#state').val(selectedstate);
                    $('#country').val(selectedcountry);
                    $('#custref').val(selectedcustref);
                    $('#custid').val(selectedcustid);
                    
                });
            },
            error: function(error){
                console.error("data not fetched", error);
            }
        });

    }

    
        populateCustomerList();

        // Trigger AJAX request and populate customer list when typing in the input field
        $('#customerInput').on('input', function() {
            populateCustomerList();
        });


        function populateProductList() {
            $.ajax({
                url: base_path +'/admin/searchproductdata',
                method: 'GET',
                success: function(data){
                    var datalist = $('#product_list');
                    datalist.empty();
                    data.forEach(function(product){
                        datalist.append('<option value="'+product.product.prodName+'" data-product_type="'+product.product.product_type+'"data-prod_code="'+product.product.prod_code+'"data-prod_qty="'+product.product.prod_qty+'"data-thickness="'+product.product.Thickness+'"data-width="'+product.product.Width+'"data-colorname="'+product.product.ColorName+'"data-roll_weight="'+product.product.Roll_weight+'"data-prodid="'+product.product._id+'">');
                        
                    });
                    
                    // Event listener for selecting an option
                    $('#productsInput').on('input', function() {
                        var selectedName = $(this).val();
                        var selectedOption = $('option[value="' + selectedName + '"]');
                        var selectedproduct_type = selectedOption.data('product_type');
                        var selectedprod_code = selectedOption.data('prod_code');
                        var selectedprod_qty = selectedOption.data('prod_qty');
                        var selectedThickness = selectedOption.data('thickness');
                        var selectedWidth = selectedOption.data('width');
                        var selectedColorName = selectedOption.data('colorname');
                        var selectedRoll_weight = selectedOption.data('roll_weight');
                        var selectedRoll_weight = selectedOption.data('prodid');
                    
                        
                     
                        $('#product_type').val(selectedproduct_type);
                        $('#prod_code').val(selectedprod_code);
                        $('#prod_qty').val(selectedprod_qty);
                        $('#Thickness').val(selectedThickness);
                        $('#Width').val(selectedWidth);
                        $('#ColourName').val(selectedColorName);
                        $('#Roll_weight').val(selectedRoll_weight);
                        $('#prodid').val(selectedRoll_weight);
                        
                    });
                },
                error: function(error){
                    console.error("data not fetched", error);
                }
            });
    
        }
    
        populateProductList();
    
            // Trigger AJAX request and populate customer list when typing in the input field
            $('#customerInput').on('input', function() {
                populateProductList();
            });


    


        
   


});
function openModal(selectElement) {
    var selectedStatus = selectElement.value;
    var oldStatus = document.getElementById('oldstatus').value;
    var newStatus = selectElement.value;
    var orderId = document.getElementById('orderid').value;
    
    // console.log(orderId);
    if (selectedStatus === 'processing') {
        $('#statusChange').modal('show');
    }
    $.ajax({
        url: 'orders/updateStatus',
        type: 'POST',
        data: {
            oldstatus: oldStatus,
            newstatus: newStatus,
            id:orderId,
            '_token': $('#_tokenOrder').val()
        },
        success: function(response) {
            // Handle success response
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    });
}

$(document).ready(function() {
    $('#savesatatus').on('click', function() {
        // Get the form data
        // var oldStatus = document.getElementById('oldstatus').value;
        // var newStatus = selectElement.value;
        var orderId = document.getElementById('orderid').value;
        var formData = {
            'status': $('#status').val(),
            'receipy_code': $('#receipy_code').val(),
            'delivery_date': $('#delivary_date').val(),
            'time': $('#time').val(),
            'note': $('#note').val(),
            'id': orderId,
            '_token': $('#_tokenOrder').val()
        };
        
        // console.log(formData);
        // Send the AJAX request
        $.ajax({
            type: 'POST',
            url: 'orders/addnewStatus', 
            data: formData,
            success: function(data) {
                // console.log(data);
                // Handle the success response
                // For example, close the modal
                $('#statusChange').modal('hide');
            },
            error: function(data) {
                console.log("hello");
                // Handle the error response
                // You can display an error message or handle it as needed
            }
        });
    });
});


$("#saveOrder").click(function() {
    // Retrieve and validate customer name
    var isChecked = $('#myCheckbox').is(":checked") ? 1 : 0;
    var custName = $('#customerInput').val();
    if (custName === '') {
        Swal.fire("Enter Customer Name");
        $('#customerInput').focus();
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
    var prodName = $('#productsInput').val();
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
    var customer_id = $('#custid').val();
    var product_id = $('#prodid').val();
    
  

    
    

    // Send AJAX request to add order
    $.ajax({
        url: base_path+"/admin/add_order",
        type: "POST",
        dataType: "json",
        data: {
            _token: $("#_tokenOrder").val(),
            isChecked: isChecked,
            cusrID:customer_id,
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
            prodID:product_id,
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
            url: base_path + "/admin/searchcustomerdata",
            type: "GET",
            dataType: "JSON",
            contentType: false,
            processData: false,
            data: formData,
            cache: false,
            success: function(result) {
            
                var options = '';
                if (result.customers.length == 0) {
                    options += "<option value=''>No Record Found ...</option>";
                } else {
                    for (var i = 0; i < result.customers.length; i++) {
                        options += `<option value="${result.customers[i]._id}">${result.customers[i].custName}</option>`;
                    }
                }
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

// function updateStatus(select) {
//     // var orderId = {{ $order->id }};
//     var orderId = $(this).data('user-ids');
//     var newStatus = select.value;

//     $.ajax({
//         type: "POST",
//         url: "{{ route('update_order_status') }}",
//         data: {
//             order_id: orderId,
//             new_status: newStatus,
//             _token: '{{ csrf_token() }}'
//         },
//         success: function(response) {
//             if (response.success) {
//                 // Update table dynamically, for example:
//                 $('#order-table').load(location.href + ' #order-table');
//             } else {
//                 alert('Error: ' + response.message);
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(xhr.responseText);
//         }
//     });
// }
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

    $(document).ready(function() {
        // Populate dropdown with product options
        $.ajax({
            url: '/products', // Replace with your route to fetch products
            type: 'GET',
            success: function(response) {
                if (response.status) {
                    var dropdown = $('#productDropdown');
                    $.each(response.data, function(index, product) {
                        dropdown.append($('<option></option>').val(product.id).text(product.name));
                    });
                } else {
                    console.error(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).ready(function() {
        $('#prodName').on('input', function() {
            var productName = $(this).val();
            if (productName === '') {
                $('products').empty();
                return;
            }
            
            
            $.ajax({
                url: base_path + "/admin/get_product",
                type: 'GET',
                success: function (response) {
                    var datalist = $('products');
                    var he = "hello0";
                    console.log(he);
                    datalist.empty();
                    response.forEach(function(productName) {
                        datalist.append('<option value="' + productName + '">');
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

}