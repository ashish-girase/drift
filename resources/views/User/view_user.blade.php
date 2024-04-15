@extends('layouts.user_type.auth')

@section('content')
<?php

	$userdata=Auth::user();
	$insertUser=$userdata->privilege['insertUser'];
    // $updateUser=$userdata->privilege['updateUser'];
    $deleteUser=$userdata->privilege['deleteUser'];
 ?>
<div>


    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Users</h5>
                        </div>
                        @if($insertUser== 1)
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0 createUserModalStore" type="button">+&nbsp; New User</a>
                        <!-- <a href="#" class="button-29 createUserModalStore" data-toggle="modal"  data-target="#"><span>Add</span></a> -->
                       @endif

                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Photo
                                    </th>
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
                                        Creation Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">1</p>
                                    </td>
                                    <td>
                                        <div>
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">Admin</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">admin@softui.com</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">Admin</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">16/06/18</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
                                        <span>
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </span>
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
<!--================================= create bank modal ============================= -->

<div class="container">
    <div class="modal fade" data-bs-backdrop="static"
            data-bs-keyboard="false" data-backdrop="static" id="addUserModal" data-bs-backdrop="static"
            data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom_modal_small">
            <div class="modal-content" style="margin-top:-5vh;">
                <div class="modal-header">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="button-21" onclick="closeModal(this)" modal-id="addUserModal">&times;</button>
                </div>
                <div class="modal-body" style="overflow-y: auto !important;">
                    <div class="row">
                        <div class=" row-sm">
                            <div class="">
                                <div class="">
                                    <div >
                                        <div class="table-responsive export-table">
                                            <form method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputFirstName4">First Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="inputFirstName4"
                                                            id="inputFirstName4" placeholder="First Name">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputLastName4">Last Name<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="inputLastName4"
                                                            id="inputLastName4" placeholder="Last Name">
                                                    </div>
                                                    <!-- <div class="form-group col-md-3">
                                                        <label for="inputUsername4">Username<span
                                                                class="required"></span></label>
                                                        <input type="text" class="form-control" name="inputUsername4"
                                                            id="inputUsername4" placeholder="Username">
                                                    </div> -->
                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4">Email<span
                                                                class="required"></span></label>
                                                        <input type="email" class="form-control email"
                                                            name="inputEmail4" id="inputEmail4" placeholder="Email">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputPassword4">Password<span
                                                                class="required"></span></label>
                                                        <input type="password" class="form-control"
                                                            name="inputPassword4" id="inputPassword4"
                                                            placeholder="Password">
                                                        <input type="checkbox"  class="show_Password_user" id="show_Password"
                                                           >
                                                        <label for="showPassword">Show Password</label>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAddress">Address<span   class="required"></span></label>
                                                        <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Enter Address">

                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputLocation">State</label>

                                                        <input list="addUserStateList" placeholder="Search here..." class="form-control" id="userStateAdd" onkeyup="SearchState(this.value,'addUserStateList')" autocomplete="off" placeholder="Search here...">
                                                        <datalist id="addUserStateList"></datalist>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>City</label>
                                                        <!-- <input type="text" class="form-control " id="userCityAdd" placeholder="----select-----"> -->
                                                        <input list="addUserCityList" placeholder="Enter City" class="form-control" id="userCityAdd"  autocomplete="off" >
                                                        <!-- onkeyup="SearchCity(this.value,'addUserCityList')"
                                                        <datalist id="addUserCityList"></datalist> -->
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputZip">Zip</label>
                                                        <input type="text" class="form-control" name="inputZip"   placeholder="Zip" id="inputZip">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputTelephone">Telephone</label>
                                                        <input type="text" class="form-control " name="inputTelephone"
                                                            id="inputTelephone" placeholder="(999) 999-9999"
                                                            data-mask="(999) 999-9999">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputExt">Ext</label>
                                                        <input type="number" class="form-control" name="inputExt"
                                                            placeholder="Ext" id="inputExt">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputTollFree">Toll Free</label>
                                                        <input type="tel" class="form-control" name="inputTollFree"
                                                            id="inputTollFree" placeholder="(999) 999-9999"
                                                            data-mask="(999) 999-9999">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputFax">Fax</label>
                                                        <input type="text" class="form-control" name="inputFax"
                                                            id="inputFax" placeholder="(999) 999-9999"
                                                            data-mask="(999) 999-9999">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                       <label  >Company Name   <span class="glyphicon glyphicon-plus-sign add_Company_Name_modal_form_btn "  data-toggle="modal"  style="cursor:pointer; color:blue !important;" ></span></label>
                                                        <!-- <div class="dropdown show">
                                                            <input list="addCompanyName" placeholder="Search here..."  class="form-control" id="inputCompanyName"  name="company_name" onkeyup="doSearch(this.value,'addCompanyName')" autocomplete="off">
                                                            <datalist id="addCompanyName"></datalist>
                                                        </div> -->
                                                        <div class="dropdown show">
                                                            <input list="add_Company_Name" placeholder="Search here..."  class="form-control" name="inputCompanyName" id="inputCompanyName_user_data" onkeyup="doSearch(this.value,'add_Company_Name')" autocomplete="off">
                                                            <datalist id="add_Company_Name"></datalist>
                                                        </div>

                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label  >Office <span class="glyphicon glyphicon-plus-sign add_office_model_form_btn"  style="color:blue !important" data-toggle="modal"  style="cursor:pointer;"></span></span></label>
                                                        <div class="dropdown show">
                                                            <input list="addOffice" placeholder="Search here..."  class="form-control" name="officeName" id="inputOffice" onkeyup="doSearch(this.value,'addOffice')" autocomplete="off">
                                                            <datalist id="addOffice"></datalist>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-row" style="margin-top:10px;">
                                                    <div class="form-group col-md-12">
                                                        <label>Insert</label>
                                                        <input type="checkbox" class="insertUser" name="insertUser"
                                                            checked>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Update</label>
                                                        <input type="checkbox" class="updateUser" name="updateUser"
                                                            checked>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Delete</label>
                                                        <input type="checkbox" name="deleteUser" class="deleteUser"
                                                            checked>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Import</label>
                                                        <input type="checkbox" name="importUser" class="importUser"
                                                            checked>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Export</label>
                                                        <input type="checkbox" name="exportUsers" class="exportUsers"
                                                            checked>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Show AllD ata</label>
                                                        <input type="checkbox" name="showAllData" class="showAllData"
                                                            checked>
                                                    </div>
                                                </div>


                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="button-29" data-dismiss="modal" id="usersave">Submit</button>
                    <button type="button" class="button-29" onclick="closeModal(this)" modal-id="addUserModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".createUserModalStore").click(function(){
            $('#addUserModal').modal("show");
        });
});

</script>
@endsection
