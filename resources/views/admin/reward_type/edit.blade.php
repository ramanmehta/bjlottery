@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Rewards Reward Update</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Edit Reward</li>
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
                    <h3 class="card-title">Update Reward</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start-->
                  <form action="{{route('update.RewardType',[encrypt($rewardType->id) ]) }}" method="post">  
                    @csrf
                    
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="reward_title">Reward Title</label>
                          <input type="text" class="form-control" id="reward_title" placeholder="Enter reward title" name="reward_title" value="{{$rewardType->reward_title}}"  required>
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="reward_type">Reward Type</label>
                          <input type="text" class="form-control" id="reward_type" placeholder="Enter reward type" name="reward_type" value="{{$rewardType->reward_type}}" required>
                        </div>

                      </div>
                      {{-- text editor --}}
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_description">Reward Description</label>
                        
                          
                          <textarea id="game_description" name="reward_description">
                            {{$rewardType->reward_description}}
                          </textarea>
                        
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="reward_points">Reward Point </label>
                          <input type="number" class="form-control" id="reward_points" placeholder="Enter reward point" name="reward_points" value="{{$rewardType->reward_points}}" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                              
                              <option disabled>Select Status</option>
                              <option value="1" {{$rewardType->status == 1 ? "selected" : ""}}>Active</option>
                              <option value="0" {{$rewardType->status == 0 ? "selected" : ""}}>Inactive</option>
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