@extends('layouts.user_type.auth')

@section('content')

<div>


            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">All Company</h5>
                                </div>

                                <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createCompanyModalStore" type="button">+&nbsp; New Company</a>
                                <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->


                            </div>
                        </div>
                        <hr/>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="companyTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">ID</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Company Name
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Company Code
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Company Address
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              City
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Zip Code
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              State
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Country
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Tax No./Gst No.
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Phone No.
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Email
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">
                                              Website
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($companyData)
                                    @foreach($companyData as $key => $comData_val)
                                        <tr>
                                                <td class="ps-4">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                                </td>
                                                <td class="text-center">
                                                   
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->company_name}}</p>
                                                   
                                                </td>
                                                <td class="text-center">
                                                     @if(!empty($comData_val->company->ccode))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->ccode }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->caddress))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->caddress }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->city))
                                                    <p class="text-xs font-weight-bold mb-0">{{$comData_val->company->city }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->zipcode))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->zipcode }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->state))
                                                    <p class="text-xs font-weight-bold mb-0">{{$comData_val->company->state }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->country))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->country }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->taxgstno))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->taxgstno }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->phoneno))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->phoneno }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->email))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->email}}</p>
                                                @endif
                                                </td>
                                                <td class="text-center">
                                                @if(!empty($comData_val->company->website))
                                                    <p class="text-xs font-weight-bold mb-0">{{ $comData_val->company->website }}</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                               
                                                    <a href="#" class="mx-3 edit-company"  data-user-ids="{{ $comData_val->company->_id }}" data-user-master_id="{{ $comData_val['_id'] }}" data-bs-toggle="tooltip">
                                                        <i class="fas fa-user-edit text-secondary"></i>
                                                    
                                                    </a>
                                                 
                                                    <a href="#" class="mx-3 delete-company" data-user-ids="{{ $comData_val->company->_id}}" data-user-master_id="{{ $comData_val['_id'] }}" data-bs-toggle="tooltip">
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
                            <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Add Company</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="_tokencompany" value="{{Session::token()}}">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Company Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_name"
                                                            id="company_name" placeholder="Enter Company Name">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Company Code<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="ccode"
                                                            id="ccode" placeholder="Enter Company code">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Company Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="caddress"
                                                            id="caddress" placeholder="Enter Company address">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">City<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="city"
                                                            id="city" placeholder="Enter City">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Zip Code<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="zipcode"
                                                            id="zipcode" placeholder="Enter Zip Code">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">State<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="state"
                                                            id="state" placeholder="State">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Country<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="country"
                                                            id="country" placeholder="country">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Tax/Gst Number<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="taxgstno"
                                                            id="taxgstno" placeholder="Tax no./Gst no.">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Phone number<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="phoneno"
                                                            id="phoneno" placeholder="phone no.">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Email<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="email"
                                                            id="email" placeholder="Enter Email">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">Website<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="website"
                                                            id="website" placeholder="website">
                                                    </div>
                                                    
                                                </div>
                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="savecompany">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>



                        <!-- Edit user -->
                        <div class="modal fade" id="edit_companyModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Edit company</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="_tokeupdatencompany" value="{{Session::token()}}">
                                                <input type="hidden" name="company_id"  id="company_editid">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Company Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editname"
                                                            id="company_editname" placeholder="Company Name">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Company Code<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editccode"
                                                            id="company_editccode" placeholder="Company Code">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Company Address<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editcaddress"
                                                            id="company_editcaddress" placeholder="Company Address">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">City<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editcity"
                                                            id="company_editcity" placeholder="City">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">ZipCode<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editzipcode"
                                                            id="company_editzipcode" placeholder="Enter ZipCode">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">State<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editstate"
                                                            id="company_editstate" placeholder="State">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Country<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editcountry"
                                                            id="company_editcountry" placeholder="Country">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Tax/Gst No<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_edittaxgstno"
                                                            id="company_edittaxgstno" placeholder=" Enter Tax/Gst No.">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Phone Number<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editphoneno"
                                                            id="company_editphoneno" placeholder="Phone number">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Email<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editemail"
                                                            id="company_editemail" placeholder="Company Email">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="company_name">Website<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="company_editwebsite"
                                                            id="company_editwebsite" placeholder="Company website">
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
