@extends('layouts.app')

@section('content')
@auth
	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Form</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('usermaintain.index') }}">Search</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">User Maintenance</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
				<div class="pd-20 card-box mb-30">
				@include('message')
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-black h4">Search</h4>
						</div>
					</div>
					<form action="{{ route('usermaintain.update', $useredit->id) }}" method="POST" name="usermaintain">
						@csrf
						@method('patch') 
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<label class="col-sm-12 col-md-12 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" value="{{ $useredit->fullname }}" name="fullname">
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Email</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" value="{{ $useredit->email }}" name="email">
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Contact</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" value="{{ $useredit->contact }}" name="contact">
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Password</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="password" name="password" placeholder="Password">
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Confirm Password</label>
								<div class="col-sm-12 col-md-10">
									<input  id="password-confirm" type="password" class="form-control form-control-sm form-control-line" name="password_confirmation"  autocomplete="new-password" placeholder="Password Confirmation">
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Received Email</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" name="received_email" >
											@foreach ($emailstat as $stat)
												<option value="{{ $stat->param_value }}" @if($stat->param_value == $useredit->received_email) selected @endif>{{ $stat->value_details }}</option>
												
											@endforeach
									</select>
								</div>
								<label class="col-sm-12 col-md-12 col-form-label">Company</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" name="company" >
											@foreach ($panelset as $panel)
												<option value="{{ $panel->ICode }}" @if($panel->ICode == $useredit->company) selected @endif>{{ $panel->Name }}</option>
												
											@endforeach
									</select>
								</div>
								<label class="col-sm-12 col-md-12 col-form-label">Status</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" name="status" >
											@foreach ($status as $stat)
												<option value="{{ $stat->param_value }}" @if($stat->param_value == $useredit->status) selected @endif>{{ $stat->value_details }}</option>
												
											@endforeach
									</select>
								</div>

								<label class="col-sm-12 col-md-12 col-form-label">Role</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" name="role" >
											@foreach ($roles as $role)
												<option value="{{ $role->name }}" @if($role->name == $useredit->role) selected @endif>{{ $role->name }}</option>
												
											@endforeach
									</select>
								</div>

								<label class="col-sm-12 col-md-12 col-form-label">Access Expired</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control date-picker" placeholder="Select Date" type="text" name="access_expired" value="{{ $useredit->access_expired }}">
								</div>
								
								
								<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
							</div>
							<div class="col-md-6 col-sm-12">
                                <label class="col-sm-12 col-md-12 col-form-label">Company</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" disabled>
                                </div>
                                <label class="col-sm-12 col-md-12 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $useredit->Name }}" type="text" disabled>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Address</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" disabled>{{ $useredit->Address }}</textarea>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Postcode</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $useredit->PostCode }}" type="text" disabled>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">TelNo</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $useredit->TelNo }}" type="text" disabled>
                                </div>
                                <label class="col-sm-12 col-md-12 col-form-label">City</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $useredit->Soli_City }}" type="text" disabled>
                                </div>
                                <label class="col-sm-12 col-md-12 col-form-label">States</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $useredit->Soli_State }}" type="text" disabled>
                                </div>													
							</div>
						</div>
						<div class="clearfix mb-2">
							<div class="pull-right ">
                                <input type="submit" class="btn btn-primary btn-sm" name="search" value="Update">	
							</div>
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>
    @endauth
@endsection