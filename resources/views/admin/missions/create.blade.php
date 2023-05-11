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
          <h1>New Mission</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
            <li class="breadcrumb-item active">Missions</li>
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
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Create New Mission</h3>
            </div>

            <!-- /.card-header -->
            <!-- form start-->
            <form action="{{route('user.Mission')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="mission_title">Mission Title</label>
                    <input type="text" class="form-control" id="mission_title" placeholder="Enter mission title"
                      name="mission_title" value="{{ old('mission_title') }}">
                    @error('mission_title')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="game_description">Mission Description</label>
                    <textarea id="game_description"
                      name="mission_description">{{ old('mission_description') }}</textarea>
                    @error('mission_description')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="type">Mission Type</label>
                    <select id="type" class="form-control" name="mission_type">
                      <option value="" selected>Select Type</option>
                      <option {{ old('mission_type')=='affliated_points' ? 'selected' : '' }} value="affliated_points">
                        Affliated Points</option>
                      <option {{ old('mission_type')=='prize' ? 'selected' : '' }} value="prize">Prize</option>
                    </select>
                    @error('mission_type')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                </div>

                <div class="form-row point d-none">
                  <div class="form-group col-md-12">
                    <label for="enter_earn_affliated_points">Enter Earn Affliated Points</label>
                    <input type="text" class="form-control" id="enter_earn_affliated_points"
                      placeholder="Enter Earn Affliated Points" name="enter_earn_affliated_points">
                    @error('enter_earn_affliated_points')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                </div>

                <div class="form-row prize d-none">
                  <div class="form-group col-md-6">
                    <label for="prize_name">Prize Name</label>
                    <input type="text" class="form-control" id="prize_name" placeholder="Prize Name" name="prize_name">
                    @error('prize_name')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="prize_image">Prize Image</label>
                    <input type="file" class="form-control" id="prize_image" placeholder="Prize Image"
                      name="prize_image">
                    @error('prize_image')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="status">
                        <option disabled>Select Status</option>
                        <option {{ old('status')==1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ old('status')==0 ? 'selected' : '' }} value="0">Inactive</option>
                      </select>
                    </div>
                    @error('status')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label for="banner_image">Banner Image</label>
                    <input type="file" class="form-control" id="banner_image" name="banner_image" value="" />
                    @error('banner_image')
                    <font class="text-red">{{ $message }}</font>
                    @enderror
                  </div>
                </div>

                <div class="col-3">
                  <input type="submit" class="btn btn-primary btn-block" value="Save">
                </div>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
{{-- <script>
  var today = new Date(); 
          $('#reservationtime').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            minDate:today,
            // timePickerIncrement: 30,
            locale: {
              // format: 'MM/DD/YYYY H:mm:ss'
              format: 'YYYY/MM/DD H:mm:ss'
            }
          });
               
</script> --}}
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')
<script>
  $('#type').change(function(){

  if ($(this).val() == 'affliated_points') {
      $('.point').removeClass('d-none')
      $('.prize').addClass('d-none')
    }else{
      $('.point').addClass('d-none')
      $('.prize').removeClass('d-none')
  }
})
</script>
@endsection