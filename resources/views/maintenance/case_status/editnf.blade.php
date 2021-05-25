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
                                    <li class="breadcrumb-item"><a href="{{ route('casestatus.index') }}">Search</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Case Status</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-black h4">Header</h4>
						</div>
					</div>
					<form>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower Name</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" value="{{ $casesheader->FULLNAME }}" disabled>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Application Type</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" value="{{ $casesheader->description }}" disabled>
								</div>
								<label class="col-sm-12 col-md-12 col-form-label">Scheme</label>
								<div class="col-sm-12 col-md-10">
                                    <input class="form-control form-control-sm form-control-line" type="text" value="{{ $casesheader->scheme }}" disabled>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
                                <label class="col-sm-12 col-md-12 col-form-label">App Reference No</label>
								<div class="col-sm-12 col-md-10">
									<textarea class="form-control" value="{{ $casesheader->APPREF }}" disabled>{{ $casesheader->APPREF }}</textarea>
                                </div>
							</div>
						</div>
							
					</form>
				</div>
				<!-- Striped table start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-black h4">Search Result</h4>
                        </div>
                        <div class="pull-right">
						@can('punb_casestatus-create')
							<a href="{{ route('casestatus.show', $casesheader->APPREF ) }}">
							
								<button type="button" class="btn btn-primary" id="print">Add New Case</button>
							</a>
						@endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Case No.</th>
                                    <th>Product</th>
                                    <th>Agreement No</th>
                                    <th>Updates by</th>
                                    <th>Updates at</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
									@foreach ($cases as $case)
										<tr>
											<td>SIS{{ $case->ref_no }}</td>
											<td>{{ $case->product }}</td>
											<td>{{ $case->case_no }}</td>
											<td>{{ $case->user_lastmaintain }}</td>
											<td>{{ $case->updated_at }}</td>
											<td>{{ $case->value_details }}</td>
											<td><a href="{{ route('ViewCasesNF', $case->sis_id ) }}"><button class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button></button></a></td>
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