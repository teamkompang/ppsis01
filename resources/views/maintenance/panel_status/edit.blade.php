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
                                    <li class="breadcrumb-item"><a href="{{ route('panelstatus.index') }}">Search</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Panel Status</li>
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
					<form>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<label class="col-sm-12 col-md-12 col-form-label">Name</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $panels->Name }}" type="text" >
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Address</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control">{{ $panels->Address }}</textarea>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Postcode</label>
								<div class="col-sm-12 col-md-10">
                                <input class="form-control form-control-sm form-control-line" value="{{ $panels->PostCode }}" type="text" >

                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">TelNo</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $panels->TelNo }}" type="text" >
                                </div>
							</div>
							<div class="col-md-6 col-sm-12">
                                <label class="col-sm-12 col-md-12 col-form-label">City</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $panels->Soli_City }}" type="text" >
                                </div>
                                <label class="col-sm-12 col-md-12 col-form-label">States</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" value="{{ $panels->Soli_State }}" type="text" >
                                </div>
							</div>
						</div>
						<div class="clearfix mb-2">
						@can('punb_panelstatus-create')
							<div class="pull-right ">
								<input type="submit" class="btn btn-primary btn-sm" name="search" value="Update">	
							</div>
						@endcan
						</div>	
					</form>
				</div>
				<!-- Striped table start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-black h4">Search Result</h4>
                        </div> 
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <!-- <th></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
									@foreach ($panelset as $panel)
									<tr>
										<td>{{ ++$i }}</th>
										<td>{{ $panel->fullname }}</td>
										<td>{{ $panel->email }}</td>
										<td>{{ $panel->contact }}</td>
										<!-- <td><a href="{{ route('panelstatus.show', $panel->id ) }}"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td> -->
										@csrf
									</tr>
									@endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>   
                </div>
				<!-- Striped table End -->
			</div>
		</div>
    </div>
    @endauth
@endsection