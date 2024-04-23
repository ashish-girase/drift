@extends('layouts.user_type.auth')

@section('content')

<div>


            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">All Customer</h5>
                                </div>

                                <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createCustomerModalStore" type="button">+&nbsp; New Customer</a>
                                <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->


                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">ID</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Customer Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Company Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Factory Code</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Email</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Billing Address</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Delivery Address</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($customer_data)

                                        @foreach($customer_data as $key => $cusData_val)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->customer->custName }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->customer->companyName }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->customer->factoryCode }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->customer->custEmail }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->customer->cust_Billing_address }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $cusData_val->customer->cust_Delivery_address }}</p>
                                            </td>

                                            <td class="text-center">
                                                <a href="#" class="mx-3 edit-customer"  data-user-ids="{{ $cusData_val->customer->_id }}" data-user-master_id="{{ $cusData_val['_id'] }}" data-bs-toggle="tooltip">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                <a href="#" class="mx-3 delete-customer" data-user-ids="{{ $cusData_val->customer->_id }}" data-user-master_id="{{ $cusData_val['_id'] }}" data-bs-toggle="tooltip">
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
                            <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Add Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="_tokencustomer" value="{{Session::token()}}">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custName"
                                                            id="custName" placeholder="Customer Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Company Name<span
                                                                class="required"></span></label>
                                                        <!-- <input type="text" class="form-control" name="company_name"
                                                            id="company_name" placeholder="Company Name"> -->
                                            <input list="driversett" placeholder="search here..." class="form-control" id="driver_sett"
                                            name="drivername_sett" onkeyup="doSearch_sett(this.value,'companylistcust')"  autocomplete="off">
                                            <datalist id="companylistcust">
                                            </datalist>
                                                        </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Factoring Code<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="factoryCode"
                                                            id="factoryCode" placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">GST Detail<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="GstDetails"
                                                            id="GstDetails" placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Email<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custEmail"
                                                            id="custEmail" placeholder="Customer Email">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custAddress"
                                                            id="custAddress" placeholder="Customer Address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Billing Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="cust_Billing_address"
                                                            id="cust_Billing_address" placeholder="Billing Address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Delivery Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="cust_Delivery_address"
                                                            id="cust_Delivery_address" placeholder="Delivery Address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer City<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custCity"
                                                            id="custCity" placeholder="Customer City">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer State<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custState"
                                                            id="custState" placeholder="Customer State">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Country<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custCountry"
                                                            id="custCountry" placeholder="Customer Country">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Zip<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custZip"
                                                            id="custZip" placeholder="Customer Zip">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Phone number<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custTelephone"
                                                            id="custTelephone" placeholder="Customer Phone number">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Note<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="briefInformation"
                                                            id="briefInformation" placeholder="Note">
                                                    </div>
                                                </div>

                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="savecustomer">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>



                        <!-- Edit user -->
                        <div class="modal fade" id="edit_companyModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="_tokeupdatencustomer" value="{{Session::token()}}">
                                                <input type="text" name="customer_id"  id="edit_customer_id">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custName"
                                                            id="edit_custName" placeholder="Customer Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Company Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_name"
                                                            id="edit_company_name" placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Factoring Code<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="factoryCode"
                                                            id="edit_factoryCode" placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">GST Detail<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="GstDetails"
                                                            id="edit_GstDetails" placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Email<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custEmail"
                                                            id="edit_custEmail" placeholder="Customer Email">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custAddress"
                                                            id="edit_custAddress" placeholder="Customer Address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Billing Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="cust_Billing_address"
                                                            id="edit_cust_Billing_address" placeholder="Billing Address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Delivery Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="cust_Delivery_address"
                                                            id="edit_cust_Delivery_address" placeholder="Delivery Address">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer City<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custCity"
                                                            id="edit_custCity" placeholder="Customer City">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer State<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custState"
                                                            id="edit_custState" placeholder="Customer State">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Country<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custCountry"
                                                            id="edit_custCountry" placeholder="Customer Country">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Zip<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custZip"
                                                            id="edit_custZip" placeholder="Customer Zip">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Customer Phone number<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="custTelephone"
                                                            id="edit_custTelephone" placeholder="Customer Phone number">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Note<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="briefInformation"
                                                            id="edit_briefInformation" placeholder="Note">
                                                    </div>
                                                </div>

                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="updatecompany">Update changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>



   @endsection
