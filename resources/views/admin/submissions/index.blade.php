@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Mission Submissions</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Mission Submissions</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            {{-- <div class="card-header">
              <!-- <h3 class="card-title">Levels</h3> -->
              &nbsp;&nbsp;&nbsp;&nbsp;
            </div> --}}

            {{-- <div class="row mb-2 mt-4">
              <div class="col-sm-6">
              </div>
              <div class="col-sm-6 ">
                <form class="mt-4" action="" method="get">
                  <div class="input-group mb-3 ">

                    <!-- <input type="search" class="form-control" placeholder="Search here" aria-label="search mission" aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}" id="search">
                    <input class="btn btn-outline-secondary" type="submit" value="Search"> -->

                  </div>
                </form>

              </div>
            </div> --}}
            <!-- /.card-header -->
            <div class="card-body">
              @if ($message = Session::get('success'))
              <div class="alert alert-success alert-dismissible col-lg-12" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                <strong></strong> {{ $message }}
              </div>
              @endif
              @if ($message = Session::get('error'))
              <div class="alert alert-danger alert-dismissible col-lg-12" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                <strong></strong> {{ $message }}
              </div>
              @endif
              <table class="table table-striped table-bordered text-center">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Mission Title</th>
                    <th scope="col">Mission Type</th>
                    <th scope="col">Affaliate Point</th>
                    <th scope="col">Prize Name</th>
                    <th scope="col">Prize Image</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Proof</th>
                    <th scope="col">Submitted At</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($submissions as $key => $submission)
                  <tr>
                    <th scope="row">{{ ++$key }}</th>
                    <td>{{ $submission->mission->mission_title }}</td>
                    <td>{{ $submission->mission->mission_type }}</td>
                    <td>{{ $submission->mission->enter_earn_affliated_points }}</td>
                    @if ($submission->mission->prize_name == null)
                    <td>---</td>
                    @else
                    <td>{{ $submission->mission->prize_name }}</td>
                    @endif
                    @if ($submission->mission->prize_image == null)
                    <td>---</td>
                    @else
                    <td><img width="100" height="50" src="{{ $submission->mission->prize_image }}" alt="image"></td>
                    @endif
                    <td>{{ $submission->user->name }}</td>
                    <td>
                      <a href="{{  getImage($submission->proof) }}" target="_blank">
                        View Proof
                      </a>
                    </td>
                    <td>{{ $submission->created_at }}</td>
                    <td>
                      <select class="form-control status" name="status">
                        <option data-id="{{ $submission->id }}" {{ $submission->approval_status == 'submit' ? 'selected'
                          : '' }}
                          value="submit">Submit</option>
                        <option data-id="{{ $submission->id }}" {{ $submission->approval_status == 'approved' ?
                          'selected' : ''
                          }} value="approved">Approve</option>
                        <option data-id="{{ $submission->id }}" {{ $submission->approval_status == 'reject' ? 'selected'
                          : '' }}
                          value="reject">Reject</option>
                      </select>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <br>
              {!! $submissions->links() !!}
            </div>
            
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- ./wrapper -->

<!-- jQuery -->
{{-- <script src="../../plugins/jquery/jquery.min.js"></script> --}}
<!-- Bootstrap 4 -->
{{-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<!-- DataTables  & Plugins -->
<!-- DataTables  & Plugins -->

@endsection

@section('script')
<script>
  $('.status').change(function(){
  $.ajax({
    type: "POST",
    url: "{{route('mission.submit.status.update')}}",
    data: {"id" : $('option:selected',this).data('id'),"status" : $(this).val(),'_token' : "{{ csrf_token() }}"},
    dataType: "json",
    success: function (response) {
      console.log(response)
    }
  });
})
</script>
@endsection