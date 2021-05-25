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
                                    <li class="breadcrumb-item"><a href="{{ route('securesetting.index') }}">Search</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Security Setting</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-black h4">Search</h4>
						</div>
					</div>
					@include('message')
					@can('admin_security-create')
						<form action="{{ route('securesetting.update' , $secureparam->id) }}" method="POST" name="new_param">
							@csrf
							@method('patch') 
							<div class="modal-body">
								<label class="col-sm-10 col-md-12 col-form-label">Parameter Value</label>
								<div class="col-sm-16 col-md-16">
									<input class="form-control form-control-sm form-control-line" type="text" name="param_value" value="{{ $secureparam->param_value }}" disabled>
									<input class="form-control form-control-sm form-control-line" type="hidden" name="param_value" value="{{ $secureparam->param_value }}" >
								</div>
								<label class="col-sm-10 col-md-12 col-form-label">Value Detail</label>
								<div class="col-sm-16 col-md-16">
									<input class="form-control form-control-sm form-control-line" type="text" name="value_details" value="{{ $secureparam->value_details }}" >
								</div>
								<label class="col-sm-10 col-md-12 col-form-label">Description</label>
								<div class="col-sm-16 col-md-16">
									<input class="form-control form-control-sm form-control-line" type="text" name="description" value="{{ $secureparam->description }}" disabled>
									<input class="form-control form-control-sm form-control-line" type="hidden" name="description" value="{{ $secureparam->description }}" >
								</div>
								<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
								<input class="form-control form-control-sm form-control-line" type="hidden" name="group" value="{{ $secureparam->group }}">
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</form>
					@endcan
				</div>
			</div>
		</div>
	</div>
    @endauth
@endsection