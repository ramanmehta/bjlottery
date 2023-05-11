@extends('admin.layouts.app')

@section('content')

<div class="form-group col-lg-6 justify-content-center">
    <label>Date and time:</label>
      <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
          <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
          <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
      </div>
  </div>

@endsection
