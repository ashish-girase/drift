var base_path = $("#url").val();
// var base_path = window.location.origin;

$(document).ready(function() {
    $(".createProductModalStore").click(function(){
        $('#addProdcutModal').modal("show"); 
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
                $('#edit_colour_name').val(productData.ColorName);
                $('#edit_product_type').val(productData.product_type);
                $('#edit_prod_code').val(productData.prod_code);
                $('#edit_prod_qty').val(productData.prod_qty);
                $('#edit_Thickness').val(productData.Thickness);
                $('#edit_Width').val(productData.Width);
                $('#edit_Roll_weight').val(productData.Roll_weight);
                

                $('#edit_colour_name').empty();
                $.each(colors, function(index, color) {
                    $('#edit_colour_name').append('<option value="' + color.colorName + '">' + color.colorName + '</option>');
                    console.log(colors);
                });
               

                // Assuming no arguments needed
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
        var confirmDelete = confirm("Are you sure you want to delete this?");
        if (confirmDelete) {
        $.ajax({
        // url: "{{ route('delete_user') }}",
        url: base_path+"/admin/delete_product",
        type: "POST",
        dataType: "json",
        data: {
            id: userId,
            master_id: master_id,
            _token: "{{ csrf_token  () }}"
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
    

    fetchColorNames();

    function fetchColorNames(searchTerm) {
        $.ajax({
            url: '/admin/get_colorlist', // Replace with your route URL
            method: 'POST',
            data: { searchTerm: searchTerm }, // Pass search term if needed
            success: function(data) {
                var colorSelect = $('#colorlistcust1');
                data.forEach(function(color) {
                colorSelect.append('<option value="' + color.color._id + '">' + color.color.color_name + '</option>');
                });
                },
            error: function(xhr, status, error) {
                console.error('Error fetching color names:', error);
            }
        });
    }
    

    $('#colorlistcust1').change(function() {
        var colour_id = $(this).val();
        var color_name = $('#colorlistcust1 option[value="' + colour_id + '"]').text(); // Get selected color name
    
    });
    
});


$("#saveproduct").click(function(){
    var colour_id = $(this).val();

    
    var prodName=$('#prodName').val();
    if(prodName=='')
    {
    Swal.fire( "Enter Product Name");
    $('#prodName').focus();
    return false;
    }
    var prodName=$('#prodName').val();
    var product_type=$('#product_type').val();
    var colour_id=$('#colorlistcust1').val();
    var colour_name= $('#colorlistcust1 option:selected').text();
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
            ColorName: colour_name,
            prod_code: prod_code,
            prod_qty: prod_qty,
            Thickness: Thickness,
            Width: Width,
            Roll_weight: Roll_weight
        },
        cache: false,
        success: function(Result) {

            if(Result){
                    swal.fire('order added successfully')
                    $("#addProdcutModal").modal("hide");
                    sessionStorage.setItem('successMessage_ord', 'Product added successfully');
                    window.location.href = base_path + "/product";
        }},
    });
});



const successMessage_pro = sessionStorage.getItem('successMessage_pro');
if (successMessage_pro) {
    Swal.fire(successMessage_pro);
    sessionStorage.removeItem('successMessage_pro');
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
        if (func == 'colorlistcust') {
            colorlistcust(dom, 'colorlistcust1');
          }
        }, 600);
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

    function fetchColorNames(searchTerm) {
        $.ajax({
            url: '/admin/get_colorlist', // Replace with your route URL
            method: 'GET',
            data: { searchTerm: searchTerm }, // Pass search term if needed
            success: function(response) {
                // Clear existing options
                $('#companylistcust1').empty();
                // Populate datalist with fetched color names
                response.forEach(function(colorName) {
                    $('#companylistcust1').append(`<option value="${colorName.color_name}">${colorName.color_name}</option>`);
                    console.log(colorName.color_name, colorName._id); // Access directly without color.color_name
                    
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching color names:', error);
            }
        });
    }
    $(document).ready(function() {
     
    });
    
    
}