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
                        <li class="breadcrumb-item active">Lucky Draw Price</li>
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

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible col-lg-12" role="alert">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong></strong>
                                @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                                @endforeach
                            </div>
                            @endif


                            <div class="row">
                                <div class="col-md-1">
                                    Name :
                                </div>
                                <div class="col-md-4 text-left">
                                    <b>{{ $winners->lottery->game_title }}</b>
                                </div>
                                <div class="col-md-1">
                                    Image :
                                </div>
                                <div class="col-md-4 text-left">
                                    <img width="100" height="50" src="{{ getImage($winners->lottery->game_image) }}"
                                        alt="{{$winners->lottery->game_title}}">
                                </div>
                            </div>

                            <hr>

                            <form action="{{ route('edit.prize.update',$winners->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <table id="example2" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Ticket Number</th>
                                            <th>Prize Name</th>
                                            <th>Prize Image</th>
                                            <th>Prize Image View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="form">
                                            <td>
                                                {{ $winners->ticket_no }}
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="prize_name"
                                                    value="{{ $winners->prize_name }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="file" name="prize_image">
                                            </td>
                                            <td>
                                                <img width="100" height="50" src="{{ getImage($winners->prize_image) }}" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <input type="submit" class="btn btn-success" value="Update Prize">
                                            </td>
                                        </tr>
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

@endsection