<!-- Start Tabs -->
<div class="row clearfix">
				@include('message')
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
									<!-- Details Start -->
										<div class="tab-pane fade show active" id="home" role="tabpanel">
											<div class="pd-20">
												
												<div class="clearfix mb-20">
													<div class="pull-left">
														<h4 class="text-blue h4">Details</h4>
													</div>
													<div class="pull-right">
														{{-- <button type="button" class="btn btn-primary" id="print">Print</button> --}}
														<a href="{{route('punbfinancing.edit', [
															$financings->ID, 
															'output' => 'print',
															'page' => $com_finan->currentPage()
														])}}" class="btn btn-primary" target="_blank">Print</a>

														@if ($statuscase->count())
															<!-- <button type="button" class="btn btn-primary" id="new_line" href="#" 
															data-toggle="modal" data-target="#bd-example-modal-lg" type="button" disabled >Add New Line</button> -->
														@else
															@if( $financings->ICode == Auth::user()->company ||  Auth::user()->company == "PUNB" )
																@can('punb_financing-create')
																	<button type="button" class="btn btn-primary" id="new_line" href="#" 
																	data-toggle="modal" data-target="#bd-example-modal-lg" type="button" >Add New Line</button>
																@endcan	
															@else
																
															@endif
														@endif

													</div>
												</div>
												<div class="table-responsive">
													<table class="table table-striped">
														<thead>
															<tr>
																<th></th>
																<th>Solicitors name</th>
																<th>Issue date</th>
																<th>Return date</th>
																<th>Details</th>
																<th>Updates by</th>
																<th>Updates at</th>
																<!-- <th>Status</th> -->
																<th></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																@foreach ($com_finan as $comm)
																	<tr>
																		<td>{{ ++$i }}</th>
																		<td>{{ $comm->panel_update }}</td>
																		<td>{{ $comm->issue_date }}</td>
																		<td>{{ $comm->return_date }}</td>
																		<td>{{ $comm->details }}</td>
																		<td>{{ $comm->pic }}</td>
																		<td>{{ $comm->update_date }}</td>
																		<!-- <td>{{ $comm->status_comment }}</td> -->
																		
																		@if ($statuscase->count())
																				<!-- <form action="{{ route('STLstatusCase', $comm->cid )  }}" method="POST" name="updateline">
																					@csrf
																					@method('PATCH')
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="cid" value="{{ $comm->cid }}">
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $comm->header_id }}">
																					<td><button type="submit" value="Hide" class="btn btn-primary btn-sm" disabled > <i class="icon-copy dw dw-trash1"></i></button></button></td>
																				</form> -->
																				<td></td>
																		@else
																			@if( $comm->panel_update == Auth::user()->company  )
																				<form action="{{ route('STLstatusCase', $comm->cid )  }}" method="POST" name="updateline">
																					@csrf
																					@method('PATCH')
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="cid" value="{{ $comm->cid }}">
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $comm->header_id }}">
																					<td><button type="submit" value="Hide" class="btn btn-primary btn-sm" ><i class="icon-copy dw dw-trash1"></i></button></button></td>
																				</form>
																			@else
																				<td></td>
																			@endif
																		@endif

																	</tr>
																@endforeach
															</tr>
														</tbody>
													</table>
													{{$com_finan->links()}}
												</div>

												@if ($statuscase->count())
													<!-- disbaled -->
													<!-- <form action="{{ route('punbfinancing.update', $financings->ID )  }}" method="POST" name="updatehead">
														@csrf
														@method('PATCH')
														<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
														<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $financings->ID }}">

														<right><button type="submit" class="btn btn-primary" id="close_case" disabled >Close Case</button></right>
													</form> -->
												@else  
													@if( $financings->ICode == Auth::user()->company ||  Auth::user()->company == "PUNB" )
														@can('punb_financing-delete')
															<!-- active -->
															<form action="{{ route('punbfinancing.update', $financings->ID )  }}" method="POST" name="updatehead">
																@csrf
																@method('PATCH')
																<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
																<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $financings->ID }}">

																<right><button type="submit" class="btn btn-primary" id="close_case" >Close Case</button></right>
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
															@if( $financings->ICode == Auth::user()->company ||  Auth::user()->company == "PUNB" )
																@can('punb_financing-create')
																	<button type="button" class="btn btn-primary" id="new_line" href="#" 
																	data-toggle="modal" data-target="#attachment" type="button" >Add New Attachment</button>
																@endcan	
															@else
																
															@endif
														@endif

													</div>
												</div>
												<div class="table-responsive">
													<table class="table table-striped">
														<thead>
															<tr>
																<th></th>
																<th>Solicitors Name</th>
																<th>File Name</th>
																<th>Description</th>
																<th>Updates by</th>
																<th>Updates at</th>
																<th></th>
																<th></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																@foreach ($com_finan as $comm)
																	<tr>
																		<td>{{ ++$i }}</th>
																		<td>{{ $comm->panel_update }}</td>
																		<td>{{ $comm->panel_update }}</td>
																		<td>{{ $comm->pic }}</td>
																		<td>{{ $comm->update_date }}</td>
																		<td>
																			<button type="submit" value="Hide" class="btn btn-primary btn-sm" ><i class="icon-copy dw dw-download"></i></button></button>
																		</td>
																		@if ($statuscase->count())
																				<td></td>
																		@else
																			@if( $comm->panel_update == Auth::user()->company  )
																				<form action="{{ route('STLstatusCase', $comm->cid )  }}" method="POST" name="updateline">
																					@csrf
																					@method('PATCH')
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="user_lastmaintain" value="{{ Auth::user()->fullname }}">
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="cid" value="{{ $comm->cid }}">
																					<input class="form-control form-control-sm form-control-line" type="hidden" name="header_id" value="{{ $comm->header_id }}">
																					<td>
																						<button type="submit" value="Hide" class="btn btn-primary btn-sm" ><i class="icon-copy dw dw-trash1"></i></button></button>
																					</td>
																				</form>	
																			@else
																				<td></td>

																			@endif
																		@endif

																	</tr>
																@endforeach
															</tr>
														</tbody>
													</table>
													{{$com_finan->links()}}
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