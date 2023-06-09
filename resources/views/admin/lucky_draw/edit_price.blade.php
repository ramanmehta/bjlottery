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
                        <li class="breadcrumb-item active">Lucky Draw Prize</li>
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
                                    <img width="100" height="50" src="{{ $winners->lottery->game_image }}"
                                        alt="{{$winners->game_title}}">
                                </div>
                                {{-- <div class="col-md-2 text-right">
                                    <button id="add" class="btn btn-success btn-xs add_prize"><i
                                            class="fa fa-plus"></i>&nbsp; Add
                                        Prize</button>
                                    <button id="add" class="btn btn-info btn-xs add_cash"><i
                                            class="fa fa-plus"></i>&nbsp; Add
                                        Cash</button>
                                </div> --}}
                            </div>

                            <hr>

                            <form action="{{ route('edit.prize.update',$winners->id) }}" method="post"
                                enctype="multipart/form-data">
                                <table id="example2" class="table table-bordered table-hover text-center">
                                    <input type="hidden" name="lottery_id" value="{{ $winners->id }}">
                                    @csrf
                                    <tbody>
                                        @if (is_null($winners->prize_name))
                                        <tr class="form">
                                            <td>
                                                {{ $winners->ticket_no }}
                                            </td>
                                            <td colspan="2">
                                                <input class="form-control" type="number" name="prize_name"
                                                    placeholder="Enter Amount" value="{{ $winners->amount }}">
                                            </td>
                                        </tr>
                                        @else
                                        <tr class="form">
                                            <td>
                                                {{ $winners->ticket_no }}
                                            </td>
                                            <td colspan="2">
                                                <input class="form-control" type="text" name="prize_name"
                                                    placeholder="Prize Name" value="{{ $winners->prize_name }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="file" name="prize_image">
                                            </td>
                                            <td>
                                                <img width="100" height="50" src="{{ $winners->prize_image }}"
                                                    alt="image">
                                            </td>
                                        </tr>
                                        @endif
                                        <tr class="form"></tr>
                                        <tr class="submit">
                                            <td colspan="4">
                                                <button type="submit" class="btn btn-success btn-sm">Submit
                                                    Winner</button>
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

@section('script')

@endsection
@endsection