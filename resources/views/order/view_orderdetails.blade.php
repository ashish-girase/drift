@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <a href="{{route('order')}}" type="button" class="mx-3 " id="" data-bs-toggle="tooltip">
                                <button class=" btn btn-sm btn-outline btn-danger  ">Back</button>
                                </a>
                            <h5 class="mb-0">Customer Details</h5>
                        </div>
                        <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->


                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    {{-- <th class="text-uppercase text-secondary text-s font-weight-bolder ">ID</th> --}}
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder ">Order ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Customer Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Customer Refrence Number</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Customer Mobile NO.</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Customer City</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        state</th>
                                   
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $mergedData = array_merge($orderData, $proorderData, $partialdispatchData,$cancelOrderData);
                                    // dd($mergedData);
                                @endphp

                                

                                @if ($mergedData)                        
                                    @foreach ($mergedData as $Data_val)
  
                                        <tr>
                                            {{-- <td class="ps-4">
                                                <p class="text-s font-weight-bold mb-0">{{ isset($Data_val->order) && !empty($Data_val->order) ? $key :"" }}</p>
                                            </td> --}}
                                            <td class="ps-4">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ isset($Data_val->order->neworderid) ? $Data_val->order->neworderid:""}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ isset($Data_val->order->customer->custName) ? $Data_val->order->customer->custName:""}}</p>
                                            </td>

                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ isset($Data_val->order->customer->customer_refrence_number) ? $Data_val->order->customer->customer_refrence_number:""}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{isset($Data_val->order->customer->phoneno) ? $Data_val->order->customer->phoneno:""}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{isset($Data_val->order->customer->city) ? $Data_val->order->customer->city:""}}
                                                </p>
                                            </td>  
                                         
                                           
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{isset($Data_val->order->customer->state) ? $Data_val->order->customer->state:""}}
                                                </p>
                                            </td> 
                                           

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">
                                            <center>Record Not Found</center>
                                        </td>
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


<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->
                        <div>
                            <h5 class="mb-0">All Product Details</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">Product ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Product Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Product Type</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Design Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Color Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        QUANTITY IN SQFT</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        QUANTITY IN PIECES</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @php
                                    $mergedData = array_merge($orderData, $proorderData, $partialdispatchData,$cancelOrderData);
                                @endphp
                                @if ($mergedData)                        
                                    @foreach ($mergedData as $key => $Data_val)
                                    @if (is_object($Data_val) && isset($Data_val->order))
                                        @foreach ($Data_val->order->product as $key => $productsNew)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-s font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-s font-weight-bold mb-0">{{ $productsNew->prodName }}</p>
                                        </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $productsNew->product_type }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $productsNew->design_name }}
                                                </p>
                                            </td>         
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $productsNew->color_name }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $productsNew->quantity_in_soft }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $productsNew->quantity_in_pieces }}
                                                </p>
                                            </td>           
                                        </tr>
                                        @endforeach
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">
                                            <center>Record Not Found</center>
                                        </td>
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

@if ($noteshData && $status === "partialdispatch")  
<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->
                        <div>
                            <h5 class="mb-0">Other Details</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">Note ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Vehicle Number</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Vehicle Type</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Dispatcher Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Receiver Name</th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    $mergedData = array_merge($orderData, $proorderData, $partialdispatchData);
                                @endphp --}}
                                {{-- @if ($noteshData)                         --}}
                                    @foreach ($noteshData as $key => $Data_val)
                                   
                                    
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-s font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-s font-weight-bold mb-0">{{ isset($Data_val->order->vehicle_number)?$Data_val->order->vehicle_number:'N/A' }}</p>
                                        </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ isset($Data_val->order->vehicle_type)?$Data_val->order->vehicle_type:'N/A' }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->dispatcher_name }}
                                                </p>
                                            </td>         
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->receiver_name }}
                                                </p>
                                            </td> 
                                                  
                                        </tr>
                                    
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">
                                            <center>Record Not Found</center>
                                        </td>
                                    </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif



@endsection