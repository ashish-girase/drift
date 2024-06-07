@extends('layouts.user_type.auth')

@section('content')
<div class="modal fade" id="edit_productModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                        <input type="hidden" name="_token" id="_tokeupdatenproduct" value="{{ Session::token() }}">
                        <input type="hidden" name="product_id" id="edit_prodid">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Product Name<span class="required"></span></label>
                                <input type="text" class="form-control" name="prodName" id="edit_prodName"
                                    placeholder="Product Name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="colorSelect">Color Name</label>
                                <input type="text" class="form-control" name="edit_colour_name" id="edit_colour_name"
                                placeholder="color name">
                                {{-- <select class="form-control" id="edit_colour_name">
                                    <option value="" selected>Select a color</option>
                                </select> --}}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Prodcut Type<span class="required"></span></label>
                                <input type="text" class="form-control" name="edit_product_type"
                                    id="edit_product_type" placeholder="Prodcut Type">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Product code<span class="required"></span></label>
                                <input type="text" class="form-control" name="prod_code" id="edit_prod_code"
                                    placeholder="Product code">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Product Quantity<span class="required"></span></label>
                                <input type="text" class="form-control" name="prod_qty" id="edit_prod_qty"
                                    placeholder="Product Quantity">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Product Thickness<span class="required"></span></label>
                                <input type="text" class="form-control" name="Thickness" id="edit_Thickness"
                                    placeholder="Product Thickness">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Product Width<span class="required"></span></label>
                                <input type="text" class="form-control" name="Width" id="edit_Width"
                                    placeholder="Product Width">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="user_firstname">Roll weight<span class="required"></span></label>
                                <input type="text" class="form-control" name="Roll_weight" id="edit_Roll_weight"
                                    placeholder="Roll weight">
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
