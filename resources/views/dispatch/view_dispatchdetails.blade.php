@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <a href="{{route('dispatch')}}" type="button" class="mx-3 " id="" data-bs-toggle="tooltip">
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
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder ">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Customer Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Customer Mobile NO.</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Customer City</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        company Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        address</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        state</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder ">
                                        country</th>
                                </tr>
                            </thead>
                            <tbody>


                                @if ($orderData)                        
                                    @foreach ($orderData as $key => $Data_val)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-s font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->custName}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->phoneno }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->city }}
                                                </p>
                                            </td>  
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->companylistcust }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->email }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->address }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->state }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $Data_val->order->customer->country }}
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">ID</th>
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

                                @if ($orderData)                        
                                    @foreach ($orderData as $key => $Data_val)
                                        @foreach ($Data_val->order->product as $key => $product)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-s font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-s font-weight-bold mb-0">{{ $product->prodName }}</p>
                                        </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $product->product_type }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $product->design_name }}
                                                </p>
                                            </td>         
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $product->color_name }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $product->quantity_in_soft }}
                                                </p>
                                            </td> 
                                            <td class="text-center">
                                                <p class="text-s font-weight-bold mb-0">
                                                    {{ $product->quantity_in_pieces }}
                                                </p>
                                            </td>           
                                        </tr>
                                        @endforeach
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



@endsection