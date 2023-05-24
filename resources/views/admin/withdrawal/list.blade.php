@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Withdrawal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">User Withdrawal List</li>
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

                            <form action="{{ Request::fullUrl() }}" method="get">
                                <div class="row pt-3">
                                    <div class="col-sm-6">
                                        <input class="form-control" name="date" type="date"
                                            value="{{ request()->get('date') }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="search" class="form-control" placeholder="Search Anything"
                                                aria-label="Search Lottery" aria-describedby="basic-addon2"
                                                name="search" value="{{ request()->get('search') }}" id="search">
                                            &nbsp;
                                            &nbsp;
                                            <input class="btn btn-outline-secondary" type="submit" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>

                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <th>Name</th>
                                        <th>UserName</th>
                                        <th>Amount</th>
                                        <th>Details</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banks as $key => $bank)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $bank->name }}</td>
                                        <td>{{ $bank->username }}</td>
                                        <td>{{ $bank->amount }}</td>
                                        <td>{{ $bank->text }}</td>
                                        <td>{{ $bank->created_at }}</td>
                                        <td style="width: 15%">
                                            {{-- @if (in_array($bank->statuss,[2,3]))
                                            {!! $bank->statuss == 2 ? '<span class="btn btn-success btn-xs">Admin
                                                Deposited</span>' : '<span class="btn btn-danger btn-xs">Admin
                                                Rejected</span>' !!}
                                            @else --}}
                                            <select class="status form-control">
                                                <option disabled data-id="{{ $bank->id }}" {{ $bank->statuss == 1 ?
                                                    'selected' : '' }} value="1">Withdrawal Requested</option>
                                                <option data-id="{{ $bank->id }}" {{ $bank->statuss == 2 ? 'selected' :
                                                    '' }} value="2">Admin Deposited</option>
                                                <option data-id="{{ $bank->id }}" {{ $bank->statuss == 3 ? 'selected' :
                                                    '' }} value="3">Admin Rejected</option>
                                            </select>
                                            {{-- @endif --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            {!! $banks->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
    $('.status').change(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "{{ route('withdrawal.status') }}",
        data: {'status' : $(this).val(),'id' : $('option:selected',this).data('id'),'_token' : "{{ csrf_token() }}"},
        dataType: "json",
        success: function (response) {
            location.reload();
        }
    });
});
</script>
@endsection