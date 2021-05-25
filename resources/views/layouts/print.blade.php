<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Report headers PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    @stack('styles')
    <style type="text/css">
    	.main-container {
    		margin: 0 auto;
    	}

    	table.header th, table.header td {
    		border: 0;
    		padding: 0;
    		text-align: left;
    	} 

    	/*table.header th, table.header td {
    		text-align: left;
    	}*/

    	table.header {
    		width: 40%;
    		/*border: 1px solid red;*/
    	}

    	table.table-striped, table.table-striped td, table.table-striped th {
    		border-collapse: collapse;
    		border: 1px solid;
    	}
    	
    	table.table-striped {
    		width: 100%;
    	}
    </style>
</head>
<body>
	@auth
	<div class="main-container">
		<div class="pd-20 card-box mb-30">
			<div class="clearfix move-left" id="title">
				<div class="pull-left">
					<h4 class="text-blue h4">PUNB Panel Solicitors (PPSIS)</h4>
				</div>
			</div>

			<div class="clearfix move-right" id="sisno">
				<div class="pull-left">
					<h4>SIS{{sprintf("%010d",$headers->sis_id ?? "") }}</h4>
				</div>
			</div>

			<div class="pd-20 card-box mb-30" style="clear: both;">
				<div class="clearfix">
					<div class="pull-left">
						<h4 class="text-black h4">@yield('title')</h4>
					</div>
				</div>
				
				<table class="header">
					<tr>
						<th>Case Tracking Number</th>
						<td>:</td>
						<td style="width: auto;">SIS{{ sprintf("%010d",$headers->sis_id ?? "") }}</td>
					</tr>
					<tr>
						<th>PUNB Officer</th>
						<td>:</td>
						<td>{{ $headers->LADOFFICER ?? "" }}</td>
					</tr>
					<tr>
						<th>SIS Case Status</th>
						<td>:</td>
						<td>{{ $headers->value_details ?? ""}}</td>
					</tr>
					<tr>
						<th>Panel Solicitors</th>
						<td>:</td>
						<td>{{ $headers->Name ?? "" }}</td>
					</tr>
				</table>

				{{-- <form>
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
				</form> --}}
				<div class="dropdown-divider"></div>
				@yield('content')
			</div>
		</div>

		<div class="pd-20 card-box mb-30" style="clear: both;">
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
						@foreach ($body ?? '' as $i => $row)
						<tr>
							<td style="text-align: center;">{{$i+1}}</td>
							<td>{{ $row->panel_update }}</td>
							<td>{{ $row->issue_date }}</td>
							<td>{{ $row->return_date }}</td>
							<td>{!! nl2br($row->details) !!}</td>
							<td>{{ $row->pic }}</td>
							<td>{{ $row->update_date }}</td>
							<td>{{ $row->status_comment }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>

		<script type="text/php">
	        if ( isset($pdf) ) {
	            // OLD 
	            // $font = Font_Metrics::get_font("helvetica", "bold");
	            // $pdf->page_text(72, 18, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(255,0,0));
	            // v.0.7.0 and greater
	            $x = 40;
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
	    </script>
	</div>
	@endauth
</body>
</html>
