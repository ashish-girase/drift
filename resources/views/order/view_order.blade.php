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
                        <h5 class="mb-0">All Orders</h5>
                    </div>
                    <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createOrderModalStore" type="button">+&nbsp; New Order</a>
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
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Price</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Customer Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Email</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Phone No</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Address</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">City</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Zip Code</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">State</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Country</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($order_data)
                                @foreach($order_data as $key => $order)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->product['prodName'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->product['product_type'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->product['prod_code'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->product['Thickness'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->product['Width'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->product['ColourName'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->product['price'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['custName'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['email'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['phoneno'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['address'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['city'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['zipcode'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['state'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order->customer['country'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $order['status'] }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="mx-3 edit-product" data-user-ids="{{ $order->product['_id'] }}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <a href="#" class="mx-3 delete-product" data-user-ids="{{ $order->product['_id'] }}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip">
                                                <span>
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="17" class="text-center">No orders found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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

                   
                    <!--PRODUCT DETAILS-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Product Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="prodName">Product Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="prodName" id="prodName" placeholder="Product Name" onblur="getUserDetails()">
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
                                <div class="form-group col-md-6">
                                    <label for="color_name">Color Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="ColourName" id="ColourName" placeholder="Color Name">
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <!-- Status Dropdown -->
                    <div class="row">
                    
                   
                    </div>
                    <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="total_price">Total quantity<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="total_quantity" id="total_quantity" placeholder="Enter Total Quantity">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="price">Price<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="price" id="price" placeholder="Enter Price">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="billing_address">Billing Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="Billing_address" id="Billing_address" placeholder="Billing Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="delivery_address">Delivery Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="Delivery_address" id="Delivery_address" placeholder="Delivery Address">
                                </div>
                                <div class="form-group col-md-3">
                                        <label for="status">Status<span class="required"></span></label>
                                <select class="form-control custom-width" name="status" id="status">
                                        <option value="new" selected>New</option>
                                        <option value="processing">Processing</option>
                                        <option value="dispatch">Dispatch</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                </select>
                                </div>
                                <div class="form-group col-md-3">
                                        <label for="price_type">Price Type<span class="required"></span></label>
                                    <select class="form-control custom-width" name="price_type" id="price_type">
                                     <option value="x-factory">X-Factory</option>
                                     <option value="delivery">Delivery Price</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="notes">Notes<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="notes" id="notes" placeholder="Add Notes">
                                </div>

                        </div>
                        <form >
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" id="saveOrder">Save changes</button>
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
<!--PRODUCT SCRIPT-->

<!--END PRODUCT SCRIPT-->




   @endsection
