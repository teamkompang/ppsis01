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
                                    <li class="breadcrumb-item"><a href="{{ route('panelfinancing.index') }}">Search</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Financing</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
					<div class="pd-20 card-box mb-30">
						<div class="clearfix">
							<div class="pull-left">
								<h4 class="text-blue h4">Header</h4>
							</div>
						</div>
						<form>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<label class="col-sm-12 col-md-12 col-form-label">Case Tracking Number</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="SIS{{ sprintf("%010d",$financings->sis_id) }}" disabled>
									</div>
									<label class="col-sm-12 col-md-12 col-form-label">panel Officer</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->LADOFFICER }}" disabled>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<label class="col-sm-12 col-md-12 col-form-label">Case Status</label>
									<div class="col-sm-12 col-md-10">
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->value_details }}" disabled>
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
										<input class="form-control form-control-sm form-control-line" type="text" value="{{ $financings->description }}" disabled>
									</div>
									<label class="col-sm-12 col-md-12 col-form-label">Date Memo</label>
									<div class="col-sm-12 col-md-10">
										<!-- <input class="form-control form-control-sm form-control-line" type="text" value="{{ date('d-m-Y', strtotime($financings->DTMEETING)) }}" disabled> -->
									</div>
									
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
							<div class="clearfix mb-2">
								<div class="pull-right ">
								</div>
							</div>	
						</form>
					</div>
						<!-- Start Tabs -->
				<div class="row clearfix">

					<div class="col-lg-12 col-md-12 col-sm-12 mb-30">
						<div class="pd-20 card-box">
							<h5 class="h4 text-blue mb-20"></h5>
							<div class="tab">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active text-blue" data-toggle="tab" href="#home" role="tab" aria-selected="true">Home</a>
									</li>
									<li class="nav-item">
										<a class="nav-link text-blue" data-toggle="tab" href="#attach" role="tab" aria-selected="false">Attachment</a>
									</li>
								</ul>
								<div class="tab-content">
								<br/>
								@include('message')
									<!-- Details Start -->
										<div class="tab-pane fade show active" id="home" role="tabpanel">
											<div class="pd-20">
												
												<div class="clearfix mb-20">
													<div class="pull-left">
														<h4 class="text-blue h4">Details</h4>
													</div>
													<div class="pull-right">
														{{-- <button type="button" class="btn btn-primary" id="print">Print</button> --}}
														<a href="{{route('panelfinancing.edit', [
															//$financings->ID, 
															$id, 
															'output' => 'print',
															'page' => $com_finan->currentPage()
														])}}" class="btn btn-primary" target="_blank">Print</a>

														@if ($statuscase->count())
															<!-- <button type="button" class="btn btn-primary" id="new_line" href="#" 
															data-toggle="modal" data-target="#bd-example-modal-lg" type="button" disabled >Add New Line</button> -->
														@else
															@if( $financings->ICode == Auth::user()->company ||  Auth::user()->company == "panel" )
																@can('panel_financing-create')
																	<button type="button" class="btn btn-primary" id="new_line" href="#" 
																	data-toggle="modal" data-target="#bd-example-modal-lg" type="button" >Add New Line</button>
																@endcan	
															@else
																
															@endif
														@endif

													</div>
												</div>
												<div class="table-responsive">
													<table class="table table-striped table-bordered data-table">
														<thead>
															<tr>
																<th></th>
																<th>Solicitors name</th>
																<th>Issue date</th>
																<th>Return date</th>
																<th>Details</th>
																<th>Updates by</th>
																<th>Updates at</th>
																<th>Comment Status</th>
																<!-- <th>Status</th> -->
																<th></th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
												

												@if ($statuscase->count())
													<!-- disbaled -->
													<!-- <form action="{{ route('panelfinancing.update', $financings->ID )  }}" method="POST" name="updatehead">
														@csrf
														@method('PATCH')
														<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
														<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $financings->ID }}">

														<right><button type="submit" class="btn btn-primary" id="close_case" disabled >Close Case</button></right>
													</form> -->
												@else  
													@if( $financings->ICode == Auth::user()->company ||  Auth::user()->company == "panel" )
														@can('panel_financing-delete')
															<!-- active -->
															<form action="{{ route('panelfinancing.update', $financings->sis_id )  }}" method="POST" name="updatehead">
																@csrf
																@method('PATCH')
																<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
																<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $financings->ID }}">
																<input class="form-control form-control-sm form-control-line" type="hidden" name="sis_id" value="{{ $financings->sis_id }}">
																<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel_update" >
																<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->fullname }}" name="pic">
																<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ Auth::user()->company }}" name="panel">
																<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ \Carbon\Carbon::now()->format('d F Y')}}" name="issue_date">
																<input class="form-control form-control-sm form-control-line" type="hidden" value="Request to Close Case" name="details">
																<input class="form-control form-control-sm form-control-line" type="hidden" value="{{ \Carbon\Carbon::now()->format('Y-m-d H:i:s')}}" name="update_date">
																<input class="form-control form-control-sm form-control-line" type="hidden" name="status_comment" value="1">
																<input class="form-control form-control-sm form-control-line" type="hidden" name="status_case" value="1">

																<right><button type="submit" class="btn btn-primary" id="request_close_case" >Request to Close Case</button></right>
															</form>
														@endcan	
													@else
																
													@endif
												@endif
												</br>
												<!-- <right><button type="button" id="btnUpdate" class="btn btn-primary ">Update</button></right> -->
												
											</div>
										</div>
									<!-- Details End -->

									<!-- Attachment Start -->
										<div class="tab-pane fade" id="attach" role="tabpanel">
											<div class="pd-20">
												
												<div class="clearfix mb-20">
													<div class="pull-left">
														<h4 class="text-blue h4">Attachment</h4>
													</div>
													<div class="pull-right">
														@if ($statuscase->count())
															
														@else
															@if( $financings->ICode == Auth::user()->company ||  Auth::user()->company == "panel" )
																@can('panel_financing-create')
																	<button type="button" class="btn btn-primary" id="new_line" href="#" 
																	data-toggle="modal" data-target="#attachment" type="button" >Add New Attachment</button>
																@endcan	
															@else
																
															@endif
														@endif

													</div>
												</div>
												<div class="table-responsive">
													<table class="table table-striped table-bordered">
														<thead>
															<tr>
																<th></th>
																<th>Solicitors Name</th>
																<th>File Name</th>
																<th>Description</th>
																<th>Updates by</th>
																<th>Updates at</th>
																<th></th>
															</tr>
														</thead>
														
														<tbody>
															<tr>
																@foreach ($listfile as $filling)
																	<tr>
																		<td>{{ ++$i }}</th>
																		<td>{{ $filling->panel_update }}</td>
																		<td>{{ $filling->name }}</td>
																		<td>{!! nl2br($filling->description) !!}</td>
																		<td>{{ $filling->user_created }}</td>
																		<td>{{ $filling->updated_at }}</td>
																		<td>
																		<a href="{{ route('downloadFile', ['filename'=>basename($filling->path),'sis_id'=>$filling->sis_id]) }}">
																		<button type="submit" value="Hide" class="btn btn-primary btn-sm" ><i class="icon-copy dw dw-download"></i></button></button>
																		</a>
																		</td>
																	</tr>
																@endforeach
															</tr>
															
														</tbody>
													</table>
													{{$listfile->links()}}
												</div>
											</div>
										</div>
									<!-- Attachment End -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End tabs -->
			</div>
		</div>
	</div>
	@include('modal/panel/financing/modalfinancing')
	@include('modal/panel/financing/modalupload')
	@include('modal/modalshowcase')

	<script type="text/javascript">
	

		$(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});


			var table = $('.data-table').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('panelfinancing.edit', $id) }}",
				columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex'},
					// {data: 'panel_update', name: 'panel_update', orderable: false},
					{data: 'Name', name: 'Name', orderable: false},

					{data: 'issue_date', name: 'issue_date'},
					{data: 'return_date', name: 'return_date'},
					{data: 'details', name: 'details'},
					{data: 'pic', name: 'pic'},
					{data: 'update_date', name: 'update_date'},
					{data: 'status_comment', name: 'status_comment'},
					// {data: 'DTMEETING', name: 'DTMEETING'},
					{data: 'action', name: 'action', orderable: false, searchable: false},
				]
			});
		});

		$('body').on('click', '.ActiveItem', function () {
     
			var Item_id = $(this).data("id");
			var user_lastmaintain = $(this).data("user");
			// confirm("Are You sure want to hide comment ?");
			if (confirm("Are You sure want to hide comment ?") == true){
				$.ajax({
					type: "POST",
					url: "{{ route('PSTLstatusActiveCase',$id) }}",
					data: { 'Item_id' : Item_id, 'user_lastmaintain' : user_lastmaintain },
					success: function (data) {
						location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}	
				});
			}
			else{
				alert("Cancelled by user");
        		return false;
			}
			
		});

		$('body').on('click', '.HideItem', function () {
     
			var Item_id = $(this).data("id");
			var user_lastmaintain = $(this).data("user");
			// confirm("Are You sure want to Activate comment ?");
			if (confirm("Are You sure want to hide comment ?") == true){
				$.ajax({
					type: "POST",
					url: "{{ route('PSTLstatusHideCase',$id) }}",
					data: { 'Item_id' : Item_id, 'user_lastmaintain' : user_lastmaintain },
					success: function (data) {
						location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}	
				});
			}
			else{
				alert("Cancelled by user");
        		return false;
			}
			
		});

		/* Show customer */
		$('body').on('click', '#show-user', function () {
			
			// var comm_id = $(this).data('data-id');
			// var myLineBreak = myTextareaVal.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br />');
			var comm_id = $(this).attr('data-id');
			console.log(comm_id);
			$.get('/PanelViewComment/'+comm_id, function (data) {

				$('#cid').html(data.cid);
				$('#pic').html(data.pic);
				$('#issue_date').html(data.issue_date);
				$('#panel_update').html(data.panel_update);
				// $('#details').html(data.details);
				$('#details').html(data.details);

			})
			$('#userCrudModal-show').html("Case Details");
			$('#crud-modal-show').modal('show');

		});


	</script>

    @endauth
@endsection


