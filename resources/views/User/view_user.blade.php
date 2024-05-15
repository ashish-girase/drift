@extends('layouts.user_type.auth')

@section('content')

<div>


            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 mx-4">
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">All Users</h5>
                                </div>

                                <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createUserModalStore" type="button">+&nbsp; New User</a>
                                <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->


                            </div>
                        </div>
                        <hr/>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="userTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                role
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Contact No
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($userData)
                                        @foreach($userData as $key => $userData_val)

                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{$userData_val->userFirstName}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{$userData_val->userEmail}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{$userData_val->department}}</p>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{$userData_val->userTelephone}}</span>
                                            </td>
                                            <td class="text-center">

                                                <a href="#" class="mx-3 edit-user" data-user-id="{{ $userData_val->id }}" data-bs-toggle="tooltip" >
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                <a href="#" class="mx-3 delete-user" data-user-id="{{ $userData_val->id }}" data-bs-toggle="tooltip" >
                                                <span>
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </span>
                                                </a>
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
<!--================================= create bank modal ============================= -->
                            <!-- Button trigger modal -->


                            <!-- Modal -->
                            <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel"> Add User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <form method="post">
                                              
                                                <input type="hidden" name="_token" id="_tokenuser" value="{{route('userenter')}}">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">First Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="user_firstname"
                                                            id="user_firstname" placeholder="First Name">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_lastname">Last Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="user_lastname"
                                                            id="user_lastname" placeholder="Last Name">
                                                    </div>
                                                    <!-- <div class="form-group col-md-3">
                                                        <label for="inputUsername4">Username<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="inputUsername4"
                                                            id="inputUsername4" placeholder="Username">
                                                    </div> -->
                                                    <div class="form-group col-md-12">
                                                        <label for="user_email">Email<span
                                                                class="required"></span></label>
                                                        <input type="email" class="form-control email"
                                                            name="user_email" id="user_email" placeholder="Email">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_password">Password<span
                                                                class="required"></span></label>
                                                        <input type="password" class="form-control"
                                                            name="user_password" id="user_password"
                                                            placeholder="Password">
                                                        <input type="checkbox"  class="show_Password_user" id="show_Password"
                                                           >
                                                        <!-- <label for="showPassword">Show Password</label> -->
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAddress">Type Of Work<span   class="required"></span></label>
                                                        <!-- <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Enter Address"> -->
                                                        <select class="form-control" id="user_type" class="user_type">
                                                            <option name="on_site">On site </option>
                                                            <option name="remote">Remote </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_address">Address<span   class="required"></span></label>
                                                        <input type="text" class="form-control" name="user_address" id="user_address" placeholder="Enter Address">

                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputLocation">User Code</label>
                                                        <input type="text" class="form-control" name="user_code" id="user_code" placeholder="Enter User Code">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Date Of Birth</label>
                                                        <input type="date" class="form-control" name="user_dob" id="user_dob" >
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputZip">Phone Number</label>
                                                        <input type="text" class="form-control" name="user_phoneno"   placeholder="Enter Phone Number" id="user_phoneno">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAddress">Department<span   class="required"></span></label>
                                                        <!-- <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Enter Address"> -->
                                                        <select class="form-control" name="user_department" id="user_department">
                                                            <option value="sales">Sales</option>
                                                            <option value="production">Production </option>
                                                            <option value="account">Account </option>
                                                            <option value="qc">QC </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputZip">Note</label>
                                                        <textarea class="form-control" name="user_note"></textarea>
                                                    </div>
                                                </div>
                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="saveuser">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>



                        <!-- Edit user -->
                        <div class="modal fade" id="edit_userModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <input type="hidden" name="_token" id="_tokeupdatenuser" value="{{Session::token()}}">
                                                <input type="hidden" name="user_id"  id="user_editid">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="user_firstname">First Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="user_firstname"
                                                            id="user_editfirstname" placeholder="First Name">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_lastname">Last Name<span
                                                                class="required"></span></label>
                                                        <input type="email" class="form-control" name="user_lastname"
                                                            id="user_editlastname" placeholder="Last Name">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_email">Email<span
                                                                class="required"></span></label>
                                                        <input type="email" class="form-control email"
                                                            name="user_email" id="user_editemail" placeholder="Email">
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="inputAddress">Type Of Work<span   class="required"></span></label>
                                                        <!-- <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Enter Address"> -->
                                                        <select class="form-control" id="user_edittype" class="user_type">
                                                            <option name="on_site">On site </option>
                                                            <option name="remote">Remote </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="user_address">Address<span   class="required"></span></label>
                                                        <input type="text" class="form-control" name="user_address" id="user_editaddress" placeholder="Enter Address">

                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputLocation">User Code</label>
                                                        <input type="text" class="form-control" name="user_code" id="user_editcode" placeholder="Enter User Code">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Date Of Birth</label>
                                                        <input type="date" class="form-control" name="user_dob" id="user_editdob" >
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputZip">Phone Number</label>
                                                        <input type="text" class="form-control" name="user_phoneno"   placeholder="Enter Phone Number" id="user_editphoneno">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAddress">Department<span   class="required"></span></label>
                                                        <!-- <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Enter Address"> -->
                                                        <select class="form-control" name="user_department" id="user_editdepartment">
                                                            <option value="sales">Sales</option>
                                                            <option value="production">Production </option>
                                                            <option value="account">Account </option>
                                                            <option value="qc">QC </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputZip">Note</label>
                                                        <textarea class="form-control" name="user_note" id="user_editnote"></textarea>
                                                    </div>
                                                </div>
                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn bg-gradient-primary " id="updateuser">Update changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>



   @endsection
