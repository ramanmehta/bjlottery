{{-- @php
dd($user);
@endphp --}}
@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Update Notifications</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Update Notifications</li>
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
                    <h3 class="card-title">Edit Notification</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('update.Notifications',[encrypt($notification->id)])}}" method="post">
                    @csrf
                    
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="user_id">User ID</label>
                          <input type="text" class="form-control" id="user_id" placeholder="Enter user" name="user_id" value="{{$notification->user_id}}" required>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="title">Notification Title</label>
                          <input type="text" class="form-control" id="title" placeholder="Enter notification title" name="title" value="{{$notification->title}}" required>
                        </div>
                        
                      </div>
                      {{-- text editor --}}
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_description">Notification Description</label>
                        
                          
                          <textarea id="game_description" name="description">
                            {{$notification->description}}
                          </textarea>
                        
                        </div>
                      </div>
                      
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="sent_at">Sent At</label>
                          <input type="datetime-local" class="form-control" name="sent_at" id="sent_at" value="{{$notification->sent_at}}">
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                              @if($notification->id) 
                              <option value="{{$notification->status}}" selected>
                                @if ($notification->status == 1)
                                    Active
                                @else
                                  Inactive
                                @endif
                              </option>
                              @endif
                              <option disabled>Select Status</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
                        </div>
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