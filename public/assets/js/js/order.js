// const { method } = require("lodash");


var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip({
        html: true,
        trigger: 'hover'
    });

$("#chan").click(function(){
    $('#statusChange').modal("show");
});
    
   
$(".createOrderModalStore").click(function(){
        // populateBrowserList();
        // $('#addOrderModal').modal("show");
        $('#addOrderModal').modal({
            backdrop:'static',
            keyboard:false
        }).modal("show");

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
                    // console.log(orderData);
                    if (orderData) {
                        $('#editProductContainer').empty();
                        orderData.product.forEach(function(product, index) {
                            var productDetailBlock =
                             `
                                <div class="card mb-3 border border-dark  edit_multiple">
                                    <div class="card-header">
                                        <h6 class="mb-0">Product Details: ${index + 1}</h6>
                                    </div>
                                 <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <input type="text" name="editprodid" id="editprodid" value="${product.product_id}" hidden>
                                    <label  for="prodName">Product Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" list="product_list" id="edit_prodName" name="edit_prodName[${index}]" value="${product.prodName}">
                                    <datalist id="product_list"></datalist>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="product_type">Product Type<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_product_type[${index}]" id="edit_product_type" placeholder="Product Type" value="${product.product_type}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="email">DESIGN NAME<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_designName[${index}]" id="edit_designName" placeholder="Color Name" value="${product.design_name}">
                                </div>

                                  <div class="form-group col-md-3">
                                    <label for="editdesignlist">DESIGN NAME<span class="required"></span></label>
                                    <select class="form-control" id="editdesignlist">
                                        <option value="" selected>Select a Design</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="color_name">Color Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_ColourName[${index}]" id="edit_ColourName" placeholder="Color Name" value="${product.color_name}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="edit_colorlist">Color Name</label>
                                    <select class="form-control edit_colorlist" id="#" onchange="showCustomColorInput()">
                                        <option value="" selected>Select a color</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                            <div class="form-group col-md-3">
                                    <label for="prod_qty">PCS/SQFT<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_pic_sqf[${index}]" id="edit_pic_sqf" placeholder="PCS/SQFT" value="${product.pcs_sqft}" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">SQFT/PCS<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_sqft_pic[${index}]" id="edit_sqft_pic" placeholder="SQFT/PCS" value="${product.sqft_pcs}" >
                                </div>
                             
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">QUANTITY IN SQFT<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_quantity_in_soft[${index}]" id="edit_quantity_in_soft" placeholder="Product Quantity" value="${product.quantity_in_soft}" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">QUANTITY IN PIECES<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_quantity_in_pieces[${index}]" id="edit_quantity_in_pieces" placeholder="Product Quantity" value="${product.quantity_in_pieces}">
                                </div>
                            </div>
                            </div>
                            `;
                            
                           

                            
                            populateProductListForEdit();

                            function populateProductListForEdit() {
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
                                        $('#edit_prodName').on('input', function() {
                                            var selectedName = $(this).val();
                                            var selectedOption = $('option[value="' + selectedName + '"]');
                                            var selectedproduct_type = selectedOption.data('product_type');
                                
                                            $('#edit_product_type').val(selectedproduct_type);

                                            $.ajax({
                                                url: 'admin/get_designlist/' + selectedName,
                                                type: 'GET',
                                                success: function(data) {
                                                    console.log(data);
                                                    var options = '<option value="" selected>Select a Design</option>';
                                                    
                                                    $.each(data, function(index, designs){
                                                            options += '<option value="'+designs.designname._id+'">'+designs.designname.design_name+'</option>';
                                              
                                                });
                                                    $('#editdesignlist').html(options);
                                                     // Populate the dropdown

                                                    
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(error);
                                                }
                                                });
                                            
                                        });
                                    },
                                    error: function(error){
                                        console.error("data not fetched", error);
                                    }
                                });
                        
                            }

    

                            // FatchDesignNameForEdit();

                            function FatchDesignNameForEdit(){
                                var productName = product.prodName;

                                // Make AJAX request to fetch designs for the selected product
                                    $.ajax({
                                    url: 'admin/get_designlist/' + productName,
                                    type: 'GET',
                                    success: function(data) {
                                        console.log(data);
                                        // var options = '<option value="" selected>Select a Design</option>';
                                        
                                        $.each(data, function(index, designs){
                                            console.log(designs);
                                                options += '<option value="'+designs.designname._id+'">'+designs.designname.design_name+'</option>';
                                  
                                    });
                                        $('#editdesignlist').html(options); // Populate the dropdown
                                                    
                                        // var defaultdesignName = product.design_name;
                                        console.log(defaultdesignName);
                                        $('#editdesignlist').val(defaultDesignName);
                                        
                                        // $('#editdesignlist option').filter(function() {
                                        //     var ee = $(this).text()
                                        //     console.log(ee);
                                        //     return $(this).text() === defaultdesignName;
                                        // }).prop('selected', true);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                    });
                             
                            }
                            

                            // console.log(product.prodName);
                            $('#editProductContainer').append(productDetailBlock);

                        });
                        
                        fetchColorsNamesforEdit(); 

                        function fetchColorsNamesforEdit() {
                
                            // var formData = $(this).serialize();
                            $.ajax({
                                url: '/admin/find_color', // Replace with your route URL
                                method: 'GET',
                                // data: formData, // Pass search term if needed
                                success: function(data) {
                                    // var colorSelect = $('#edit_colorlist'); 
                                        
                                    $.each(data, function(index, color) {
                                        
                                        options += '<option value="' + color.color._id + '">' + color.color.color_name + '</option>';
                                    });

                                    $('.edit_colorlist').html(options);

                                    // Set default color options if needed
                                    // orderData.product.forEach(function(product, index) {
                                    //     var defaultColorName = product.color_name;
                                    //     $('.edit_colorlist').eq(index).val(defaultColorName);
                                    // });
                                    // colorsFetched = true;
                                    // $('.edit_colorlist').html(options); 

                                    // var defaultColorName = product.color_name;
                                  

                                    console.log(product);

                                
                                    // $('.edit_colorlist option').filter(function() {
                                    //     return $(this).text() === defaultColorName;
                                    // }).prop('selected', true);
                    
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error fetching color names:', error);
                                }
                            });
                        }


                        // console.log("_id", orderData); // Logging _id for debugging
                        // $('#edit_prodid').val(orderData._id);
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
                        // $('#edit_prodName').val(orderData.product.prodName);
                        // $('#edit_product_type').val(orderData.product.product_type);
                        // $('#edit_prod_code').val(orderData.product.prod_code);
                        // $('#edit_designName').val(orderData.product.design_name);
                        // $('#edit_ColourName').val(orderData.product.ColourName);
                        // $('#edit_total_quantity').val(orderData.total_quantity);
                        // $('#edit_price').val(orderData.price);
                        // $('#edit_Billing_address').val(orderData.Billing_address);
                        // $('#edit_Delivery_address').val(orderData.Delivery_address);
                        // $('#edit_status').val(orderData.status);
                        // $('#edit_quantity_in_soft').val(orderData.quantity_in_soft);
                        // $('#edit_quantity_in_pieces').val(orderData.quantity_in_pieces);
                        $('#edit_order_remark').val(orderData.order_remark);
                        $('#edit_dispatch_remark').val(orderData.dispatch_remark);
                        $('#edit_order_date').val(orderData.order_date);
                        $('#edit_disptach_date').val(orderData.disptach_date);
                        $('#edit_tentative_date').val(orderData.tentative_date);
        
                        if (orderData.box_packed == 1) {
                            $('#edit_box_packed').prop('checked', true);
                        } else {
                            $('#edit_box_packed').prop('checked', false);
                        }
                        if (orderData.ordertype == "Sample Order") {
                            $('#editsampleOrderFields').show();
                            $('#editordertype').val(orderData.ordertype);
                            $('#edittransportname').val(orderData.transportname);
                            $('#edittrackingdetails').val(orderData.trackingdetails);
                        } else {
                            $('#editordertype').val(orderData.ordertype);
                            $('#editsampleOrderFields').hide();
                        }
                        $('#edit_box_packed').on('change', function() {
                            orderData.box_packed = $(this).prop('checked') ? 1 : 0;
                        });
                        
                        
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
        
        // var formData = new FormData();
        // Gather product details
        // var editproductsData = [];
      

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
        // var edit_prodName = $('#edit_prodName').val();
        // var edit_product_type = $('#edit_product_type').val();
        // var edit_prod_code = $('#edit_prod_code').val();
        // var edit_ColourName = $('#edit_ColourName').val();
        // var edit_total_quantity = $('#edit_total_quantity').val();
        // var edit_price = $('#edit_price').val();
        // var edit_Billing_address = $('#edit_Billing_address').val();
        // var edit_Delivery_address = $('#edit_Delivery_address').val();
        // var edit_quantity_in_soft = $('#edit_quantity_in_soft').val();
        // var edit_quantity_in_pieces = $('#edit_quantity_in_pieces').val();
        var edit_order_remark = $('#edit_order_remark').val();
        var edit_dispatch_remark = $('#edit_dispatch_remark').val();
        var edit_order_date = $('#edit_order_date').val();
        var edit_disptach_date = $('#edit_disptach_date').val();
        var edit_tentative_date = $('#edit_tentative_date').val();
        var edit_designName = $('#edit_designName').val();
        var edit_box_packed = $('#edit_box_packed').val();
        var edittransportname = $('#edittransportname').val();
        var edittrackingdetails = $('#edittrackingdetails').val();
        var edit_box_packed = $('#edit_box_packed').prop('checked') ? 1 : 0;
   
      
        

          
        // var form = document.forms.namedItem("editCompanyForm");
        var formData = new FormData();

        $('.editProductContainer').each(function(index) {
            var editproduct = {
                product_id: $(this).find('#editprodid').val(),
                prodName: $(this).find('#edit_prodName').val(),
                product_type: $(this).find('#edit_product_type').val(),
                design_name: $(this).find('#edit_designName').val(),
                color_name: $(this).find('#edit_ColourName').val(),
                quantity_in_soft: $(this).find('#edit_quantity_in_soft').val(),
                quantity_in_pieces: $(this).find('#edit_quantity_in_pieces').val(),
                // Add other product details here
            };
            formData.append('products[' + index + ']', JSON.stringify(editproduct));
            console.log(editproduct);
        });
        
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
        formData.append('order_remark', edit_order_remark);
        formData.append('dispatch_remark', edit_dispatch_remark);
        formData.append('order_date', edit_order_date);
        formData.append('disptach_date', edit_disptach_date);
        formData.append('tentative_date', edit_tentative_date);
        // formData.append('design_name', edit_designName);
        formData.append('box_packed', edit_box_packed);
        formData.append('transportname', edittransportname);
        formData.append('trackingdetails', edittrackingdetails);
        formData.append('box_packed', edit_box_packed); 
        
        
    // console.log(formData);
        
                   
         
        $.ajax({
            url: base_path + "/admin/update_order",
            type: 'post',
            datatype: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                console.log(formData);
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
        var status = $(this).data('user-status');
        var master_id = $(this).data('user-master_id');
        console.log(status);


        // var userId = $(this).data('user-id');
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_order",
        type: "POST",
        dataType: "json",
        data: {
            status:status,
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
                        var selectedColorName = selectedOption.data('colorname');
                        var selectedRoll_weight = selectedOption.data('prodid');
                    
                        
                     
                        $('#product_type').val(selectedproduct_type);
                        $('#prod_code').val(selectedprod_code);
                        $('#prod_qty').val(selectedprod_qty);
                        $('#ColourName').val(selectedColorName);
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
        
           
            


            // Event handler for change in color selection
            $('#edit_colorlist').change(function() {
                var colour_id = $(this).val();
                var color_name = $('#edit_colorlist option[value="' + colour_id + '"]').text(); // Get selected color name
        
                // Use the selected color_id and color_name as needed
            });
     
        // Function to call when showing the edit form or when needed to update the color list
        function updateEditColorList() {
            fetchColorsNamesforEdit('', '#edit_colorlist');
        }




            fetchColorsNames();

            function fetchColorsNames(searchTerm) {
                $.ajax({
                    url: '/admin/find_color', // Replace with your route URL
                    method: 'GET',
                    data: { searchTerm: searchTerm }, // Pass search term if needed
                    success: function(data) {
                        var colorSelect = $('#colorlist');

                        data.forEach(function(color) {
                        colorSelect.append('<option value="' + color.color._id + '">' + color.color.color_name + '</option>');
                        });
        
                        },
                    error: function(xhr, status, error) {
                        console.error('Error fetching color names:', error);
                    }
                });
            }
            
        
            $('#edit_colorlist').change(function() {
                var colour_id = $(this).val();
                
                var color_name = $('#colorlist option[value="' + colour_id + '"]').text(); // Get selected color name
            
               
            });

            
    $('.view-order').click(function(e) {
        e.preventDefault();
        var userId = $(this).data('user-ids');
        var status = $(this).data('user-status');
        var master_id = $(this).data('user-master_id');
        // console.log(status);
        
        $.ajax({
            type:'GET',
            url:base_path+"/orderdetails",
            data: {
                status:status,
                id: userId,
                master_id: master_id
            },
            success:function(response){

                window.location.href = base_path + "/orderdetails?id=" + userId + "&master_id=" + master_id + "&status=" +status;
            }, error: function(xhr) {
                console.log(xhr.responseText);
            }
            
        });

    });


});


document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


document.getElementById('productsInput').addEventListener('change', function() {
    var product = this.value;
    console.log(product);
    // Make AJAX request to fetch designs for the selected product
    $.ajax({
      url: 'admin/get_designlist/' + product,
      type: 'GET',
      success: function(data) {
        var options = '<option value="" selected>Select a Design</option>';
        $.each(data, function(index, designs){
   
                // console.log(design._id); // Make sure this is returning the array of designs
                options += '<option value="'+designs.designname._id+'">'+designs.designname.design_name+'</option>';

        });
        $('#designlist').html(options); // Populate the dropdown
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });

  $('#designlist').on('change', function() {
    var designId = $(this).val();
    // var productID = $('#prodid').val(); + '?productId=' + productID
    
    // Make AJAX request to fetch data for the selected design
    $.ajax({
        url: 'admin/get_design_data/' + designId ,
        type: 'GET',
        success: function(data) {
            // Handle the fetched data here, e.g., display it on the page
            console.log(data);
            $('#pcs_sqft').val(data[0].designname.pcs_sqft);
            $('#sqft_pcs').val(data[0].designname.sqft_pcs);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});




  
function showCustomColorInput() {
    var select = document.getElementById("colorlist");
    // console.log("select");
    var customColorInput = document.getElementById("customColorInput");
    if (select.value === "custom") {
        customColorInput.style.display = "block";
        
    } else {
        customColorInput.style.display = "none";
    }
}

function addCustomColor() {
    var customColorValue = document.getElementById("customColorValue").value;
    $.ajax({
        url: '/admin/add_color', // Replace with your route URL for adding color
        method: 'get',
        data: { color_name: customColorValue }, // Pass the custom color name
        success: function(data) {
            window.location.href = base_path+"/order";
            // If the color was successfully added, update the dropdown
            var colorSelect = $('#colorlist');
            // colorSelect.append('<option value="' + data.color._id + '">' + data.color.color_name + '</option>');
            data.forEach(function(color) {
                colorSelect.append('<option value="' + color.color._id + '">' + color.color.color_name + '</option>');
                });

            // Optionally, you can select the newly added color in the dropdown
            colorSelect.val(color.color._id);

            // Hide the custom color input
            $('#customColorInput').hide();
        },
        error: function(xhr, status, error) {
            console.error('Error adding custom color:', error);
            // Handle error if necessary
        }
    });
}

// For Multiplay Product blck

document.addEventListener("DOMContentLoaded", function() {
    
    // Function to reattach event listeners for custom color input
    function attachCustomColorInputListener(select, customColorInput) {
        select.addEventListener("change", function() {
            if (select.value === "custom") {
                customColorInput.style.display = "block";
            } else {
                customColorInput.style.display = "none";
            }
        });
    }

    // Function to populate product list and set product details
    function populateProductListAndSetDetails(productDetailsBlock) {
        // Function to set product details based on selected product name
        function setProductDetails(selectedOption) {
            var selectedproduct_type = selectedOption.data('product_type');
            var selectedprod_code = selectedOption.data('prod_code');
            var selectedprod_qty = selectedOption.data('prod_qty');
            var selectedColorName = selectedOption.data('colorname');
            var selectedRoll_weight = selectedOption.data('prodid');

            $('#product_type', productDetailsBlock).val(selectedproduct_type);
            $('#prod_code', productDetailsBlock).val(selectedprod_code);
            $('#prod_qty', productDetailsBlock).val(selectedprod_qty);
            $('#ColourName', productDetailsBlock).val(selectedColorName);
            $('#prodid', productDetailsBlock).val(selectedRoll_weight);
        }

        $.ajax({
            url: base_path + '/admin/searchproductdata',
            method: 'GET',
            success: function(data) {
                var datalist = $('#product_list', productDetailsBlock);
                datalist.empty();
                data.forEach(function(product) {
                    datalist.append('<option value="' + product.product.prodName + '" data-product_type="' + product.product.product_type + '" data-prod_code="' + product.product.prod_code + '" data-prod_qty="' + product.product.prod_qty + '" data-thickness="' + product.product.Thickness + '" data-width="' + product.product.Width + '" data-colorname="' + product.product.ColorName + '" data-roll_weight="' + product.product.Roll_weight + '" data-prodid="' + product.product._id + '">');
                });

                // Event listener for selecting an option
                $('#productsInput', productDetailsBlock).on('input', function() {
                    var selectedName = $(this).val();
                    var selectedOption = $('option[value="' + selectedName + '"]', productDetailsBlock);
                    setProductDetails(selectedOption);
                });
            },
            error: function(error) {
                console.error("data not fetched", error);
            }
        });
    }


    // Function to fetch and populate design list based on selected product name
    function populateDesignList(productDetailsBlock) {
        
        $('#productsInput', productDetailsBlock).on('change', function() {
            var product = this.value;
            $.ajax({
                url: 'admin/get_designlist/' + product,
                type: 'GET',
                success: function(data) {
                    var options = '<option value="" selected>Select a Design</option>';
                    $.each(data, function(index, designs) {
                            options += '<option value="' + designs.designname._id + '">' + designs.designname.design_name + '</option>';

                    });
                    $('#designlist', productDetailsBlock).html(options);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    }

    function populateDesignData(productDetailsBlock) {
        $('#designlist',productDetailsBlock).on('change', function() {
            var designId = $(this).val();
            // Make AJAX request to fetch data for the selected design
            $.ajax({
                url: 'admin/get_design_data/' + designId ,
                type: 'GET',
                success: function(data) {
                    // Handle the fetched data here, e.g., display it on the page
                    $('#pcs_sqft',productDetailsBlock).val(data[0].designname.pcs_sqft);
                    $('#sqft_pcs',productDetailsBlock).val(data[0].designname.sqft_pcs);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    }

    const sqrf_pcs = document.getElementById("sqft_pcs");
    const pcs_sqft = document.getElementById("pcs_sqft");

    const quantity_in_soft = document.getElementById("quantity_in_soft");
    const quantity_in_pieces = document.getElementById("quantity_in_pieces");

    pcs_sqft.addEventListener("input", updateQuantityInSoft);
    quantity_in_soft.addEventListener("input", QuantityInSqft);
    
    sqrf_pcs.addEventListener("input", QuantityInSqft);
    quantity_in_pieces.addEventListener("input", updateQuantityInSoft);

    function QuantityInSqft(productDetailsBlock) {
        const pcs_sqft = productDetailsBlock.querySelector("#pcs_sqft");
        
        const quantity_in_soft = productDetailsBlock.querySelector("#quantity_in_soft");
        const quantity_in_pieces = productDetailsBlock.querySelector("#quantity_in_pieces");
    
        pcs_sqft.addEventListener("input", function() {
            const pcs_sqft_val = parseFloat(pcs_sqft.value);
            const quantity_in_soft_val = parseFloat(quantity_in_soft.value);
            if (!isNaN(pcs_sqft_val) && !isNaN(quantity_in_soft_val)) {
                const quantity_in_pieces_val = pcs_sqft_val * quantity_in_soft_val;
                quantity_in_pieces.value = quantity_in_pieces_val;
            } else {
                quantity_in_pieces.value = "";
            }
        });
    
        quantity_in_soft.addEventListener("input", function() {
            const pcs_sqft_val = parseFloat(pcs_sqft.value);
            const quantity_in_soft_val = parseFloat(quantity_in_soft.value);
            if (!isNaN(pcs_sqft_val) && !isNaN(quantity_in_soft_val)) {
                const quantity_in_pieces_val = pcs_sqft_val * quantity_in_soft_val;
                quantity_in_pieces.value = quantity_in_pieces_val;
            } else {
                quantity_in_pieces.value = "";
            }
        });
    }
    
    function updateQuantityInSoft(productDetailsBlock) {
        const sqrf_pcs = productDetailsBlock.querySelector("#sqft_pcs");
        const quantity_in_soft = productDetailsBlock.querySelector("#quantity_in_soft");
        const quantity_in_pieces = productDetailsBlock.querySelector("#quantity_in_pieces");
    
        sqrf_pcs.addEventListener("input", function() {   
            const sqrf_pcs_val = parseFloat(sqrf_pcs.value);
            const quantity_in_pieces_val = parseFloat(quantity_in_pieces.value);
            if (!isNaN(sqrf_pcs_val) && !isNaN(quantity_in_pieces_val)) {
                const quantity_in_soft_val = quantity_in_pieces_val * sqrf_pcs_val;
                quantity_in_soft.value = quantity_in_soft_val;
            } else {
                quantity_in_soft.value = "";
            }
        });
    
        quantity_in_pieces.addEventListener("input", function() {
            const sqrf_pcs_val = parseFloat(sqrf_pcs.value);
            const quantity_in_pieces_val = parseFloat(quantity_in_pieces.value);
            if (!isNaN(sqrf_pcs_val) && !isNaN(quantity_in_pieces_val)) {
                const quantity_in_soft_val = quantity_in_pieces_val * sqrf_pcs_val;
                quantity_in_soft.value = quantity_in_soft_val;
            } else {
                quantity_in_soft.value = "";
            }
        });
    }

 

    // Get the Add Product button
    var addProductBtn = document.getElementById("addProductBtn");

    // Add click event listener to the Add Product button
    addProductBtn.addEventListener("click", function() {
        // Clone the product details block
        var productDetailsBlock = document.querySelector(".multiple").cloneNode(true);

        // Clear input values in the cloned block (optional)
        var inputs = productDetailsBlock.querySelectorAll("input");
        inputs.forEach(function(input) {
            input.value = "";
        });

        // Reattach event listener for custom color input
        var select = productDetailsBlock.querySelector("#colorlist");
        var customColorInput = productDetailsBlock.querySelector("#customColorInput");
        attachCustomColorInputListener(select, customColorInput);

        // Populate product list and set product details
        populateProductListAndSetDetails(productDetailsBlock);

        // Fetch and populate design list based on selected product name
        populateDesignList(productDetailsBlock);

        populateDesignData(productDetailsBlock);

        QuantityInSqft(productDetailsBlock);

        updateQuantityInSoft(productDetailsBlock);

        // Create and append the cancel button
        var cancelButton = document.createElement("button");
        cancelButton.textContent = "Cancel";
        cancelButton.classList.add("btn", "btn-danger", "mt-2");
        cancelButton.onclick = function() {
            // Remove the product details block when cancel button is clicked
            productDetailsBlock.remove();
        };
        productDetailsBlock.querySelector(".card-body").appendChild(cancelButton);

        // Append the cloned block to the parent container
        var placeholderDiv = document.getElementById("productDetailsPlaceholder");
        placeholderDiv.parentNode.insertBefore(productDetailsBlock, placeholderDiv);
    });

    // Initial call to attach event listener for custom color input
    var initialSelect = document.getElementById("colorlist");
    var initialCustomColorInput = document.getElementById("customColorInput");
    attachCustomColorInputListener(initialSelect, initialCustomColorInput);
});

function updateDatefild(){
    var startDate = new Date(document.getElementById("order_date").value);
    var increment = parseInt(document.getElementById("disptach_date").value);
    var endDate = new Date(startDate.getTime()+increment * 24 * 60 * 60 * 1000);
    document.getElementById("tentative_date").value = endDate.toISOString().slice(0,10);
    

}
document.addEventListener("DOMContentLoaded", function() {

const sqrf_pcs = document.getElementById("sqft_pcs");
const pcs_sqft = document.getElementById("pcs_sqft");

const quantity_in_soft = document.getElementById("quantity_in_soft");
const quantity_in_pieces = document.getElementById("quantity_in_pieces");

sqrf_pcs.addEventListener("input", QuantityInSqft);
quantity_in_soft.addEventListener("input", QuantityInSqft);

pcs_sqft.addEventListener("input", updateQuantityInSoft);
quantity_in_pieces.addEventListener("input", updateQuantityInSoft);

function QuantityInSqft(){
    
    const pcs_sqft_val = parseFloat(pcs_sqft.value);
    const sqft_pcs_val = parseFloat(sqrf_pcs.value);
    const quantity_in_soft_val = parseFloat(quantity_in_soft.value);
    if (!isNaN(pcs_sqft_val) && !isNaN(quantity_in_soft_val)) {
        // Perform multiplication operation to get quantity in pieces
        const quantity_in_pieces_val = pcs_sqft_val * quantity_in_soft_val;
        quantity_in_pieces.value = quantity_in_pieces_val;
    } else {
        quantity_in_pieces.value = "";
    }
    
}

function updateQuantityInSoft(){
    const sqft_pcs_val = parseFloat(sqrf_pcs.value);
    const quantity_in_pieces_val = parseFloat(quantity_in_pieces.value);
    if (!isNaN(sqft_pcs_val) && !isNaN(quantity_in_pieces_val)) {
        const quantity_in_soft_val = quantity_in_pieces_val * sqft_pcs_val;
        quantity_in_soft.value = quantity_in_soft_val;
    } else {
        quantity_in_soft.value = "";
    }
}

});


function openModal(selectElement,orderId,oldStatus) {
    var newStatus = selectElement.value;
    var selectedStatus = selectElement.value;
    
    
    //  if(selectedStatus === 'dispatch'){
    //     var dis_newStatus = selectElement.value;
    //     $('#dispatchstatusChange').modal('show');
    //     $('#dis_status').val(dis_newStatus);
    //     $('#dis_old_status').val(oldStatus);
    //     $('#dis_order_id').val(orderId);

    //     $.ajax({
    //         url: base_path + '/orders/fetchProcessData', // Replace with your controller route
    //         type: 'GET', // or 'POST' based on your route configuration
    //         data: {
    //             id: orderId // Send any additional parameters needed
    //         },
    //         success: function (data) {
    //             // console.log(response.proorderData[0].order);
    //             populateTable(data);
                
    //         },
    //         error: function (xhr, status, error) {
    //             // Handle error
    //             console.error("Errors:", error);
    //         }
    //     });

    //     function populateTable(data){
            
    //         var products = data.proorderData[0].order.product; 
    //         var tableBody = document.querySelector('#orderTable tbody');
    //         var orderTypeSelect = document.getElementById('order_type');
            

    //         function toggleTextBoxVisibility() {
    //             var selectedOption = orderTypeSelect.options[orderTypeSelect.selectedIndex].value;
    //             var textBoxes = document.querySelectorAll('input[name^="partial_quantity"]');
    //              var remainingTextBoxes = document.querySelectorAll('input[name^="remaining_quantity"]');
        
    //             if (selectedOption === 'partial_order_type') {
    //                 textBoxes.forEach(function(textBox) {
    //                     textBox.style.display = 'block';
    //                 });
    //                 remainingTextBoxes.forEach(function(textBox) {
    //                     textBox.style.display = 'block';
    //                 });
    //             } else {
    //                 textBoxes.forEach(function(textBox) {
    //                     textBox.style.display = 'none';
    //                 });
    //                 remainingTextBoxes.forEach(function(textBox) {
    //                     textBox.style.display = 'none';
    //                 });
    //             }
    //         }

    //         function updateRemainingQuantity(index) {
    //             var partialQuantityInput = document.querySelector(`input[name="partial_quantity[${index}]`);
    //             var remainingQuantityInput = document.querySelector(`input[name="remaining_quantity[${index}]`);
    //             var product = products[index];
                
    //             if (partialQuantityInput && remainingQuantityInput && product) {
    //                 var partialQuantity = parseFloat(partialQuantityInput.value);
    //                 var pcsSqft = parseFloat(product.pcs_sqft);
                    
    //                 if (!isNaN(partialQuantity) && !isNaN(pcsSqft)) {
    //                     var remainingQuantity = partialQuantity * pcsSqft;
    //                     remainingQuantityInput.value = remainingQuantity;
    //                 }
    //             }
    //         }
            

    //         orderTypeSelect.addEventListener('change', toggleTextBoxVisibility);

    //         tableBody.innerHTML = '';
        
    //         // Assuming data is an array of objects with properties to populate the table
    //         products.forEach(function(product, index) {
    //             // console.log(product);
    //             var row = document.createElement('tr');
    //             row.innerHTML = `
    //                 <td>${index + 1}</td>
    //                 <td class="text-center" style="display: none;" id="product_id" >${product.product_id}</td>
    //                 <td class="text-center">${product.prodName}</td>
    //                 <td class="text-center">${product.product_type}</td>
    //                 <td class="text-center">${product.design_name}</td>
    //                 <td class="text-center">${product.color_name}</td>
    //                 <td class="text-center" id="quantity_in_soft_process">${product.quantity_in_soft}</td>
    //                 <td class="text-center" id="quantity_in_pieces_process">${product.quantity_in_pieces}</td>
    //                 <td class="text-center"><input type="text" class="form-control" name="partial_quantity[${index}]" value="" id="partial_quantity" placeholder="Partial Quantity"></td>
    //                 <td class="text-center"><input type="text" class="form-control" name="remaining_quantity[${index}]" value="" id="remaining_quantity" placeholder="Remaining Quantity"></td>
                    
    //             `;
    //             tableBody.appendChild(row);
    //             var partialQuantityInput = row.querySelector(`input[name="partial_quantity[${index}]`);
    //             if (partialQuantityInput) {
    //                 partialQuantityInput.addEventListener('input', function() {
    //                     updateRemainingQuantity(index);
    //                 });
    //             }
    //         });
    //         toggleTextBoxVisibility();

            
    //     }

    //     $('#dis_savesatatus').click(function(e) {
    //         e.preventDefault();
    //         var partial_quantity = $('#partial_quantity').val();
    //         var remaining_quantity = $('#remaining_quantity').val();
    //         var dis_order_type = $('#order_type option:selected').text();

    //         var receiver_name = $('#receiver_name').val();
    //         var dispatcher_name = $('#dispatcher_name').val();
    //         var orderid = $('#dis_order_id').val();
    //         var addoldStatus = $('#dis_old_status').val();
    //         var status=$('#dis_status').val();
    //         var order_type=$('#order_type option:selected').text();
    //         var note = $('#dis_note').val();
    
    
    
        
    //         var formData = {
    //             'status':status,
    //             'order_type': order_type,
    //             'note': note,
    //             'addoldStatus':addoldStatus,
    //             'partial_quantity':partial_quantity,
    //             'remaining_quantity':remaining_quantity,
    //             'dis_order_type':dis_order_type,
    //             'orderid':orderid,
    //             'receiver_name':receiver_name,
    //             'dispatcher_name':dispatcher_name,
    //             '_token': $('#_tokenOrder').val()
    //         };
    //         $.ajax({
    //             type: 'post',
    //             url: base_path+ "/orders/addnewStatus",
    //             dataType:"JSON", 
    //             data: formData,
    //             cache: false,
    //             success: function(result){  
    //                 console.log("Data being sent:", result);
    //                 console.log("sucess");
    //                 // $('#statusChange').modal('hide');
    //                 // window.location.href = base_path + "/order";
            
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("AJAX Error:", status, error); 
    //                 // $('#statusChange').modal('hide');
    //                 // window.location.href = base_path + "/order";
    //             }
    //         });
    //     });

    //     $('#dis_savesatatus').click(function(e) {
    //         var dis_order_type = $('#order_type option:selected').text();
    //         var products = [];
    //         // products.empty();

    //         $('#orderTable tr').each(function(index) {
    //             if ($(this).find('#quantity_in_soft_process').length > 0 && $(this).find('#quantity_in_pieces_process').length > 0) {
    //             var quantity_in_soft_process = $(this).find('#quantity_in_soft_process').text();
    //             var quantity_in_pieces_process = $(this).find('#quantity_in_pieces_process').text();
    //             var partial_quantity = $(this).find('#partial_quantity').val();
    //             var remaining_quantity = $(this).find('#remaining_quantity').val();
    //             var product_id = $(this).find('#product_id').text();
    //             // console.log(product_id);

    //             var updateQuanInSqft = parseFloat(quantity_in_soft_process) - parseFloat(remaining_quantity);
    //             var updateQuanInPic = parseFloat(quantity_in_pieces_process) - parseFloat(partial_quantity);
                
    //             // Push quantities for each product to the products array
    //             products.push({
    //                 quantity_in_soft_process: parseFloat(quantity_in_soft_process),
    //                 quantity_in_pieces_process: parseFloat(quantity_in_pieces_process),
    //                 partial_quantity: parseFloat(partial_quantity),
    //                 remaining_quantity: parseFloat(remaining_quantity),
    //                 updateQuanInSqft: updateQuanInSqft,
    //                 updateQuanInPic: updateQuanInPic,
    //                 product_id:product_id
    //             });
    //         }
    //         });
          
                    
            // $.ajax({
            //     url: base_path+'/orders/updateStatus',
            //     type: 'POST',
            //     data: {
            //         oldstatus: oldStatus,
            //         newstatus: newStatus,
            //         id:orderId,
            //         // remaining_quantity:remaining_quantity,
            //         // partial_quantity:partial_quantity,
            //         dis_order_type:dis_order_type,
            //         products: products,
            //         // updateQuanInSqft:updateQuanInSqft,
            //         // updateQuanInPic:updateQuanInPic,
            //         '_token': $('#_tokenOrde').val()
            //     },
            //     success: function(response) {
            //         // Handle success response  
            //         console.log(response);
            //         console.log("sucess");
            //         Swal.fire({
            //             title: "Success",
            //             text: "Order Sucessfully Dispatched",
            //             icon: "success",
            //           }).then(() => {
            //             window.location.href = base_path + "/order";
            //           });
            //             // window.location.href = base_path+"/order";
            //             // Swal.fire("sucess", "Order Sucessfully Dispatched");
            //     },
            //     error: function(xhr, status, error) {
            //         // Handle error
            //         // console.error(xhr.responseText);
            //         console.error("Errorsd:", error);
            //         console.log("not sucess");
            //     }
            // });
        // });
    // }
    if(selectedStatus === 'processing'){
        console.log("pro");

    $.ajax({
        url: base_path+'/orders/updateStatus',
        type: 'POST',
        data: {
            oldstatus: oldStatus,
            newstatus: newStatus,
            id:orderId,
            '_token': $('#_tokenOrde').val()
        },
        success: function(response) {
            // Handle success response  
            console.log(response);
            console.log("sucess");

            // window.location.href = base_path+"/order";
            // Swal.fire("sucess", "Order Sucessfully Processed");
            Swal.fire({
                title: "Success",
                text: "Order Successfully Processed",
                icon: "success",
              }).then(() => {
                window.location.href = base_path + "/order";
              });
        },
        error: function(xhr, status, error) {
            // Handle error
            // console.error(xhr.responseText);
            console.error("Errorsd:", error);
            console.log("not sucess");
            // window.location.href = base_path+"/order";
            // Swal.fire("sucess", "Order Sucessfully Processed");
        }
    });
}

    else if(selectedStatus === 'dispatch'){
        console.log("dis");
        var dis_newStatus = selectElement.value;
            $('#dis_status').val(dis_newStatus);
            $('#dis_old_status').val(oldStatus);
            $('#dis_order_id').val(orderId);
                $.ajax({
                    url: base_path+'/orders/updateStatus',
                    type: 'POST',
                    data: {
                        oldstatus: oldStatus,
                        newstatus: newStatus,
                        id:orderId,                     
                        '_token': $('#_tokenOrde').val()
                    },
                    success: function(response) {                        
                        console.log(response);
                        console.log("sucess");
                        Swal.fire({
                            title: "Success",
                            text: "Order Sucessfully Dispatched",
                            icon: "success",
                        }).then(() => {
                            window.location.href = base_path + "/order";
                        });
                            
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            // console.error(xhr.responseText);
                            console.error("Errorsd:", error);
                            console.log("not sucess");
                        }
                    });

    }

    else if (selectedStatus === 'partialdispatch') {
        var dis_newStatus = selectElement.value;
        $('#dispatchstatusChange').modal({
            backdrop: 'static',
            keyboard: false
        }).modal("show");
    
        if (dis_newStatus === "partialdispatch") {
            $('#dis_status').val("Partial Dispatch");
        }
        $('#dis_old_status').val(oldStatus);
        $('#dis_order_id').val(orderId);
    
        $.ajax({
            url: base_path + '/orders/fetchProcessData', // Replace with your controller route
            type: 'GET', // or 'POST' based on your route configuration
            data: {
                id: orderId // Send any additional parameters needed
            },
            success: function (data) {
                console.log(data);
                populateTable(data);
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error("Errors:", error);
            }
        });
    
        function populateTable(data) {
            var products = data.proorderData[0].order.product;
            var tableBody = document.querySelector('#orderTable tbody');
    
            function updateRemainingQuantity(index) {
                var partialQuantityInput = document.querySelector(`input[name="partial_quantity[${index}]"]`);
                var remainingQuantityInput = document.querySelector(`input[name="remaining_quantity[${index}]"]`);
                var product = products[index];
    
                if (partialQuantityInput && remainingQuantityInput && product) {
                    var partialQuantity = parseFloat(partialQuantityInput.value);
                    var quantity_in_pieces = parseFloat(product.quantity_in_pieces);
    
                    if (!isNaN(partialQuantity) && !isNaN(quantity_in_pieces)) {
                        var remainingQuantity = quantity_in_pieces - partialQuantity;
                        remainingQuantityInput.value = remainingQuantity;
                    }
                }
            }
    
            tableBody.innerHTML = '';
    
            // Assuming data is an array of objects with properties to populate the table
            products.forEach(function (product, index) {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td class="text-center" style="display: none;" id="product_id">${product.product_id}</td>
                    <td class="text-center">${product.prodName}</td>
                    <td class="text-center">${product.product_type}</td>
                    <td class="text-center">${product.design_name}</td>
                    <td class="text-center">${product.color_name}</td>
                    <td class="text-center" id="quantity_in_soft_process">${product.quantity_in_soft}</td>
                    <td class="text-center" id="quantity_in_pieces_process">${product.quantity_in_pieces}</td>
                    <td class="text-center"><input type="text" class="form-control" name="partial_quantity[${index}]" value="" id="partial_quantity" placeholder="Partial Quantity"></td>
                    <td class="text-center"><input type="text" class="form-control" name="remaining_quantity[${index}]" value="" id="remaining_quantity" placeholder="Remaining Quantity"></td>
                `;
                tableBody.appendChild(row);
                var partialQuantityInput = row.querySelector(`input[name="partial_quantity[${index}]"]`);
                if (partialQuantityInput) {
                    partialQuantityInput.addEventListener('input', function () {
                        updateRemainingQuantity(index);
                    });
                }
            });
    
            $('#dis_savesatatus').click(function (e) {
                e.preventDefault();
    
                var productsData = [];
                // $('#dis_savesatatus').click(function(e) {
                //     if ($(this).find('#quantity_in_soft_process').length > 0 && $(this).find('#quantity_in_pieces_process').length > 0) {
                //         var quantity_in_soft_process = $(this).find('#quantity_in_soft_process').text();
                //         var quantity_in_pieces_process = $(this).find('#quantity_in_pieces_process').text();
                //         var partial_quantity = $(this).find('#partial_quantity').val();
                //         var remaining_quantity = $(this).find('#remaining_quantity').val();
                //         var product_id = $(this).find('#product_id').text();
    
                //         var updateQuanInSqft = parseFloat(quantity_in_soft_process) - parseFloat(remaining_quantity);
                //         var updateQuanInPic = parseFloat(quantity_in_pieces_process) - parseFloat(partial_quantity);
    
                //         productsData.push({
                //             quantity_in_soft_process: parseFloat(quantity_in_soft_process),
                //             quantity_in_pieces_process: parseFloat(quantity_in_pieces_process),
                //             partial_quantity: parseFloat(partial_quantity),
                //             remaining_quantity: parseFloat(remaining_quantity),
                //             updateQuanInSqft: updateQuanInSqft,
                //             updateQuanInPic: updateQuanInPic,
                //             product_id: product_id
                //         });
                //     }
                // });
    
                var formData = {
                    'status': $('#dis_status').val(),
                    'note': $('#dis_note').val(),
                    'addoldStatus': $('#dis_old_status').val(),
                    'vehicle_number': $('#vehicle_number').val(),
                    'vehicle_type': $('#vehicle_type').val(),
                    'partial_quantity': $('#partial_quantity').val(),
                    'remaining_quantity': $('#remaining_quantity').val(),
                    'orderid': $('#dis_order_id').val(),
                    'receiver_name': $('#receiver_name').val(),
                    'dispatcher_name': $('#dispatcher_name').val(),
                    '_token': $('#_tokenOrder').val(),
                    'products': productsData
                };
    
                $.ajax({
                    type: 'POST',
                    url: base_path + "/orders/addnewStatus",
                    dataType: "JSON",
                    data: formData,
                    cache: false,
                    success: function (result) {
                        console.log("Data being sent:", result);
                        console.log("success");
                        Swal.fire({
                            title: "Success",
                            text: "Partial Order Dispatched Successfully",
                            icon: "success",
                        }).then(() => {
                            window.location.href = base_path + "/order";
                        });
    
                        // Additional AJAX call for updating status
                        $.ajax({
                            url: base_path + '/orders/updateStatus',
                            type: 'POST',
                            data: {
                                oldstatus: $('#dis_old_status').val(),
                                newstatus: $('#dis_status').val(),
                                id: $('#dis_order_id').val(),
                                dis_order_type: 'partialdispatch', // or any relevant value
                                products: productsData,
                                '_token': $('#_tokenOrder').val()
                            },
                            success: function (response) {
                                // Handle success response  
                                console.log(response);
                                console.log("success");
                                $('#statusChange').modal('hide');
                                window.location.href = base_path + "/order";
                               
                            },
                            error: function (xhr, status, error) {
                                // Handle error
                                console.error("Errors:", error);
                                console.log("not success");
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $('#dis_savesatatus').click(function(e) {
                        var dis_order_type = $('#order_type option:selected').text();
                        var products = [];
                        // products.empty();
            
                        $('#orderTable tr').each(function(index) {
                            if ($(this).find('#quantity_in_soft_process').length > 0 && $(this).find('#quantity_in_pieces_process').length > 0) {
                            var quantity_in_soft_process = $(this).find('#quantity_in_soft_process').text();
                            var quantity_in_pieces_process = $(this).find('#quantity_in_pieces_process').text();
                            var partial_quantity = $(this).find('#partial_quantity').val();
                            var remaining_quantity = $(this).find('#remaining_quantity').val();
                            var product_id = $(this).find('#product_id').text();
                            // console.log(product_id);
            
                            var updateQuanInSqft = parseFloat(quantity_in_soft_process) - parseFloat(remaining_quantity);
                            var updateQuanInPic = parseFloat(quantity_in_pieces_process) - parseFloat(partial_quantity);
                            
                            // Push quantities for each product to the products array
                            products.push({
                                quantity_in_soft_process: parseFloat(quantity_in_soft_process),
                                quantity_in_pieces_process: parseFloat(quantity_in_pieces_process),
                                partial_quantity: parseFloat(partial_quantity),
                                remaining_quantity: parseFloat(remaining_quantity),
                                updateQuanInSqft: updateQuanInSqft,
                                updateQuanInPic: updateQuanInPic,
                                product_id:product_id
                            });
                        }
                        });
                      
                                
                        $.ajax({
                            url: base_path+'/orders/updateStatus',
                            type: 'POST',
                            data: {
                                oldstatus: oldStatus,
                                newstatus: newStatus,
                                id:orderId,
                                // remaining_quantity:remaining_quantity,
                                // partial_quantity:partial_quantity,
                                dis_order_type:dis_order_type,
                                products: products,
                                // updateQuanInSqft:updateQuanInSqft,
                                // updateQuanInPic:updateQuanInPic,
                                '_token': $('#_tokenOrde').val()
                            },
                            success: function(response) {
                                // Handle success response  
                                console.log(response);
                                console.log("sucess");
                                Swal.fire({
                                    title: "Success",
                                    text: "Order Sucessfully Dispatched",
                                    icon: "success",
                                  }).then(() => {
                                    window.location.href = base_path + "/order";
                                  });
                                    // window.location.href = base_path+"/order";
                                    // Swal.fire("sucess", "Order Sucessfully Dispatched");
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                // console.error(xhr.responseText);
                                console.error("Errorsd:", error);
                                console.log("not sucess");
                            }
                        });
                    });
        }
    }
    

        else if(selectedStatus === 'cancelled'){
            console.log("can");
        
        $.ajax({
            url: base_path+'/orders/updateStatus',
            type: 'POST',
            data: {
                oldstatus: oldStatus,
                newstatus: newStatus,
                id:orderId,
                '_token': $('input[name="_token"]').val()
            },
            success: function(response) {
                // Handle success response  
                console.log(response);
                console.log("sucess");

                // window.location.href = base_path+"/order";
                // Swal.fire("sucess", "Order Sucessfully Processed");
                Swal.fire({
                    title: "Success",
                    text: "Order Successfully Cancelld",
                    icon: "success",
                    }).then(() => {
                    window.location.href = base_path + "/order";
                    });
            },
            error: function(xhr, status, error) {
                // Handle error
                // console.error(xhr.responseText);
                console.error("Errorsd:", error);
                console.log("not sucess");
                // window.location.href = base_path+"/order";
                // Swal.fire("sucess", "Order Sucessfully Processed");
            }
        });
        
        }



//         else if(selectedStatus === 'dispatch'){

//             $.ajax({
//                 url: base_path+'/orders/updateStatus',
//                 type: 'POST',
//                 data: {
//                     oldstatus: oldStatus,
//                     newstatus: newStatus,
//                     id:orderId,
//                     '_token': $('#_tokenOrde').val()
//                 },
//                 success: function(response) {
//                     // Handle success response  
//                     console.log(response);
//                     console.log("sucess");
        
//                     window.location.href = base_path+"/order";
//                     // Swal.fire("sucess", "Order Sucessfully Processed");
//                     Swal.fire({
//                         title: "Success",
//                         text: "Order Successfully Move To Complete",
//                         icon: "success",
//                       }).then(() => {
//                         window.location.href = base_path + "/order";
//                       });
//                 },
//                 error: function(xhr, status, error) {
//                     // Handle error
//                     // console.error(xhr.responseText);
//                     console.error("Errorsd:", error);
//                     console.log("not sucess");
//                     // window.location.href = base_path+"/order";
//                     // Swal.fire("sucess", "Order Sucessfully Processed");
//                 }
//             });
            
//     }
// }


    // $('#dis_savesatatus').click(function(e) {
    //     e.preventDefault();
    //     var valu = $('#partial_quantity').val();
    //         console.log(valu);
    //     var orderid = $('#dis_order_id').val();
    //     var addoldStatus = $('#dis_old_status').val();
    //     var status=$('#dis_status').val();
    //     var order_type=$('#order_type option:selected').text();
    //     var note = $('#dis_note').val();



    
    //     var formData = {
    //         'status':status,
    //         'order_type': order_type,
    //         'note': note,
    //         'addoldStatus':addoldStatus,
    //         'orderid':orderid,
    //         '_token': $('#_tokenOrder').val()
    //     };
    //     $.ajax({
    //         type: 'post',
    //         url: base_path+ "",
    //         dataType:"JSON", 
    //         data: formData,
    //         cache: false,
    //         success: function(result){  
    //             console.log("Data being sent:", result);
    //             console.log("sucess");
    //             // $('#statusChange').modal('hide');
    //             // window.location.href = base_path + "/order";

                
    //         },
    //         error: function(xhr, status, error) {
    //             console.error("AJAX Error:", status, error); 
    //             // $('#statusChange').modal('hide');
    //             // window.location.href = base_path + "/order";
    //         }
    //     });
    // });
}



$("#saveOrder").click(function() {
    // Retrieve and validate customer name
    var isChecked = $('#box_packed').is(":checked") ? 1 : 0;
    var custName = $('#customerInput').val();
    if (custName === '') {
        Swal.fire("Enter Customer Name");
        $('#customerInput').focus();
        return false;
    }

    var colour_id = $(this).val();
    var design_id = $(this).val();

    var orderData = {
        _token: $("#_tokenOrder").val(),
        isChecked: isChecked,
        // Add other order details here
    };

    // Gather product details
    var productsData = [];
    $('.multiple').each(function(index) {
        var product = {
            product_id: $(this).find('#prodid').val(),
            prodName: $(this).find('#productsInput').val(),
            product_type: $(this).find('#product_type').val(),
            design_name: $(this).find('#designlist option:selected').text(),
            color_name: $(this).find('#colorlist option:selected').text(),
            quantity_in_soft: $(this).find('#quantity_in_soft').val(),
            quantity_in_pieces: $(this).find('#quantity_in_pieces').val(),
            pcs_sqft: $(this).find('#pcs_sqft').val(),
            sqft_pcs: $(this).find('#sqft_pcs').val(),
            // Add other product details here
        };
        productsData.push(product);
    });
    orderData.products = productsData;
    console.log(orderData.products);

    // Prepare order data
    var companylistcust = $('#companylistcust').val();
    var ordertype = $('#ordertype option:selected').text();
    var transportname = $('#transportname').val();
    var trackingdetails = $('#trackingdetails').val();
    var email = $('#email').val();
    var phoneno = $('#phoneno').val();
    var address = $('#address').val();
    var city = $('#city').val();
    var zipcode = $('#zipcode').val();
    var state = $('#state').val();
    var country = $('#country').val();
    var country = $('#country').val();
    var customer_refrence_number = $('#customer_refrence_number').val();
    var prodName = $('#productsInput').val();
    var product_type = $('#product_type').val();
    var prod_code = $('#prod_code').val();
    var prod_qty = $('#prod_qty').val();
    var colour_name = $('#colorlist option:selected').text();
    var colour_id=$('#colorlist').val();
    var total_quantity = $('#total_quantity').val(); // Adjusted key to match the modal input
    var price = $('#price').val();
    var Billing_address = $('#Billing_address').val();
    var Delivery_address = $('#Delivery_address').val();
    var price_type = $('#price_type').val();
    var status = $('#status').val();
    var order_remark = $('#order_remark').val();
    var dispatch_remark = $('#dispatch_remark').val();
    var order_date = $('#order_date').val();
    var disptach_date = $('#disptach_date').val();
    var tentative_date = $('#tentative_date').val();
    var customer_id = $('#custid').val();
    var product_id = $('#prodid').val();
    var design_name = $('#designlist option:selected').text();
    var design_id = $('#designlist').val();
    var quantity_in_soft = $('#quantity_in_soft').val();
    var quantity_in_pieces = $('#quantity_in_pieces').val();

    var neworderid = $('#new_order_id').val();
    if(neworderid === ''){
        neworderid = 'DD001';
    }
   

  

    
    

    // Send AJAX request to add order
    $.ajax({
        url: base_path+"/admin/add_order",
        type: "POST",
        dataType: "json",
        data: {
            _token: $("#_tokenOrder").val(),
            isChecked: isChecked,
            ordertype:ordertype,
            transportname:transportname,
            trackingdetails:trackingdetails,
            cusrID:customer_id,
            custName: custName,
            companylistcust: companylistcust,
            email: email,
            phoneno: phoneno,
            address: address,
            city: city,
            zipcode: zipcode,
            // ColorName: colour_name,
            // colour_id: colour_id,
            design_id:design_id,
            state: state,
            country: country,
            customer_refrence_number:customer_refrence_number,
            // custref: custref,
            orderData:orderData,
            prodID:product_id,
            prodName: prodName,
            product_type: product_type,
            prod_code: prod_code,
            prod_qty: prod_qty,
            total_quantity: total_quantity, // Adjusted key to match the modal input
            price: price,
            Billing_address: Billing_address,
            Delivery_address: Delivery_address,
            price_type: price_type,
            status: status,
            order_remark:order_remark,
            dispatch_remark:dispatch_remark,
            order_date:order_date,
            disptach_date:disptach_date,
            tentative_date:tentative_date,
            design_name:design_name,
            quantity_in_soft:quantity_in_soft,
            quantity_in_pieces:quantity_in_pieces,
            neworderid:neworderid,
            products: JSON.stringify(productsData)
            
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
        if (func == 'colorlist') {
            colorlistcust(dom, 'colorlist');
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