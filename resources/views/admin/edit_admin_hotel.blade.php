@extends('layouts.admin')

@section('content')

<div class="row" style="padding:40px">
	@if (Session::has('flash_message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong>
			{{ Session::get('flash_message') }}
		</div>
	@endif
	<form action="{{ route('admin-hotel.update', $adminHotel->id) }}" method="POST" role="form">
		<input type="hidden" name="_method" value="PUT">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Errors!</strong> Wrong data input
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>	
			@endforeach
			</ul>
			</div>
		@endif
		<legend>Edit Hotel Admin With Username : '{{ $adminHotel->username }}'</legend>
		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
		<div class="form-group">
			<label for="">Hotel:</label>
			<select name="hotel_id" id="inputHotel_id" class="form-control" required="required" value="">
				@foreach( $hotels as $hotel)
					@if ($adminHotel->hotel_id == $hotel->id)
					<option value="{{ $hotel->id }}" selected>{{ $hotel->name }}</option>
					@else
					<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
					@endif
				@endforeach		
			</select>
		</div>

		<div class="form-group">
			<label for="">Real name:*</label>
			<input type="text" name="name" class="form-control" id="" placeholder="Hotel admin's real name" value="{{ $adminHotel->name }}">
		</div>

		<div class="form-group">
			<label for="">Phone:*</label>
			<input type="text" name="phone" class="form-control" id="" placeholder="Phone" value="{{ $adminHotel->phone }}">
		</div>

		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>

@endsection