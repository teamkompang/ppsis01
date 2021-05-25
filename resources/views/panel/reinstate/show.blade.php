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
                                    <li class="breadcrumb-item"><a href="{{ route('panelreinstate.index') }}">Search</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Reinstate</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
				
				<!-- Striped table start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-blue h4">Search Result</h4>
						</div>
					</div>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th></th>
								<th>Case No.</th>
								<th>Product</th>
								<th>Agreement No</th>
								<th>Status</th>
								<th>Created At</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($reins as $reinstate)
								<tr>
									<td>{{ ++$i }}</td>
									<td>SIS{{ sprintf("%010d",$reinstate->sis_id) }}</td>
									<td>{{ $reinstate->product }}</td>
									<td>{{ $reinstate->case_no }}</td>
									<td>{{ $reinstate->value_details }}</td>
									<td>{{ $reinstate->created_at }}</td>
									@can('panel_reinstate-edit')
									<td><a href="{{ route('panelreinstate.edit', $reinstate->sis_id ) }}"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>
									@csrf
									@endcan
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- Striped table End -->
			</div>
		</div>
	</div>
	
    @endauth
@endsection