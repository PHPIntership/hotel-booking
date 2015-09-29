@extends('layouts.admin')

@section('content')

<div class="row" style="padding:50px;">
	@if (Session::has('flash_message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong>
			{{ Session::get('flash_message') }}
		</div>
	@endif
<form action="{{ route('admin-hotel.store') }}" method="POST" role="form">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
	<legend>Create Hotel Admin</legend>
	
	<div class="form-group">
		<label for="">Hotel:</label>
		<select name="hotel_id" id="inputHotel_id" class="form-control" required="required" value="{{ old('hotel_id') }}">
			@foreach( $hotels as $hotel)
			<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
			@endforeach		
		</select>
	</div>

	<div class="form-group">
		<label for="">Username:*</label>
		<input type="text" class="form-control" name="username" id="username" placeholder="Hotel Admin's username" value="{{ old('username') }}">
	</div>

	<div class="form-group">
		<label for="">Password:*</label>
		<input type="password" name="password" class="form-control" id="password" placeholder="******" value="{{ old('password') }}">
	</div>

	<div class="form-group">
		<label for="">Real name:*</label>
		<input type="text" name="name" class="form-control" id="name" placeholder="Hotel admin's real name" value="{{ old('name') }}">
	</div>

	<div class="form-group">
		<label for="">Email:*</label>
		<input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
	</div>

	<div class="form-group">
		<label for="">Phone:*</label>
		<input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="{{ old('phone') }}">
	</div>

	<button type="submit" id="formsubmit" class="btn btn-primary">Submit</button>
</form>
</div>

@endsection
