
@php
@endphp
@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>User Update</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Edit User</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
        <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">

                <ul>
                  @foreach ($errors->all() as $error)
                  <button type="button" class="btn btn-warning toastsDefaultWarning">
                    {{ $error }}
                  </button>
                  @endforeach
                </ul>
           
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Update User</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('update.User',[encrypt($user->id) ]) }}" method="post" enctype="multipart/form-data">              
                    @csrf
                    
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{$user->name}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="usernsme"placeholder="Enter username" name="username" value="{{$user->username}}" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Role</label>
                          <select class="form-control" name="role" required>
                            @if($user->id) 
                            <option value="{{$user->role_id}}" selected>{{$user->role_title}}
                            </option>
                            @endif
                            <option disabled>Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->role_title}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                              <option disabled>Select Status</option>
                              <option value="1" {{$user->status == 1 ? "selected" : ""}}>Active</option>
                              <option value="0" {{$user->status == 0 ? "selected" : ""}}>Inactive</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="name">Email</label>
                          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{$user->email}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="username">Phone</label>
                          <input type="text" class="form-control" id="phone"placeholder="Enter phone" name="phone" value="{{$user->phone}}" required>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="address_1">Address 1</label>
                          <input type="text" class="form-control" id="address_1" placeholder="Enter address 1" name="address_1" value="{{$user->address_1}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="address_2">Address 2</label>
                          <input type="text" class="form-control" id="address_2"placeholder="Enter address 2" name="address_2" value="{{$user->address_2}}" required>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="city">City</label>
                          <input type="text" class="form-control" id="city" placeholder="Enter city" name="city" value="{{$user->city}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="state">State</label>
                          <input type="text" class="form-control" id="state"placeholder="Enter state" name="state" value="{{$user->state}}" required>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="zip">Zip COde</label>
                          <input type="text" class="form-control" id="zip" placeholder="Enter zip " name="zip" value="{{$user->zip}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="country">Country</label>
                          <select class="form-control"  name="country" id="country">
                            {{-- if($user->id){
                              <option value="{{$user->country}}" selected>{{$user->countries}}</option>
                            } --}}
                            @foreach($country as $countries)
                            
                            <option value="{{$countries->sortname}}" {{$countries->sortname == $user->country ? "selected" : ""}}>{{$countries->countries}}</option>

                            @endforeach
                          </select>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="userimage">Upload Image</label>
                          <input type="file" class="form-control" name="userimage" id="userimage">
                        </div>
                        @if($user->logo != "")
			
			                  <div class="form-group col-md-12">
                          
                          <img src="{{asset('storage/app/public/images/usersimage/'.$user->logo)}}" style="height: 50px;">
                        </div>
			
			                  @endif
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <div class="col-4">
                        <input type="submit" class="btn btn-primary btn-block" value="Update">
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.card-primary -->
            </div>
            <!--/.col-md-12 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection