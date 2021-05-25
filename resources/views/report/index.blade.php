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
									<li class="breadcrumb-item active" aria-current="page">Report</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-black h4">Search</h4>
						</div>
					</div>
					<form>
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower Name</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" id="applicants" name="applicants">
										<option selected="" value="">Choose...</option>
										@foreach ($applicant_list as $listapplicant)
											<option value="{{ $listapplicant->CUSTNO }}">{{ $listapplicant->FULLNAME }}</option>
										@endforeach
									</select>
								</div>

								<label class="col-sm-12 col-md-12 col-form-label">Application Type</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" id="status" name="type">
										<option selected="" value="">Choose...</option>
										@foreach ($types as $type => $description)
											<option value="{{ $type }}">{{ $description }}</option>
										@endforeach
									</select>
								</div>

								<label class="col-sm-12 col-md-12 col-form-label">Application Status</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" id="status" name="status">
										<option selected="" value="">Choose...</option>
										@foreach ($status as $stat)
											<option value="{{ $stat->value_details }}">{{ $stat->value_details }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<label class="col-sm-12 col-md-12 col-form-label">Facility</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" id="facility" name="facility">
										<option selected="" value="">Choose...</option>
									</select>
								</div>	

								<label class="col-sm-12 col-md-12 col-form-label">Date Memo</label>
								<div class="col-sm-12 col-md-10">
									<input type="text" name="memo_date" class="form-control date-picker">
								</div>	

								<label class="col-sm-12 col-md-12 col-form-label">Panel Solicitors</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12" id="solicitors" name="solicitors">
										<option selected="" value="">Choose...</option>
										@foreach ($solicitors as $solicitor)
											<option value="{{ $solicitor->ICode }}">{{ $solicitor->Name }}</option>
										@endforeach
									</select>
								</div>															
							</div>
						</div>
						<div class="clearfix mb-2 mt-4">
							<div class="pull-right ">
								<button type="button" class="btn btn-outline-primary">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-printer" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path d="M11 2H5a1 1 0 0 0-1 1v2H3V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h-1V3a1 1 0 0 0-1-1zm3 4H2a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v1H2a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1z"></path>
										<path fill-rule="evenodd" d="M11 9H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM5 8a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H5z"></path>
										<path d="M3 7.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"></path>
									</svg>
								</button>

								<button type="button" class="btn btn-outline-primary">
									<svg width="1em" height="1em" viewBox="0 0 16 16" 
										class="bi bi-file-earmark-excel" 
										fill="currentColor" 
										xmlns="http://www.w3.org/2000/svg">
										<path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z">
										</path>
										<path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"></path>
										<path fill-rule="evenodd" d="M5.18 6.616a.5.5 0 0 1 .704.064L8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 0 1 .064-.704z"></path>
									</svg>
								</button>	
							</div>
						</div>	
					</form>
				</div>
				
			</div>
		</div>
    </div>
    @endauth
@endsection

@push('scripts')
    <script>
    	$(function() {
    		$('#applicants').change(function(){

    		})

    		$('#status').change(function(){

    		})

    		$('#solicitors').change(function(){

    		})

    		$('.btn-outline-primary').on('click', function(e){
    			e.preventDefault();
    			const data = $('form').serialize();
 				const className = $(this).children().attr('class').split('-');
 				const outputType = className[className.length-1];
 				const url = "/report/" + outputType + "?" + data;
 				// console.log(this.childNodes[1].classList[1])
 				console.log(url);
 				$.get('report/' + outputType, data, function(data, textStatus, xhr) {
 					// console.log(data);
 					let wn = window.open('about:blank',"", "width=700, height=500");
 					wn.document.write("<iframe width='100%' height='100%' src='" + url + "'></iframe>");
 					// wn.document.write(data);
 					// wn.document.close();
 				});
 				// window.open('report/' + outputType + '?' + data, "", "channelmode=yes, width=700, height=500");
 				
    		});
    	});
    </script>
@endpush