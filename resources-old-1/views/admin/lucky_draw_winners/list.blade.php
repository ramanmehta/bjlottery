@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lucky Draw Claim</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Lucky Draw Claim List</li>
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

                            <div class="row pt-3">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <form action="{{ Request::fullUrl() }}" method="get">
                                        <div class="input-group">
                                            <input type="search" class="form-control" placeholder="Search Ticket No"
                                                aria-label="Search Lottery" aria-describedby="basic-addon2"
                                                name="search" value="{{ request()->get('search') }}" id="search">
                                            &nbsp;
                                            &nbsp;
                                            <input class="btn btn-outline-secondary" type="submit" value="Search">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <hr>

                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <th>Ticket No</th>
                                        <th>Name</th>
                                        <th>UserName</th>
                                        <th>Lottery name</th>
                                        <th>Prize Name</th>
                                        <th>Prize Image</th>
                                        <th>Address 1</th>
                                        <th>Address 2</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($claims->isNotEmpty())
                                    @foreach ($claims as $key => $claim)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            {{ $claim->ticket_no }}
                                        </td>
                                        <td>
                                            {{ $claim->name }}
                                        </td>
                                        <td>
                                            {{ $claim->username }}
                                        </td>
                                        <td>
                                            {{ $claim->lottery->game_title }}
                                        </td>
                                        <td>
                                            {{ $claim->prize->prize_name }}
                                        </td>
                                        <td>
                                            <img width="100" height="50" src="{{ $claim->prize->prize_image }}"
                                                alt="{{ $claim->prize->prize_name }}">
                                        </td>
                                        <td>
                                            {{ $claim->address_1 }}
                                        </td>
                                        <td>
                                            {{ $claim->address_2 }}
                                        </td>
                                        <td>
                                            <select class="status form-control">
                                                <option data-id="{{ $claim->id }}" {{ $claim->status == 1 ? 'selected' :
                                                    '' }} value="1">Claim
                                                </option>
                                                <option data-id="{{ $claim->id }}" {{ $claim->status == 2 ? 'selected' :
                                                    '' }} value="2">Pending
                                                </option>
                                                <option data-id="{{ $claim->id }}" {{ $claim->status == 3 ? 'selected' :
                                                    '' }} value="3">Approved
                                                </option>
                                                <option data-id="{{ $claim->id }}" {{ $claim->status == 4 ? 'selected' :
                                                    '' }} value="4">Rejected
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="text-center" colspan="7">No Record Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            </form>
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
        url: "{{ route('status.update.winner.user') }}",
        data: {'status' : $(this).val(),'id' : $('option:selected',this).data('id'),'_token' : "{{ csrf_token() }}"},
        dataType: "json",
        success: function (response) {
            console.log(response)
        }
    });
});
</script>
@endsection