@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lucky Draw Price</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Lucky Draw Price List</li>
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



                            <div class="row">
                                <div class="col-md-1">
                                    Name :
                                </div>
                                <div class="col-md-4 text-left">
                                    <b>{{ $data->game_title }}</b>
                                </div>
                                <div class="col-md-1">
                                    Image :
                                </div>
                                <div class="col-md-4 text-left">
                                    <img width="100" height="50" src="{{ getImage($data->game_image) }}"
                                        alt="{{$data->game_title}}">
                                </div>
                                <div class="col-md-2 text-right">
                                    <a href="{{route('add.price.form',encrypt($data->id))}}"><button type="button"
                                            class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i> Add
                                            Prize</button></a>

                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <form action="" method="get">
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
                                        <th>Prize Name</th>
                                        <th>Prize Image</th>
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
                                        <td>{{ $claim->user->name }}</td>
                                        <td>{{ $claim->user->username }}</td>
                                        <td>{{ $claim->prize_name }}</td>
                                        <td>
                                            <img width="100" height="50" src="{{ $claim->prize_image }}"
                                                alt="{{ $claim->prize_name }}">
                                        </td>
                                        <td>
                                            <a href="{{route('add.price.edit',[encrypt($claim->id)])}}">
                                                <button type="button" class="btn btn-success btn-xs">
                                                    <i class='fas fa-edit'></i>&nbsp;Edit</button>
                                            </a>

                                            <a onclick="return confirm('Are you sure remove lucky draw : {{$claim->prize_name}}?')"
                                                href="{{route('add.price.destroy',[$data->id,encrypt($claim->id)])}}">
                                                <button type="button" class="btn btn-danger btn-xs">
                                                    <i class='fas fa-trash-alt'></i>&nbsp;Remove</button>
                                            </a>
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