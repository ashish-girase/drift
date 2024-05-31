@extends('layouts.user_type.auth')

@section('content')
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
                                    <h5 class="mb-0">All Product</h5>
                                </div>

                                <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createProductModalStore" type="button">+&nbsp; New Product</a>
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
                                        @if($productData)

                                        @foreach($productData as $key => $cusData_val)
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
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->product->ColorName }}</p>
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
                            <div class="modal fade" id="addProdcutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Add Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="_tokenproduct" value="{{ Session::token() }}">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="prodName"
                                                            id="prodName" placeholder="Product Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    {{-- <div class="form-group col-md-12">
                                                        <label for="user_firstname">Color Name<span
                                                                class="required"></span></label>
                                                        <!-- <input type="text" class="form-control" name="company_name"
                                                            id="company_name" placeholder="Company Name"> -->
                                                            <input list="colorlistcust" placeholder="search here..." class="form-control" id="color_name" name="color_name" onkeyup="doSearch_sett(this.value,'colorlistcust')" autocomplete="off">
                                                            <datalist id="colorlistcust1">
                                                                <!-- Options will be populated here -->
                                                            </datalist>
                                                        </div> --}}

                                                        <div class="form-group col-md-12">
                                                            <label for="colorSelect">Color Name</label>
                                                           
                                                            <select  class="form-control" id="colorlistcust1">
                    
                                                                <option value="" selected>Select a color</option>
                                                            </select>
                                                        </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Prodcut Type<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="product_type"
                                                            id="product_type" placeholder="Prodcut Type">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product code<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="prod_code"
                                                            id="prod_code" placeholder="Product code">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Quantity<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="prod_qty"
                                                            id="prod_qty" placeholder="Product Quantity">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Thickness<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="Thickness"
                                                            id="Thickness" placeholder="Product Thickness">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Width<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="Width"
                                                            id="Width" placeholder="Product Width">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Roll weight<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="Roll_weight"
                                                            id="Roll_weight" placeholder="Roll weight">
                                                    </div>
                                                </div>
                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="saveproduct">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>



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
                                                        <label for="user_firstname">Color Name<span class="required"></span></label>
                                                        <input type="text" class="form-control" id="colour_id" list="colorlistcust1">
                                                        <select id="colorlistcust1"></select>
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
