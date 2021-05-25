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
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-blue h4">Search Result</h4>
						</div>
                        <div class="pull-right">
							@can('admin_parameter-create')
                            <button type="button" class="btn btn-primary" id="new_group" href="#" data-toggle="modal" data-target="#crete-group-param" type="button">Create Group Parameter</button>
                            <button type="button" class="btn btn-primary" id="new_parameter" href="#" data-toggle="modal" data-target="#crete-new-parameter" type="button">Create New Parameter</button>
							@endcan
						</div>
					</div>
					<table class="table table-striped">
						<thead>
							<tr>
								<th></th>
								<th>Group</th>
								<th>Parameter Value</th>
								<th>Value Details</th>
								<th>Description</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($secure_param as $param)
								<tr>
									<td>{{ ++$i }}</th>
									<td>{{ $param->group }}</td>
									<td>{{ $param->param_value }}</td>
									<td>{{ $param->value_details }}</td>
									<td>{{ $param->description }}</td>
									@can('admin_parameter-edit')
									<td><a href="{{ route('paramsetting.edit', $param->id ) }}"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>
									@csrf
									@endcan
									
								</tr>
							@endforeach
						</tbody>
					</table>
					{!! $secure_param->links() !!}
				</div>
				<!-- Striped table End -->
			</div>
		</div>
    </div>
    @include('modal/modal')
    @endauth
@endsection