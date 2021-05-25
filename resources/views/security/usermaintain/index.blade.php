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
							@can('admin_parameter-edit')
								<button type="button" class="btn btn-primary" id="new_line" href="#" data-toggle="modal" data-target="#crete-new-user" type="button">Create New User</button>
								<!-- <button type="button" class="btn btn-primary" id="new_line" href="#" data-toggle="modal" data-target="#crete-public-user" type="button">Create public User</button> -->
							@endcan
						</div>
					</div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Email</th>
								<th>Company</th>
								<th>Role</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								@foreach ($users as $user)
									<tr>
										<td>{{ ++$i }}</th>
										<td>{{ $user->fullname }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->company }}</td>
										<td>{{ $user->role }}</td>
										<td>{{ $user->value_details }}</td>
										@can('admin_parameter-edit')
										<td><a href="{{ route('usermaintain.edit', $user->id ) }}"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>
										@csrf
										
										@endcan
									</tr>
								@endforeach
							</tr>
						</tbody>
					</table>
					{!! $users->links() !!}
				</div>
				<!-- Striped table End -->
			</div>
		</div>
    </div>
    @include('modal/modalusermaintain')
    @endauth
@endsection