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
                        <h5 class="mb-0">All Disatched Orders</h5>
                    </div>
                    {{-- <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createOrderModalStore" type="button">+&nbsp; New Order</a> --}}
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="ordertable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Order ID</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Customer Name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Order Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Tentaitve Dispatch Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Actual Dispatch Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Dispatch Remarks</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action</th>
                           </tr>

                        </thead>
                        <tbody>
                                                 
 @if($order_data )
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
            <form method="POST">
        @csrf
        <!-- Hidden input fields for each data attribute -->
        <input type="hidden" class="order-id" name="orderid" id="orderid" value="{{ $order->order->_id }}">
        <input type="hidden" name="oldstatus" id="oldstatus" value="{{ $order->order->status }}">
        <input type="hidden" name="custName" value="{{ $order->order->customer->custName }}">
        <!-- Add more hidden input fields for other data attributes -->

        {{-- <select class="form-control custom-width" name="newstatus"  onchange="openModalf(this, '{{ $order->order->_id }}', '{{ $order->order->status }}')"> --}}
            <select class="form-control custom-width" name="newstatus" >
            {{-- <option value="new" {{ $order->order->status == 'new' ? 'selected' : '' }}>New</option>
            <option value="processing" {{ $order->order->status == 'processing' ? 'selected' : '' }}>Processing</option> --}}
            <option value="dispatch" {{ $order->order->status == 'dispatch' ? 'selected' : '' }}>Dispatch</option>
            {{-- <option value="completed" {{ $order->order->status == 'completed' ? 'selected' : '' }}>Completed</option> --}}
            {{-- <option value="cancelled" {{ $order->order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option> --}}
        </select>

        
    </form>

        </td>


        <td class="text-center">
                @if(!empty($order->order->order_date  ))    
                <p class="text-xs font-weight-bold mb-0">{{ date('d/m/Y', strtotime($order->order->order_date)) }}</p>
                @endif
        </td>
        <td class="text-center">
                @if(!empty( $order->order->tentative_date))    
                <p class="text-xs font-weight-bold mb-0">{{ date('d/m/Y', strtotime($order->order->tentative_date)) }}</p>
                @endif
        </td>
        <td class="text-center">
            @if(!empty( $order->order->actual_dispatch_date))    
            <p class="text-xs font-weight-bold mb-0">{{ $order->order->actual_dispatch_date }}</p>
            @endif
        </td>
        <td class="text-center">
                @if(!empty($order->order->order_remark ))    
                <p class="text-xs font-weight-bold mb-0">{{ $order->order->order_remark }}</p>
                @endif
        </td>
        <td class="text-center">
                <!--VIEW BUTTON-->
            <a href="#" type="button" class="btn bg-gradient-primary btn-sm mb-0 view-dispatched-order" id="view-order"  data-user-ids="{{ $order->order->_id}}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip" type="button">
                view
            </a>
                <!--EDIT BUTTON-->
                {{-- <a href="#" type="button" class="mx-3 edit-order" id=""  data-user-ids="{{ $order->order->_id}}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip">
                    <i class="fas fa-user-edit text-secondary"></i>
                </a>
                <!--DELETE BUTTON-->
                <a href="#" class="mx-3 " data-user-ids="{{ $order->order->_id}}" data-user-master_id="{{ $order['_id'] }}" data-bs-toggle="tooltip">
                    <span>
                        <i class="cursor-pointer fas fa-trash text-secondary"></i>
                    </span>
                </a> --}}
        
        </td>
    </tr>


@endforeach
@endif




                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection