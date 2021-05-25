@extends('layouts.print')

@section('content')
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
			<th>Date Memo</th>
			<td>:</td>
			<td>{{ date('d-m-Y', strtotime($headers->DTMEETING)) }}</td>
		</tr>
	</table>

	<table class="move-left" style="margin-left: 50px;">
		<th>Agreement No</th>
		<td>:</td>
		<td>{{ $headers->case_no }}</td>
	</table>
	{{-- @auth
	<div class="main-container">
		<div>
			<div>
				<div class="pd-20 card-box mb-30	">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">Financing</h4>
						</div>
					</div>
					
					<div class="pd-20 card-box mb-30">
					<form>
						<div class="row">
							<div class="col-md-10 col-sm-12 col-xs-10">
								<label class="col-sm-12 col-md-12 col-xs-12 col-form-label">Applicant Name/Borrower Name</label>
								<div class="col-sm-12 col-md-10 col-xs-12 mt-2">
                                    <input type="text" value="{!! $financings->FULLNAME ?? "&nbsp;" !!}" disabled style="width: 50%;">
                                </div>
							</div>
						</div>
					</form>
				</div>

				<!-- Striped table start -->
				<div class="pd-20 card-box mb-30" style="clear: both;">
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
                            	@foreach ($com_finan as $comm)
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
				</div>
				<!-- Striped table End -->
			</div>
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