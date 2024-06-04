@extends('layouts.user_type.auth')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
<style>
    /* Style the dropdown options */
    #colorlist option {
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
                    <table class="table align-items-center mb-0" id="ordertable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder">ID</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Customer Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Product Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Order Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Order Remarks</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Dispatch Remarks</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action</th>
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
    @if(!empty($order->order->customer->custName))
            <p class="text-xs font-weight-bold mb-0">{{ $order->order->customer->custName }}</p>
    @endif     
</td>
    <td class="text-center">
        <!-- <p class="text-xs font-weight-bold mb-0">{{ $order->order->status }}</p>-->
        <form method="POST"  >
    @csrf
    <!-- Hidden input fields for each data attribute -->
    <input type="hidden" name="id" id="orderid" value="{{ $order->order->_id }}">
    <input type="hidden" name="oldstatus" id="oldstatus" value="{{ $order->order->status }}">
    <input type="hidden" name="custName" value="{{ $order->order->customer->custName }}">
    <!-- Add more hidden input fields for other data attributes -->

    <select class="form-control custom-width" name="newstatus"  onchange="openModal(this)">
        <option value="new" {{ $order->order->status == 'new' ? 'selected' : '' }}>New</option>
        <option value="processing" {{ $order->order->status == 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="dispatch" {{ $order->order->status == 'dispatch' ? 'selected' : '' }}>Dispatch</option>
        <option value="completed" {{ $order->order->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $order->order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</form>



<script>
    function submitForm(selectElement) {
        // Get the form element containing the select dropdown
        var form = selectElement.form;
        console.log(form);
        // Submit the form
        form.submit();
    }
</script>

    </td>

<td class="text-center">
@if(!empty($order->order->product->prodName))
        <p class="text-xs font-weight-bold mb-0">{{ $order->order->product->prodName }}</p>
@endif
</td>
<td class="text-center">
        @if(!empty($order->order->order_date  ))    
        <p class="text-xs font-weight-bold mb-0">{{ $order->order->order_date }}</p>
        @endif
</td>
<td class="text-center">
        @if(!empty( $order->order->dispatch_remark))    
        <p class="text-xs font-weight-bold mb-0">{{ $order->order->dispatch_remark }}</p>
        @endif
</td>
<td class="text-center">
        @if(!empty($order->order->order_remark ))    
        <p class="text-xs font-weight-bold mb-0">{{ $order->order->order_remark }}</p>
        @endif
</td>
<td class="text-center">
        <!--EDIT BUTTON-->
        <a href="#" type="button" class="mx-3 edit-order" id="edit-order"  data-user-ids="{{ $order->order->_id}}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip">
            <i class="fas fa-user-edit text-secondary"></i>
        </a>
        <!--DELETE BUTTON-->
        <a href="#" class="mx-3 delete-order" data-user-ids="{{ $order->order->_id}}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip">
            <span>
                <i class="cursor-pointer fas fa-trash text-secondary"></i>
            </span>
        </a>
   
</td>

@endforeach
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
            <meta name="csrf-token" content="{{ csrf_token() }}" />
                <form method="post" id="customerForm">
                    @csrf
                    <input type="hidden" name="_token" id="_tokenOrder" value="{{Session::token()}}">
                    
                    <!--CUSTOMER DETAILS-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Customer Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group col-md-2">
                                <label for="custName">Order Type<span class="required"></span></label>
                                <select  class="form-control custom-width" name="ordertype" id="ordertype">
                                    <option value="normalorder">Normal Order</option>
                                    <option value="sampleorder">Sample Order</option>
                                </select>
                            </div>
                        
                            <div class="row">
                                <div class="form-group col-md-3">
                                <input type="text" name="custid" id="custid" hidden>
                                <label for="custName">PARTY NAME<span class="required"></span></label>
                                <input class="form-control custom-width" id="customerInput" name="customerInput" list="customer_list" placeholder="Select a Customer">
                                <datalist id="customer_list"></datalist>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="city">Email<span class="required"></span></label>
                                <input type="text" class="form-control custom-width" name="email" id="email" placeholder="Enter Email">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="city">Company Name<span class="required"></span></label>
                                <input type="text" class="form-control custom-width" name="companylistcust" id="companylistcust" placeholder="Enter Company Name">
                            </div>
                        
                                <div class="form-group col-md-3">
                                    <label for="address">Customer Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="address" id="address" placeholder="Enter Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="city">City<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="city" id="city" placeholder="City">
                                </div>
                        
                                
                                <div class="form-group col-md-3">
                                    <label for="phoneno">Customer Phone Number<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="phoneno" id="phoneno" placeholder="Phone No">
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
                                    <label for="custref">Customer Reference<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="custref" id="custref" placeholder="Add Reference">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="country">Country<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="country" id="country" placeholder="Country">
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
                                    <label  for="prodName">Product Name<span class="required"></span></label>
                                    <input type="text" name="prodid" id="prodid" hidden>
                                    <input type="text" class="form-control custom-width" list="product_list" id="productsInput" name="productsInput" placeholder="Select a Product">
                                    <datalist id="product_list"></datalist>

                                    
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
                                    <label for="email">DESIGN NAME<span class="required"></span></label>
                                    <select class="form-control" id="designlist">
                                        <option value="" selected>Select a color</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="colorSelect">Color Name</label>
    
                                    <select class="form-control" id="colorlist">
                                        <option value="" selected>Select a color</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">QUANTITY IN SQFT<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="quantity_in_soft" id="quantity_in_soft" placeholder="Product Quantity">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">QUANTITY IN PIECES<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="quantity_in_pieces" id="quantity_in_pieces" placeholder="Product Quantity">
                                </div>
                            </div>
                  
                        </div>
                    </div>

                   
                    <!-- Status Dropdown -->
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="companylistcust">ORDER DATE<span class="required"></span></label>
                            <input type="date" class="form-control custom-width" name="order_date" id="order_date" placeholder="Company Name">
                        </div>
                       
                        <div class="form-group col-md-3">
                            <label for="companylistcust"> DISPTACH DATE FROM PRODUCTION<span class="required"></span></label>
                            <input type="date" class="form-control custom-width" name="disptach_date" id="disptach_date" placeholder="Company Name">
                        </div>
                       
                        <div class="form-group col-md-3">
                            <label for="companylistcust">  TENTAITVE DISPATCH DATE<span class="required"></span></label>
                            <input type="date" class="form-control custom-width" name="tentative_date" id="tentative_date" placeholder="Company Name">
                        </div>
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
                                    <label for="notes">BOXES PACKED<span class="required"></span></label><br>   
                                    <input type="checkbox"  name="box_packed" id="box_packed" placeholder="ADD ORDER REMARKS">
                                </div>
                               
                                <div class="form-group col-md-6">
                                    <label for="order remark">ORDER REMARKS<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="order_remark" id="order_remark" placeholder="ADD ORDER REMARKS">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="order remark">DISPATCH REMARKS<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="dispatch_remark" id="dispatch_remark" placeholder="ADD ORDER REMARKS">
                                </div>

                                <div class="row" id="sampleOrderFields" style="display: none;">
                                    <div class="form-group col-md-6">
                                        <label for="transportname">COURIER/TRANSPORT NAME</label>
                                        <input type="text" class="form-control custom-width" name="transportname" id="transportname" placeholder="Enter Transport NAME">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="trackingdetails">TRACKING DETAILS</label>
                                        <input type="text" class="form-control custom-width" name="trackingdetails" id="trackingdetails" placeholder="Enter Tracking Details">
                                    </div>
                                </div>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" id="saveOrder">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Additional fields for sample orders -->




{{-- --------------------Edit Module----------------------- --}}

<div class="modal fade" id="editordermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <meta name="csrf-token" content="{{ csrf_token() }}" />
                <form method="post" id="customerForm">
                    @csrf
                    <input type="hidden" name="_token" id="_tokenOrder" value="{{Session::token()}}">
                    <input type="hidden" name="color_id"  id="edit_prodid">
                   
                    <!--CUSTOMER DETAILS-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Customer Details</h6>
                        </div>
                        <div class="card-body">
                        <div class="form-group col-md-3">
                            <label for="custName">Order Type<span class="required"></span></label>
                            <input class="form-control custom-width" id="editordertype" name="editordertype" list="customer_list" placeholder="Select a Customer">
                            {{-- <select  class="form-control custom-width" name="editordertype" id="editordertype">
                                <option value="normalorder">Normal Order</option>
                                <option value="sampleorder">Sample Order</option>
                            </select> --}}
                        </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                <input type="text" name="custid" id="custid" hidden>
                                <label for="custName">Customer Name<span class="required"></span></label>
                                <input class="form-control custom-width" id="edit_custName" name="edit_custName" list="customer_list" placeholder="Select a Customer">
                                <datalist id="customer_list"></datalist>
                            </div>
                                {{-- <div class="form-group col-md-3">
                                    <label for="custName">Customer Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="custName" id="custName" placeholder="Customer Name">
                                </div> --}}
                                <div class="form-group col-md-3">
                                    <label for="companylistcust">Company Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_companylistcust" id="edit_companylistcust" placeholder="Company Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="email">Customer Email<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_email" id="edit_email" placeholder="Enter Email">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="phoneno">Customer Phone Number<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_phoneno" id="edit_phoneno" placeholder="Phone No">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="address">Customer Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_address" id="edit_address" placeholder="Enter Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="city">City<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_city" id="edit_city" placeholder="City">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="zipcode">Zip Code<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_zipcode" id="edit_zipcode" placeholder="Enter Zip Code">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="state">State<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_state" id="edit_state" placeholder="State">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="country">Country<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_country" id="edit_country" placeholder="Country">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="custref">Customer Reference<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_custref" id="edit_custref" placeholder="Add Reference">
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
                                    <label  for="prodName">Product Name<span class="required"></span></label>
                                    <input type="text" name="prodid" id="prodid" hidden>
                                    <input type="text" class="form-control custom-width" list="product_list" id="edit_prodName" name="edit_prodName " placeholder="Select a Product">
                                    <datalist id="product_list"></datalist>

                                    
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="product_type">Product Type<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_product_type" id="edit_product_type" placeholder="Product Type">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_code">Product Code<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_prod_code" id="edit_prod_code" placeholder="Product Code">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="email">DESIGN NAME<span class="required"></span></label>
                                    {{-- <select class="form-control" id="edit_designlist">
                                        <option value="" selected>Select a color</option>
                                    </select> --}}
                                    <input type="text" class="form-control custom-width" name="edit_designName" id="edit_designName" placeholder="Color Name">
                                </div>
        
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="color_name">Color Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_ColourName" id="edit_ColourName" placeholder="Color Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">QUANTITY IN SQFT<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_quantity_in_soft" id="edit_quantity_in_soft" placeholder="Product Quantity">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prod_qty">QUANTITY IN PIECES<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_quantity_in_pieces" id="edit_quantity_in_pieces" placeholder="Product Quantity">
                                </div>
                            </div>
                        </div>
                    </div>

                   
                    <!-- Status Dropdown -->
                    <div class="row">
                    
                   
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="companylistcust">ORDER DATE<span class="required"></span></label>
                            <input type="date" class="form-control custom-width" name="edit_order_date" id="edit_order_date" placeholder="Company Name">
                        </div>
                       
                        <div class="form-group col-md-3">
                            <label for="companylistcust"> DISPTACH DATE FROM PRODUCTION<span class="required"></span></label>
                            <input type="date" class="form-control custom-width" name="edit_disptach_date" id="edit_disptach_date" placeholder="Company Name">
                        </div>
                       
                        <div class="form-group col-md-3">
                            <label for="companylistcust">  TENTAITVE DISPATCH DATE<span class="required"></span></label>
                            <input type="date" class="form-control custom-width" name="edit_tentative_date" id="edit_tentative_date" placeholder="Company Name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="total_price">Total quantity<span class="required"></span></label>
                            <input type="text" class="form-control custom-width" name="edit_total_quantity" id="edit_total_quantity" placeholder="Enter Total Quantity">
                        </div>
                               
                                <div class="form-group col-md-3">
                                    <label for="price">Price<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_price" id="edit_price" placeholder="Enter Price">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="billing_address">Billing Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_Billing_address" id="edit_Billing_address" placeholder="Billing Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="delivery_address">Delivery Address<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_Delivery_address" id="edit_Delivery_address" placeholder="Delivery Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="notes">BOXES PACKED<span class="required"></span></label><br>   
                                    <input type="checkbox"  name="edit_box_packed" id="edit_box_packed" placeholder="ADD ORDER REMARKS">
                                </div>
                               
                                <div class="form-group col-md-6">
                                    <label for="order remark">ORDER REMARKS<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_order_remark" id="edit_order_remark" placeholder="ADD ORDER REMARKS">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="order remark">DISPATCH REMARKS<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="edit_dispatch_remark" id="edit_dispatch_remark" placeholder="ADD ORDER REMARKS">
                                </div>
                                <div class="row" id="editsampleOrderFields" style="display: none;">
                                    <div class="form-group col-md-6">
                                        <label for="transportname">COURIER/TRANSPORT NAME</label>
                                        <input type="text" class="form-control custom-width" name="edittransportname" id="edittransportname" placeholder="Enter Transport NAME">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="trackingdetails">TRACKING DETAILS</label>
                                        <input type="text" class="form-control custom-width" name="edittrackingdetails" id="edittrackingdetails" placeholder="Enter Tracking Details">
                                    </div>
                                </div>
                                

                        </div>
                        
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn bg-gradient-primary" id="updateOrder">Update changes</button>
            </div>
        </div>
    </div>
</div>

{{-- ------------------------status change----------------------- --}}

<div class="modal fade" id="statusChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Add Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        <input type="hidden" name="_token" id="_tokenOrder" value="{{ Session::token() }}">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Status<span class="required"></span></label>
                                <input type="text" class="form-control" name="status" id="status"
                                    placeholder="Status">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="user_firstname">Receipy Code<span class="required"></span></label>
                            <input type="text" class="form-control" name="receipy_code" id="receipy_code"
                                placeholder="Receipy Code">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Delivary Date<span class="required"></span></label>
                                <input type="date" class="form-control" name="delivary_date" id="delivary_date"
                                    placeholder="Delivary Date">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Time<span class="required"></span></label>
                                <input type="time" class="form-control" name="time" id="time"
                                    placeholder="Time">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Note<span class="required"></span></label>
                                <input type="text" class="form-control" name="note" id="note"
                                    placeholder="Note">
                            </div>
                        </div>
                       
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-gradient-primary " id="savesatatus">Save Status</button>
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


<script>
    $(document).ready(function(){
        // Add event listener to the ordertype dropdown
        $('#ordertype').change(function(){
            var selectedOrderType = $(this).val();
            if(selectedOrderType == 'sampleorder') {
                // If sample order is selected, show additional fields
                $('#sampleOrderFields').show();
            } else {
                // Otherwise, hide additional fields
                $('#sampleOrderFields').hide();
            }
        });
    });
</script>




   @endsection
