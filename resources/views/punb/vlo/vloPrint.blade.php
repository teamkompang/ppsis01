@extends('layouts.print')

@section('title', 'VLO')

@section('content')
	<table class="move-left" id="body">
		<tr>
			<th>Applicant Name/Borrower Name</th>
			<td>:</td>
			<td>{{ $headers->FULLNAME }}</td>
		</tr>
		<tr>
			<th>Account No.</th>
			<td>:</td>
			<td>{{ $headers->FULLNAME }}</td>
		</tr>
		<tr>
			<th>Application Type</th>
			<td>:</td>
			<td>{{ $headers->status }}</td>
		</tr>
		<tr>
			<th>Date Approval</th>
			<td>:</td>
			<td>{{ date('d-m-Y', strtotime($headers->DTMEETING)) }}</td>
		</tr>
		{{-- <tr>
			<th>Agreement No</th>
			<td>:</td>
			<td>{{ $headers->case_no }}</td>
		</tr> --}}
	</table>

	<table class="move-left" style="margin-left: 50px;">
		<tr>
			<th>Agreement No</th>
			<td>:</td>
			<td>{{ $headers->case_no }}</td>
		</tr>
		<tr>
			<th>VLO Track</th>
			<td>:</td>
			<td>{{$headers->description}}</td>
		</tr>
	</table>
	
	{{-- @auth
	<div class="main-container">
		<div>
			<div>
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">VLO</h4>
						</div>
					</div>
					
					<div class="pd-20 card-box mb-30">
					<form>
						<div class="row">
							<div class="col-md-6 col-sm-12 col-xs-6-left">
								<label class="col-sm-12 col-md-12 col-form-label">Account No.</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="{!! $headers->FULLNAME ?? "&nbsp;" !!}" disabled>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Date Approval</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="{!! $headers->DTMEETING ?? "&nbsp;" !!}" disabled>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">Lad Officer</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="{!! $headers->LADOFFICER ?? "&nbsp;" !!}" disabled>
                                </div>
								<label class="col-sm-12 col-md-12 col-form-label">App Status</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="{!! $headers->FACSTATUS ?? "&nbsp;" !!}" disabled>
                                </div>
							</div>
							<div class="col-md-6 col-sm-12 col-xs-6-right">
                                <label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower Name</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="{!! $headers->FULLNAME ?? "&nbsp;" !!}" disabled>
                                </div>
                                <label class="col-sm-12 col-md-12 col-form-label">Approval Committee</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="{!! $headers->MEETINGNAME ?? "&nbsp;" !!}" disabled>
                                </div>
                                <label class="col-sm-12 col-md-12 col-form-label">VLO  Track</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="&nbsp;" disabled>
                                </div>
                                <label class="col-sm-12 col-md-12 col-form-label">Solicitor</label>
								<div class="col-sm-12 col-md-10 mt-2">
                                    <input type="text" value="{!! $headers->Name ?? "&nbsp;" !!}" disabled>
                                </div>
							</div>
						</div>
						</div>
					</form>
				</div> --}}

				<!-- Striped table start -->
				{{-- <div class="pd-20 card-box mb-30" style="clear: both;">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-blue" style="margin-top: 10px">Search Result</h4>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Solicitors Name</th>
                                    <th>Issue Date</th>
                                    <th>Details</th>
                                    <th>Updates by</th>
                                    <th>Updates at</th>
                                    <th>Status</th>                       
                                </tr>
                            </thead>
                            <tbody>
                            	@foreach ($com_vlo as $comm)
                            	<tr>
                            			<td></td>
                            			<td>{{ $comm->panel_update }}</td>
                            			<td>{{ $comm->issue_date }}</td>
                            			<td>{{ $comm->details }}</td>
                            			<td>{{ $comm->pic }}</td>
                            			<td>{{ $comm->update_date }}</td>
                            			<td>{{ $comm->status_comment }}</td>
                            		</tr>
                            	@endforeach

                            </tbody>
						</table>
                    </div>
				</div> --}}
				<!-- Striped table End -->
			{{-- </div>
		</div>
	</div>
    @endauth --}}
@endsection

@push('styles')
<style type="text/css">	    
	.col-xs-6-left {
		float: left;
		width: auto;
	}

	.col-xs-6-right {
		float: right;
		width: auto;
	}

	table#body td, table#body th {
		padding: 0;
		border: 0;
		/*border: 1px solid red;*/
		text-align: left;
	}

	table#body {
	    width: 30%;
	    /*width: auto;*/
	    /*margin-left: -25px;*/
	    /*float: left;*/
	    /*border: 1px solid red;*/
	}

	.col-md-6 {
		width: 50%;
	}

	.move-left {
		float: left;
		width: 25%;
	}

	.move-left td, .move-left th {
		padding: 0;
		margin: 0;
		text-align: left;
	}

	.move-right {
		float: right;
	}

	.dropdown-divider {
		height: 0;
		/*margin: .5rem 0;*/
		overflow: hidden;
		border-top: 1px solid #e9ecef;
		/*clear: both;*/
		/*margin-top: 105px;*/
	}

	body {
		font-size: 12px;
		font-family: Tahoma;
	}

	#title, #sisno {
		/*width: 50%;*/
	}

	#sisno {
		/*margin-left: 200px;*/
	}
</style>
@endpush