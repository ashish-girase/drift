@extends('layouts.user_type.auth')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
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
                    <table class="table align-items-center mb-0" id="ordertable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder">ID</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Customer Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Product Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Product Quantity</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">price_type</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">notes</th>
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
    @if(!empty($order->custName))
            <p class="text-xs font-weight-bold mb-0">{{ $order->custName }}</p>
    @endif     
</td>
    <td class="text-center">
        <!-- <p class="text-xs font-weight-bold mb-0">{{ $order->status }}</p>-->
        <form method="POST" action="{{ route('orders.updateStatus') }}" >
    @csrf
    <!-- Hidden input fields for each data attribute -->
    <input type="hidden" name="id" value="{{ $order->_id }}">
    <input type="hidden" name="oldstatus" value="{{ $order->status }}">
    <input type="hidden" name="custName" value="{{ $order->custName }}">
    <!-- Add more hidden input fields for other data attributes -->

    <select class="form-control custom-width" name="newstatus" onchange="submitForm(this)">
        <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>New</option>
        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="dispatch" {{ $order->status == 'dispatch' ? 'selected' : '' }}>Dispatch</option>
        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</form>
<script>
    function submitForm(selectElement) {
        // Get the form element containing the select dropdown
        var form = selectElement.form;

        // Submit the form
        form.submit();
    }
</script>

    </td>

<td class="text-center">
@if(!empty($order->prodName))
        <p class="text-xs font-weight-bold mb-0">{{ $order->prodName }}</p>
@endif
</td>
<td class="text-center">
        @if(!empty($order->prod_qty  ))    
        <p class="text-xs font-weight-bold mb-0">{{ $order->prod_qty }}</p>
        @endif
</td>
<td class="text-center">
        @if(!empty( $order->price_type))    
        <p class="text-xs font-weight-bold mb-0">{{ $order->price_type }}</p>
        @endif
</td>
<td class="text-center">
        @if(!empty($order->notes ))    
        <p class="text-xs font-weight-bold mb-0">{{ $order->notes }}</p>
        @endif
</td>
<td class="text-center">
        <!--EDIT BUTTON-->
        <a href="#" type="button" class="mx-3 edit-order" id="edit-order"  data-user-ids="{{ $order->_id}}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip">
            <i class="fas fa-user-edit text-secondary"></i>
        </a>
        <!--DELETE BUTTON-->
        <a href="#" class="mx-3 delete-order" data-user-ids="{{ $order->_id}}" data-user-master_id="{{ $order->_id}}" data-bs-toggle="tooltip">
       
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
                            <div class="row">
                            <div class="form-group col-md-3">
                                <label for="custName">Customer Name<span class="required"></span></label>
                                
                                <input type="text" id="customerInput" list="browsers" placeholder="e.g. datalist">
                                <datalist id="customer_list">
                                    {{-- @foreach($customers as $customer)
                                        <option value="{{ $customer->_id  }}">{{ $customer->custName }}</option>
                                        @endforeach --}}
                                </datalist>
                            </div>
                                {{-- <div class="form-group col-md-3">
                                    <label for="custName">Customer Name<span class="required"></span></label>
                                    <input type="text" class="form-control custom-width" name="custName" id="custName" placeholder="Customer Name">
                                </div> --}}
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
                                    <label  for="prodName">Product Name<span class="required"></span></label>
                                    <input class="form-control custom-width" list="browsers" id="products" name="products" placeholder="Select a product">
                                    <datalist id="products">
                                        
                                    </datalist>
                                    {{-- <input type="text" class="form-control custom-width" name="prodName" id="prodName" placeholder="Product Name" > --}}
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




   @endsection
