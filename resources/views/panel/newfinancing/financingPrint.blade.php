@extends('layouts.print')

@section('title', 'Financing')

@section('content')
	{{-- @auth --}}
	{{-- <div class="main-container"> --}}
		{{-- <div class="pd-20 card-box mb-30">
			<div class="clearfix move-left" id="title">
				<div class="pull-left">
					<h4 class="text-blue h4">PUNB Panel Solicitors (PPSIS)</h4>
				</div>
			</div>

			<div class="clearfix move-right" id="sisno">
				<div class="pull-left">
					<h4>SIS{{sprintf("%010d",$headers->sis_id)}}</h4>
				</div>
			</div>

			<div class="pd-20 card-box mb-30" style="clear: both;">
				<div class="clearfix">
					<div class="pull-left">
						<h4 class="text-black h4">Financing</h4>
					</div>
				</div>
				<form>
					<div class="row">
						<div class="col-md-6 col-sm-12 move-left">
							<label class="col-sm-12 col-md-12 col-form-label">Case Tracking Number</label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control form-control-sm form-control-line" type="text" value="SIS{{ sprintf("%010d",$headers->sis_id) }}" 
								disabled>
							</div>
							<label class="col-sm-12 col-md-12 col-form-label">PUNB Officer</label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->LADOFFICER }}" disabled>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 move-right">
							<label class="col-sm-12 col-md-12 col-form-label">SIS Case Status</label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->value_details }}" disabled>
							</div>
							<label class="col-sm-12 col-md-12 col-form-label">Panel Solicitors</label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->Name }}" disabled>
							</div>
						</div>
					</div>

					<div class="clearfix mb-2">
						<div class="pull-right ">
							
						</div>
					</div>	
				</form>
				<div class="dropdown-divider"></div> --}}
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
					{{-- <tr>
						<th>Agreement No</th>
						<td>:</td>
						<td>{{ $headers->case_no }}</td>
					</tr> --}}
				</table>

				<table class="move-left" style="margin-left: 50px;">
					<th>Agreement No</th>
					<td>:</td>
					<td>{{ $headers->case_no }}</td>
				</table>

				{{-- <form>
					<div class="row">
						<div class="col-md-6 col-sm-12 move-left">
							<label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower Name</label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->FULLNAME }}" disabled>
							</div>
							<label class="col-sm-12 col-md-12 col-form-label">Application Type</label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control form-control-sm form-control-line" type="text" value="{{ $headers->description }}" disabled>
							</div>
							<label class="col-sm-12 col-md-12 col-form-label">Date Memo</label>
							<div class="col-sm-12 col-md-10">
								<input class="form-control form-control-sm form-control-line" type="text" value="{{ date('d-m-Y', strtotime($headers->DTMEETING)) }}" disabled>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 move-right">
							<label class="col-sm-12 col-md-12 col-form-label">Agreement No</label>
							<div class="col-sm-12 col-md-10">
								<textarea class="form-control" disabled style="height: 50px;">{{ $headers->case_no }}</textarea>
							</div>
						</div>
					</div>
					<div class="clearfix mb-2">
						<div class="pull-right ">
						</div>
					</div>	
				</form> --}}
			{{-- </div> --}}
			
			{{-- <form>
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-6-left">
						<label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower Name</label>
						<div class="col-sm-12 col-md-10 mt-2">
                            <input type="text" value="{!! $headers->FULLNAME ?? "&nbsp;" !!}" disabled>
                        </div>
						<label class="col-sm-12 col-md-12 col-form-label">Application Type</label>
						<div class="col-sm-12 col-md-10 mt-2">
                            <input type="text" value="{!! $headers->TYPE ?? "&nbsp;" !!}" disabled>
                        </div>
						<label class="col-sm-12 col-md-12 col-form-label">Application Status</label>
						<div class="col-sm-12 col-md-10 mt-2">
                            <input type="text" value="{!! $headers->FACSTATUS ?? "&nbsp;" !!}" disabled>
                        </div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-6-right">
                        <label class="col-sm-12 col-md-12 col-form-label">Facility</label>
						<div class="col-sm-12 col-md-10 mt-2">
                            <input type="text" value="&nbsp;" disabled>
                        </div>
                        <label class="col-sm-12 col-md-12 col-form-label">Date Memo</label>
						<div class="col-sm-12 col-md-10 mt-2">
                            <input type="text" value="&nbsp;" disabled>
                        </div>
						<label class="col-sm-12 col-md-12 col-form-label">Panel Solicitors</label>
						<div class="col-sm-12 col-md-10 mt-2">
							<input type="text" value="{!! $headers->Name ?? "&nbsp;" !!}" disabled>
						</div>
					</div>
				</div>
			</form> --}}
		{{-- </div> --}}
		<!-- Striped table start -->
	
		{{-- <div class="pd-20 card-box mb-30" style="clear: both;">
			<div class="clearfix mb-20">
				<div class="pull-left">
					<h4 class="text-blue" style="margin-top: 10px">Details</h4>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Solicitors Name</th>
                            <th>Issue Date</th>
                            <th>Return Date</th>
                            <th>Details</th>
                            <th>Updates by</th>
                            <th>Updates at</th>
                            <th>Comment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach ($com_finan as $i => $comm)
                    	<tr>
                    			<td>{{$i+1}}</td>
                    			<td>{{ $comm->panel_update }}</td>
                    			<td>{{ $comm->issue_date }}</td>
                    			<td>{{ $comm->return_date }}</td>
                    			<td>{!! nl2br($comm->details) !!}</td>
                    			<td>{{ $comm->pic }}</td>
                    			<td>{{ $comm->update_date }}</td>
                    			<td>{{ $comm->status_comment }}</td>
                    		</tr>
                    		@endforeach
                    </tbody>
				</table>
            </div>
		</div> --}}
	{{-- </div> --}}
	{{-- <script type="text/php">
        if ( isset($pdf) ) {
            // OLD 
            // $font = Font_Metrics::get_font("helvetica", "bold");
            // $pdf->page_text(72, 18, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(255,0,0));
            // v.0.7.0 and greater
            $x = 72;
            $y = 560;
            $text = "{PAGE_NUM} of {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 6;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script> --}}
    {{-- @endauth --}}
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