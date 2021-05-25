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
								<h4></h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Search</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Create New Role</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<!-- <div class="pull-left">
							<h4 class="text-black h4">Search</h4>
						</div> -->
					</div>
					<form action="{{ route('roles.update', $role->id) }}" method="POST" name="rolemaintain">
                        @csrf
                        @method('patch') 
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<label class="col-sm-12 col-md-12 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" value="{{$role->name}}" disabled>
                                    <input class="form-control form-control-sm form-control-line" type="hidden" value="{{$role->name}}" name="name">
                                </div>
							</div>
							<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Check</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($permission as $value)
                                                <tr>
                                                    <td></th>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}</td>
                                                </tr>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
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