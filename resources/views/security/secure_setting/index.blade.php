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
							<h4 class="text-black h4">Search Result</h4>
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
							<tr>
								@foreach ($secure_setting as $setting)
									<tr>
										<td>{{ ++$i }}</th>
										<td>{{ $setting->group }}</td>
										<td>{{ $setting->param_value }}</td>
										<td>{{ $setting->value_details }}</td>
										<td>{{ $setting->description }}</td>
										@can('admin_security-edit')
										<td><a href="{{ route('securesetting.edit', $setting->id ) }}"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>
										@csrf
										@endcan
									</tr>
								@endforeach
							</tr>
						</tbody>
					</table>
					{!! $secure_setting->links() !!}
				</div>
				<!-- Striped table End -->
			</div>
		</div>
    </div>
    
    @endauth
@endsection