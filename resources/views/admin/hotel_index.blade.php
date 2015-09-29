@extends('layouts.admin')
@section('title')
Admin Hotel
@endsection
@section('content')

<div class="row " id="example2" style="padding: 30px">
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Admin Hotel</h3>
  </div>
  <div class="box-body">
      <table class="table table-bordered table-striped" id="example1_wrapper">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hotel</th>
                    <th>Uaaser name</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
          @foreach ($adminHotels  as $key => $adminHotel)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $adminHotel->getHotel->name }}</td>
                  <td>{{ $adminHotel->username }}</td>
                  <td>{{ $adminHotel->name }}</td>
                  <td>{{ $adminHotel->email }}</td>
                  <td>{{ $adminHotel->phone }}</td>
                  <td>
                    {!! Former::open()->route('adminhotel.destroy',$adminHotel->id)->method('Delete') !!}
                    <button onclick="return messenge('Do you want delete?')" class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
                    {!! Former::close() !!}
                  </td>
                </tr>
          @endforeach
            </tbody>
        </table>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-4" > {!! $adminHotels->render() !!} </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('bower_components/AdminLTE/dist/js/msg.js')}}"></script>
<script type="text/javascript">
  $(function () {
    $('#example1_wrapper').DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": false,
      "autoWidth": false
    });
  });
  </script>
  @endsection
