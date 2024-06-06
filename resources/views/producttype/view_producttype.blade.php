@extends('layouts.user_type.auth')

@section('content')

<div >
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">All Product Type</h5>
                                </div>

                                <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createproducttypeModalStore" type="button">+&nbsp; New Product Type</a>
                                <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->


                            </div>
                        </div>
                        <hr/>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="producttypeTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">ID</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Product Type Name
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($producttypeData)

                                        @foreach($producttypeData as $key => $ptData_val)
                                      
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $ptData_val->producttype->producttype_name }}</p>
                                            </td>

                                            <td class="text-center">
                                                <a href="#" class="mx-3 edit-producttype"  data-user-ids="{{ $ptData_val->producttype->_id }}" data-user-master_id="{{ $ptData_val['_id'] }}" data-bs-toggle="tooltip">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                        
                                                </a>
                                                <a href="#" class="mx-3 delete-producttype" data-user-ids="{{ $ptData_val->producttype->_id }}" data-user-master_id="{{ $ptData_val['_id'] }}" data-bs-toggle="tooltip">
                                                <!-- <a href="#" class="mx-3 delete-company" data-user-id="{{ $ptData_val->producttype->_id }}" data-bs-toggle="tooltip"> -->
                
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
                        <div class="modal fade" id="addproducttypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Add Product Type</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="_token" id="_tokenproducttype" value="{{ csrf_token() }}">

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Product Type Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="producttype_name"
                                                            id="producttype_name" placeholder="Product Type Name">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn bg-gradient-primary " id="saveproducttype">Save changes</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Edit Design -->
                        <div class="modal fade" id="edit_producttypeModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <input type="hidden" name="_token" id="_tokeupdatenproducttype" value="{{Session::token()}}">
                                                <input type="hidden" name="producttype_id"  id="producttype_editid">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="design_name">Product Type Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="producttype_editname"
                                                            id="producttype_editname" placeholder="Product Type Name">
                                                    </div>

                                                </div>
                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="updateproducttype">Update changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>


   @endsection
   {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
