@extends('layouts.print')

@section('title', 'Restructure')

@section('content')
	{{-- <div class="pd-20 card-box mb-30">
		<div class="clearfix move-left" id="title">
			<div class="pull-left">
				<h4 class="text-blue h4">PUNB Panel Solicitors (PPSIS)</h4>
			</div>
		</div>

		<div class="clearfix move-right" id="sisno">
			<div class="pull-left">
				<h4>SIS{{sprintf("%010d",$headers->sis_id ?? "&nbsp;")}}</h4>
			</div>
		</div>
		
		<div class="pd-20 card-box mb-30" style="clear: both;"> --}}
			{{-- <table class="header">
				<tr>
					<th>Applicant Name/Borrower name</th>
					<td>:</td>
					<td>{{ $headers->FULLNAME }}</td>
				</tr>
				<tr>
					<th>Application Type</th>
					<td>:</td>
					<td>{{ $headers->description }}</td>
				</tr>
				<tr>
					<th>Restructure Amount (RM)</th>
					<td>:</td>
					<td>{{ number_format($headers->AMOUNT,2) }}</td>
				</tr>
				<tr>
					<th>Meeting Name</th>
					<td>:</td>
					<td>{{ $headers->MEETINGNAME }}</td>
				</tr>
				<tr>
					<th>Date Approval</th>
					<td>:</td>
					<td>{{ date('d-m-Y', strtotime($headers->DTMEETING)) }}</td>
				</tr>
			</table> --}}
			<table class="move-left" id="body">
				<tr>
					<th>Applicant Name/Borrower Name</th>
					<td>:</td>
					<td>{{ $headers->FULLNAME }}</td>
				</tr>
				<tr>
					<th>Application Type</th>
					<td>:</td>
					<td>{{ $headers->description }}</td>
				</tr>
				<tr>
					<th>Restructure Amount (RM)</th>
					<td>:</td>
					<td>{{ number_format($headers->AMOUNT,2) }}</td>
				</tr>
				<tr>
					<th>Meeting Name</th>
					<td>:</td>
					<td>{{ $headers->MEETINGNAME }}</td>
				</tr>
				<tr>
					<th>Date Approval</th>
					<td>:</td>
					<td>{{ date('d-m-Y', strtotime($headers->DTMEETING)) }}</td>
				</tr>
			</table>

			<table class="move-left" style="margin-left: 50px;">
				<th>Facility</th>
				<td>:</td>
				<td>{{ $headers->case_no }}</td>
			</table>

			{{-- <form>
				<div class="row">
					<div class="col-md-6 col-sm-12 move-left">
						<label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower name</label>
						<div class="col-sm-12 col-md-10">
							<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->FULLNAME }}" disabled>
						</div>
						<label class="col-sm-12 col-md-12 col-form-label">Application Type</label>
						<div class="col-sm-12 col-md-10">
							<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->description }}" disabled>
						</div>
						<label class="col-sm-12 col-md-12 col-form-label">Restructure Amount (RM)</label>
						<div class="col-sm-12 col-md-10">
							<input class="form-control form-control-sm form-control-line" type="text" value="{{ number_format($headers->AMOUNT,2)  }}" disabled>
						</div>
						<label class="col-sm-12 col-md-12 col-form-label">Meeting Name</label>
						<div class="col-sm-12 col-md-10">
							<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->MEETINGNAME }}" disabled>
						</div>
						<label class="col-sm-12 col-md-12 col-form-label">Date Approval</label>
						<div class="col-sm-12 col-md-10">
							<input class="form-control form-control-sm form-control-line" type="text" value="{{ date('d-m-Y', strtotime($headers->DTMEETING)) }}" disabled>
						</div>
					</div>

					<div class="col-md-6 col-sm-12 move-right">
						<label class="col-sm-12 col-md-12 col-form-label">Facility</label>
						<div class="col-sm-12 col-md-10">
							<textarea class="form-control" disabled>{{ $headers->case_no }}</textarea>
						</div>

						<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
						<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $headers->ID }}">
						<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->fullname }}" name="pic" 
						disabled>
						<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel" disabled>
					</div>
				</div>
				<div class="clearfix mb-2">
					<div class="pull-right ">
					</div>
				</div>	
			</form> --}}
	{{-- </div> --}}
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
                	@foreach ($com_restruc as $comm)
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
		/*border: 1px solid red;*/
		text-align: left;
	}

	table#body {
	    width: 33%;
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