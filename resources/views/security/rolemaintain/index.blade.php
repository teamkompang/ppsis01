@extends('layouts.app')

@section('content')
@auth
	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="/home">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Search</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				
				<!-- Striped table start -->
				<div class="pd-20 card-box mb-30">
				@include('message')
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-black h4">Search Result</h4>
						</div>
                        <div class="pull-right">
                            <!-- <button type="button" class="btn btn-primary" id="new_line" href="#" data-toggle="modal" data-target="#crete-new-user" type="button">Create New User</button>
                            <button type="button" class="btn btn-primary" id="new_line" href="#" data-toggle="modal" data-target="#crete-public-user" type="button">Create public User</button> -->
                            <a class="btn btn-primary" href="{{ route('roles.create') }}"> Create New Role</a>
                        </div>
					</div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								@foreach ($roles as $role)
									<tr>
										<td>{{ ++$i }}</th>
										<td>{{ $role->name }}</td>
										@can('admin_role-edit')
										<td><a href="{{ route('roles.edit',$role->id) }}"><button class="btn btn-primary btn-sm"><i class="dw dw-edit-1"></i></button></button></a></td>
										@csrf
										@endcan
										@can('admin_role-show')
										<td><a href="{{ route('roles.show',$role->id) }}"><button class="btn btn-primary btn-sm"><i class="dw dw-eye"></i></button></button></a></td>
										@csrf
										@endcan
									</tr>
								@endforeach
							</tr>
						</tbody>
					</table>
					{!! $roles->links() !!}
				</div>
				<!-- Striped table End -->
			</div>
		</div>
    </div>
    
    @endauth
@endsection