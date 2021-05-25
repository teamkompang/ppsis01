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
									<li class="breadcrumb-item active" aria-current="page">Search</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Default Basic Forms Start -->
				<div class="pd-20 card-box mb-30 form-inline">
					<div class="clearfix">
						<!-- <div class="pull-left">
							<h4 class="text-blue h4">Filter</h4>
						</div> -->
					</div>
					
						<div class="row">
							<div class="col-md-16 col-sm-12">
								<!-- <label class="col-sm-12 col-md-12 col-form-label">Applicant Name/Borrower Name</label> -->
								<div class="col-sm-12 col-md-12"> Applicant Name/Borrower Name
									<select name="filter_fullname" id='filter_fullname' class="custom-select col-12" >
										<option selected="">Choose...</option>
										@foreach ($applicant_list as $listapplicant)
											<option value="{{ $listapplicant->APPREF }}">{{ $listapplicant->FULLNAME }}</option>
										@endforeach
									</select>
									
								</div>
								
								<!-- <label class="col-sm-12 col-md-12 col-form-label">Application Status</label>
								<div class="col-sm-12 col-md-10">
									<select class="custom-select col-12">
										<option selected="">Choose...</option>
										@foreach ($status as $stat)
											<option value="{{ $stat->param_value }}">{{ $stat->value_details }}</option>
										@endforeach
									</select>
								</div> -->
							</div>
							
						</div>
						<div class="clearfix mb-2">
							<div class="pull-right ">
								<input type="submit" class="btn btn-primary btn-sm" name="filter" id="filter" value="Search">	
							</div>
						</div>	
					
				</div>
				<!-- Striped table start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-black h4">Search Result</h4>
						</div>
					</div>

					<div class="table-responsive">
						<table id="customer_data" class="table table-bordered table-striped">
							<thead>
								<tr>
										<th></th>
										<th>Applicant Name</th>
										<th>IC/Reg No</th>
										<th>Borrower Name</th>
										<th>Scheme</th>
										<th>App Apply Date</th>
										<th>Approved Amount</th>
										<th>Approved Date</th>
										<th></th>
								</tr>
							</thead>
						</table>
   					</div>

				</div>
				<!-- Striped table End -->
			</div>
		</div>
    </div>
	<!-- <script type="text/javascript">
		$(function () {
			var table = $('.data-table').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('punbfinancing.index') }}",
				columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex'},
					{data: 'FULLNAME', name: 'FULLNAME', orderable: false},
					{data: 'IDNO', name: 'IDNO'},
					{data: 'FULLNAME', name: 'FULLNAME'},
					{data: 'PRDABBR', name: 'PRDABBR'},
					{data: 'DTCREATED', name: 'DTCREATED'},
					{data: 'AMOUNT', name: 'AMOUNT'},
					{data: 'DTMEETING', name: 'DTMEETING'},
					{data: 'action', name: 'action', orderable: false, searchable: false},
				]
			});
		});

	</script> -->

	<script>
		$(document).ready(function(){

			fill_datatable();

			function fill_datatable(filter_fullname = '')
			{
				var dataTable = $('#customer_data').DataTable({
					processing: true,
					serverSide: true,
					ajax:{
						url: "{{ route('panelnewfinancing.index') }}",
						data:{filter_fullname:filter_fullname}
					},
					columns: [
						{
							data:'DT_RowIndex',
							name:'DT_RowIndex'
						},
						{
							data:'FULLNAME',
							name:'FULLNAME'
						},
						{
							data:'IDNO',
							name:'IDNO'
						},
						{
							data:'FULLNAME',
							name:'FULLNAME'
						},
						{
							data:'value_details',
							name:'value_details'
						},
						{
							data:'DTAPPLIED',
							name:'DTAPPLIED'
						},
						{
							data:'AMTAPPLIED',
							name:'AMTAPPLIED',
							render: $.fn.dataTable.render.number( ',', '.', 2, 'RM' )
						},
						{
							data:'DTAPPROVED',
							name:'DTAPPROVED'
						},
						{
							data:'action',
							name:'action',
							orderable: false,
							searchable: false
						},
					]
				});
			}

			$('#filter').click(function(){
				// var filter_fullname = $('#filter_usaha').val();
				var filter_fullname = $('#filter_fullname').val();

				if(filter_fullname != '')
				{
					$('#customer_data').DataTable().destroy();
					fill_datatable(filter_fullname);
				}
				else
				{
					alert('Select Both filter option');
				}
			});

		});
	</script>

    @endauth
@endsection