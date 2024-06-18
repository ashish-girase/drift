@extends('layouts.user_type.auth')

@section('content')
<div>


    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <a href="{{route('product')}}" type="button" class="mx-3 " id="" data-bs-toggle="tooltip">
                                <button class=" btn btn-sm btn-outline btn-danger  ">Back</button>
                                </a>
                            <h5 class="mb-0">All Product</h5>
                        </div>
                        <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->


                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                        Product Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                        Product Type</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                        Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($show1)
                                    @foreach ($show1 as $key => $cusData_val)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $cusData_val->product->prodName }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $cusData_val->product->product_type }}</p>
                                            </td>          
                                           
                                            <td class="text-center">
                                                   <!--Add BUTTON-->
                                                <a href="#" type="button" class="btn bg-gradient-primary btn-sm mb-0 createDesignModalStore" id="createDesignModalStore"
                                                        data-user-ids="{{ $cusData_val->product->_id}}" 
                                                        data-user-master_id="{{ $cusData_val['_id'] }}"  
                                                        type="button">+&nbsp; Add Design
                                                </a>
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

                        <div>
                            <h5 class="mb-0">All Design</h5>
                        </div>

<table class="table align-items-center mb-0">

    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">ID</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                Design Name</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                Dimensions</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                Thickness</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                Weight/Pcs</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                Weight/Sqft</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                PCS/SQFT</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                SQFT/PCS</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                Action </th>
        </tr>
    </thead>


<tbody>
    
 @if ($designData)
    @foreach ($designData as $key => $cusData_vald)
                 
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                   
                                {{ $cusData_vald->product->designname->design_name }}
                            </p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                            
                                {{ $cusData_vald->product->designname->dimensions }}
                            </p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                             
                                {{ $cusData_vald->product->designname->thickness }}
                            </p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                             
                                {{ $cusData_vald->product->designname->weight_pcs }}
                            </p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                              
                                 {{ $cusData_vald->product->designname->weight_sqft }}
                            </p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                           
                                  {{ $cusData_vald->product->designname->pcs_sqft }}
                            </p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">
                               
                                 {{ $cusData_vald->product->designname->sqft_pcs }}
                            </p>
                        </td>
                        <td class="text-center">
                            <!-- EDIT BUTTON -->
                        
                            <a href="#" type="button" class="mx-3 edit-product-design" id="#" 
                                data-user-ids="{{ $cusData_vald->product->designname->_id }}"
                                data-user-master_id="{{ $cusData_vald['_id'] }}"
                                data-bs-toggle="tooltip">
                                <i class="fas fa-user-edit text-secondary"></i>
                            </a>
                            
                            <!-- DELETE BUTTON -->
                            <a href="#" type="button" class="mx-3 delete_product_design" data-user-ids="{{ $cusData_vald->product->designname->_id }}"
                                data-user-master_id="{{ $cusData_vald->product->_id }}"  id="delete_product_design" data-bs-toggle="tooltip">

        
                    
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                </span>
                            </a>
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

<!--================================= create bank modal ============================= -->
                            <!-- Button trigger modal -->


                            <!-- Modal -->
                            <div class="modal fade" id="addDesignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Add Design</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <form method="post">
                                                    @csrf
                                                    <input type="hidden" name="_token" id="_tokendesign" value="{{Session::token()}}">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            
                                                            <input type="hidden" name="prod_id" id="prod_id" value="{{$cusData_val->product->_id}}">
                                                            <input type="hidden" name="master_id" id="master_id" value="{{$cusData_val->_id}}">
                                                            <label for="">Design Name<span
                                                                    class="required"></span></label>
                                                            <input type="text" class="form-control" name="design_name"
                                                                id="design_name" placeholder="Design Name">

                                                            <label for="">Dimensions<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="dimensions"
                                                                id="dimensions" placeholder="Dimensions">

                                                            <label for="user_firstname">Thickness<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="thickness"
                                                                id="thickness" placeholder="Thickness">

                                                            <label for="user_firstname">Weight/Pcs<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="weight_pcs"
                                                                id="weight_pcs" placeholder="Weight/Pcs">

                                                            <label for="user_firstname">Weight/Sqft<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="weight_sqft"
                                                                id="weight_sqft" placeholder="Weight/Sqft">

                                                            <label for="user_firstname">PCS/SQFT<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="pcs_sqft"
                                                                id="pcs_sqft" placeholder="PCS/SQFT">

                                                            <label for="user_firstname">SQFT/PCS<span
                                                                    class="required"></span></label>
                                                            <input type="text" class="form-control" name="sqft_pcs"
                                                                id="sqft_pcs" placeholder="SQFT/PCS ">
                                                        </div>
                                                    </div>
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn bg-gradient-primary " id="savedesign">Save changes</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>


                                
                            <!--Edit Modal -->
                            <div class="modal fade" id="EditDesignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Edit Design</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <form method="post">
                                                    @csrf
                                                    <input type="hidden" name="_token" id="_tokeupdatenproductdesign" value="{{Session::token()}}">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <input type="hidden" name="edit_prodid" id="edit_prodid" value="{{$cusData_val->product->_id}}">
                                                            <input type="hidden" name="master_id" id="master_id" value="{{$cusData_val->_id}}">
                                                            <input type="hidden" name="edit_disdid" id="edit_disdid" >
                                                            <label for="user_firstname">Design Name<span
                                                                    class="required"></span></label>
                                                            <input type="text" class="form-control" name="edit_design_name"
                                                                id="edit_design_name" placeholder="Design Name">

                                                            <label for="user_firstname">Dimensions<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="edit_dimensions"
                                                                id="edit_dimensions" placeholder="Dimensions">

                                                            <label for="user_firstname">Thickness<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="edit_thickness"
                                                                id="edit_thickness" placeholder="Thickness">

                                                            <label for="user_firstname">Weight/Pcs<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="edit_weight_pcs"
                                                                id="edit_weight_pcs" placeholder="Weight/Pcs">

                                                            <label for="user_firstname">Weight/Sqft<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="edit_weight_sqft"
                                                                id="edit_weight_sqft" placeholder="Weight/Sqft">

                                                            <label for="user_firstname">PCS/SQFT<span
                                                                class="required"></span></label>
                                                            <input type="text" class="form-control" name="edit_pcs_sqft"
                                                                id="edit_pcs_sqft" placeholder="PCS/SQFT">

                                                            <label for="user_firstname">SQFT/PCS<span
                                                                    class="required"></span></label>
                                                            <input type="text" class="form-control" name="edit_sqft_pcs"
                                                                id="edit_sqft_pcs" placeholder="SQFT/PCS ">
                                                        </div>
                                                    </div>
                                                    </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn bg-gradient-primary " id="updatedesign">Update changes</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>



@endsection
