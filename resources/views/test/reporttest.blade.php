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
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('casestatus.index') }}">Search</a></li>
                                    <li class="breadcrumb-item">Case Status</li>
                                    <li class="breadcrumb-item active" aria-current="page">View Case</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
					<div class="pd-20 card-box mb-30">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                </tr>
                                <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                </tr>
                                <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
						<form>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label class="col-sm-12 col-md-12 col-form-label">Case Tracking Number</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="SIS{{ sprintf("%010d",$financings->sis_id) }}" disabled>
									</div>
									<label class="col-sm-12 col-md-12 col-form-label">PUNB Officer</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->LADOFFICER }}" disabled>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<label class="col-sm-12 col-md-12 col-form-label">Case Status</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->case_status }}" disabled>
									</div>
									<label class="col-sm-12 col-md-12 col-form-label">Panel Solicitors</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->Name }}" disabled>
									</div>
								</div>

							</div>
							<div class="clearfix mb-2">
								<div class="pull-right ">
									
								</div>
							</div>	
						</form>
						<br>
						<div class="dropdown-divider"></div>

						<form>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower Name</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->FULLNAME }}" disabled>
									</div>
									<label class="col-sm-12 col-md-12 col-form-label">Application Type</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->app_type }}" disabled>
									</div>
									<!-- <label class="col-sm-12 col-md-12 col-form-label">Date Memo</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" disabled>
									</div> -->
									
									<!-- <label class="col-sm-12 col-md-12 col-form-label">Application Status</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->FACSTATUS }}" disabled>
									</div> -->
								</div>
								<div class="col-md-6 col-sm-12">
									<label class="col-sm-12 col-md-12 col-form-label">Agreement No.</label>
									<div class="col-sm-12 col-md-10">
										<textarea class="form-control" disabled>{{ $financings->case_no }}</textarea>
									</div>
									<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
									<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $financings->ID }}">
									<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->fullname }}" name="pic" disabled>
									<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel" disabled>
								</div>
							</div>
						</form>
                        <br>
                       
                      
					</div>
			</div>
		</div>
	</div>

    @endauth
@endsection

