@extends('layouts.user_type.auth')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
<style>
    /* Style the dropdown options */
    #colorlistcust1 option {
        font-size: 14px; /* Set font size */
        color: #333; /* Set font color */
        padding: 5px 10px; /* Set padding */
        background-color: #ffffff; /* Set background color */
    }
</style>

<div>


            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">All Order</h5>
                                </div>

                                <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createOrderModalStore" type="button">+&nbsp; New Order</a>
                                <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->


                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">ID</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Product Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Product Type</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Product Code</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Thickness</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Width</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Colour Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($order_data)

                                        @foreach($order_data as $key => $cusData_val)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->product->prodName }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->product->product_type }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->product->prod_code }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->product->Thickness }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->product->Width }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->product->ColourName }}</p>
                                            </td>

                                            <td class="text-center">
                                                <a href="#" class="mx-3 edit-product"  data-user-ids="{{ $cusData_val->product->_id }}" data-user-master_id="{{ $cusData_val['_id'] }}" data-bs-toggle="tooltip">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                <a href="#" class="mx-3 delete-product" data-user-ids="{{ $cusData_val->product->_id }}" data-user-master_id="{{ $cusData_val['_id'] }}" data-bs-toggle="tooltip">
                                                  <span>
                                                        <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3"><center>Record Not Found</center></td>
                                        </tr>
                                        @endif
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--================================= create bank modal ============================= -->
                            <!-- Button trigger modal -->


                            <!-- Modal -->
                            <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Add Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    @csrf
                    <input type="hidden" name="_token" id="_tokenproduct" value="{{Session::token()}}">
                    
                    <!--CUSTOMER DETAILS-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Customer Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="custName">Customer Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="custName" id="custName" placeholder="Customer Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="companylistcust">Company Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="companylistcust" id="companylistcust" placeholder="Company Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="email">Customer Email<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="email" id="email" placeholder="Enter Email">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="phoneno">Customer Phone Number<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="phoneno" id="phoneno" placeholder="Phone No">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="address">Customer Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="address" id="address" placeholder="Enter Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="city">City<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="city" id="city" placeholder="City">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="zipcode">Zip Code<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="zipcode" id="zipcode" placeholder="Enter Zip Code">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="state">State<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="state" id="state" placeholder="State">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="country">Country<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="country" id="country" placeholder="Country">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="custref">Customer Reference<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="custref" id="custref" placeholder="Add Reference">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--COMPANY DETAILS-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Company Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="company_name">Company Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="company_name" id="company_name" placeholder="Enter Company Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ccode">Company Code<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="ccode" id="ccode" placeholder="Enter Company Code">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="caddress">Company Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="caddress" id="caddress" placeholder="Enter Company Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="company_city">City<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="company_city" id="company_city" placeholder="Enter City">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="company_zipcode">Zip Code<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="company_zipcode" id="company_zipcode" placeholder="Enter Zip Code">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="company_state">State<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="company_state" id="company_state" placeholder="State">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="company_country">Country<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="company_country" id="company_country" placeholder="Country">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="taxgstno">Tax/GST Number<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="taxgstno" id="taxgstno" placeholder="Tax No./GST No.">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="company_phoneno">Phone Number<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="company_phoneno" id="company_phoneno" placeholder="Phone No.">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="company_email">Email<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="company_email" id="company_email" placeholder="Enter Email">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="website">Website<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="website" id="website" placeholder="Website">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--PRODUCT DETAILS-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Product Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="prodName">Product Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="prodName" id="prodName" placeholder="Product Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="product_type">Product Type<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="product_type" id="product_type" placeholder="Product Type">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_code">Product Code<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="prod_code" id="prod_code" placeholder="Product Code">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">Product Quantity<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="prod_qty" id="prod_qty" placeholder="Product Quantity">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="Thickness">Product Thickness<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="Thickness" id="Thickness" placeholder="Product Thickness">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Width">Product Width<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="Width" id="Width" placeholder="Product Width">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="Roll_weight">Roll Weight<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="Roll_weight" id="Roll_weight" placeholder="Roll Weight">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--COLOR DETAILS-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Colour Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="color_name">Color Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="color_name" id="color_name" placeholder="Color Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Status Dropdown -->
                    <div class="row">
                    
                   
                    </div>
                    <div class="row">
                    <div class="form-group col-md-4">
                                    <label for="total_price">Total price<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="total_price" id="total_price" placeholder="Enter Total Price">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="billing_address">Billing Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="billing_address" id="billing_address" placeholder="Billing Address">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="delivery_address">Delivery Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="delivery_address" id="delivery_address" placeholder="Delivery Address">
                                </div>
                                <div class="form-group col-md-6">
                                        <label for="status">Status<span class="required"></span></label>
                                <select class="form-control custom-width" name="status" id="status">
                                        <option value="new" selected>New</option>
                                        <option value="processing">Processing</option>
                                        <option value="dispatch">Dispatch</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                </select>
                                </div>
                                <div class="form-group col-md-6">
                                        <label for="price_type">Price Type<span class="required"></span></label>
                                    <select class="form-control custom-width" name="price_type" id="price_type">
                                     <option value="x-factory">X-Factory</option>
                                     <option value="delivery">Delivery Price</option>
                                    </select>
                                </div>

                        </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" id="saveproduct">Save changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-width {
        max-width: 100%;
        width: 100%;
    }
    .card-header h6 {
        margin: 0;
    }
</style>



                        <!-- Edit Product -->
                        <div class="modal fade" id="edit_productModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="_tokeupdatenproduct" value="{{Session::token()}}">
                                                <input type="hidden" name="product_id"  id="edit_prodid">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="prodName"
                                                            id="edit_prodName" placeholder="Product Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Color Name<span
                                                                class="required"></span></label>
                                                        <!-- <input type="text" class="form-control" name="company_name"
                                                            id="company_name" placeholder="Company Name"> -->
                                                        <input list="companylistcust" placeholder="search here..." class="form-control" id="edit_colour_id"
                                                        name="colour_id" onkeyup="doSearch_sett(this.value,'companylistcust')"  autocomplete="off">
                                                        <datalist id="companylistcust1">
                                                        </datalist>
                                                        </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Prodcut Type<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="edit_product_type"
                                                            id="edit_product_type" placeholder="Prodcut Type">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product code<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="prod_code"
                                                            id="edit_prod_code" placeholder="Product code">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Quantity<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="prod_qty"
                                                            id="edit_prod_qty" placeholder="Product Quantity">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Thickness<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="Thickness"
                                                            id="edit_Thickness" placeholder="Product Thickness">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Width<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="Width"
                                                            id="edit_Width" placeholder="Product Width">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Roll weight<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="Roll_weight"
                                                            id="edit_Roll_weight" placeholder="Roll weight">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Color Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="color_name"
                                                            id="color_name" placeholder="Color Name">
                                                    </div>
                                                </div>
                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="updateproduct">Update changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>



   @endsection
