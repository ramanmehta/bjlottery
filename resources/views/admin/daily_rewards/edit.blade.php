@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Daily Reward Update</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Edit Daily Reward</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->

                <ul>
                  @foreach ($errors->all() as $error)
                  <button type="button" class="btn btn-warning toastsDefaultWarning">
                    {{ $error }}
                  </button>
                  @endforeach
                </ul>
           
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Update Daily Reward</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('update.DailyReward',[encrypt($dailyReward->id) ]) }}" method="post">              
                  @csrf
                  
                  {{-- <input type="hidden" name="id" value="{{encrypt($role->id)}}"> --}}
                  <div class="card-body">
                    <div class="form-group">
                      <label for="reward_types">Daily Reward</label>
                      <input type="text" class="form-control" id="reward_types" placeholder="Enter Daily Reward" name="reward_types" value="{{$dailyReward->reward_types}}" required>
                    </div>
                    <div class="col-sm-6">
                    <div class="form-group">
                      <label for="reward_points">Reward Points</label>
                      <input type="number" class="form-control" id="reward_points" placeholder="Enter Reward Points" name="reward_points" value="{{$dailyReward->reward_points}}" required>
                    </div>
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>status</label>
                        <select class="form-control" name="status" required>
                          <option disabled>Select Status</option>
                          <option value="1" {{$dailyReward->status == 1 ? "selected" : "" }}>Active</option>
                          <option value="0" {{$dailyReward->status == 0 ? "selected" : "" }}>Inactive</option>
                        </select>
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
              <!-- general form elements -->
            </div> 
            <!--/.col (left) -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection