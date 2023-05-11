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
                                    <button id="add" class="btn btn-info btn-xs"><i class="fa fa-plus"></i>&nbsp; Add More</button>
                                </div>
                            </div>
                            
                            <hr>

                            <form action="{{ route('add.price.post') }}" method="post" enctype="multipart/form-data">
                                <table id="example2" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Ticket Number</th>
                                            <th>Prize Name</th>
                                            <th>Prize Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <input type="hidden" name="lottery_id" value="{{ $data->id }}">
                                    @csrf
                                    <tbody>
                                        <tr class="form">
                                            <td>
                                                <select class="form-control" name="ticket_no[]">
                                                    <option value="" selected>Select Ticket No</option>
                                                    @foreach ($claims as $claim)
                                                    <option value="{{ $claim->ticket_number }}">{{ $claim->ticket_number
                                                        }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="prize_name[]">
                                            </td>
                                            <td>
                                                <input class="form-control" type="file" name="prize_image[]">
                                            </td>
                                            <td>
                                                <a class="remove btn btn-danger btn-xs" href="#"><i
                                                        class='fas fa-trash-alt'></i>&nbsp;Remove</a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4">
                                                <button type="submit" class="btn btn-success btn-sm">Submit Winner</button>
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
<script>
    $('#add').click(function(){
        var html;
        var app = @json($claims);
        html += '<tr class="form">';
        html += '<td>';
        html += '<select class="form-control" name="ticket_no[]">';
        html += '<option selected value="">Select Ticket No</option>';
        $.each(app, function (index, val) {
            html += '<option value="'+val.ticket_number+'">'+val.ticket_number+'</option>'
        });
        html += '</select>';
        html += '</td>';
        html += '<td>';
        html += '<input class="form-control" type="text" name="prize_name[]">';
        html += '</td>';
        html += '<td>';
        html += '<input class="form-control" type="file" name="prize_image[]">';
        html += '</td>';
        html += '<td>';
        html += '<a class="remove btn btn-danger btn-xs" href="#"><i class="fas fa-trash-alt"></i>&nbsp;Remove</a>';
        html += '</td>';
        html += '</tr>';

    $('#example2').find('tbody').prepend(html)
})

$('body').on('click','.remove',function(){
    $(this).parents('tr').remove()
})
</script>
@endsection
@endsection