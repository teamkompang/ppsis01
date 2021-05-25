
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
				
				<!-- Striped table start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-blue h4">Search Result</h4>
						</div>
					</div>
          @include('message')
					<div class="table-responsive">
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th></th>
									<th> Case No</th>
                  <!-- <th colspan="2"> From Company</th> -->
                  <th> From: Company</th>
                  <th> From: Person</th>
                  <th> To: Company </th>
                  <th> To: Person </th>
                  <th> Details </th>
                  <th> Status </th>
                  <th> Send At</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
   					</div>

             <a  class="btn btn-primary" href="{{ route('send-email') }}">Send All Back</a>

				</div>
				<!-- Striped table End -->
			</div>
		</div>
    </div>
	<script type="text/javascript">
		$(function () {
			var table = $('.data-table').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('emailcase.index') }}",
				columns: [
					{data: 'DT_RowIndex', name: 'DT_RowIndex'},
					{data: 'ref_no', name: 'ref_no'},
					{data: 'company_sender', name: 'company_sender'},
					{data: 'person_sender', name: 'person_sender'},
					{data: 'company_receiver', name: 'company_receiver'},
					{data: 'person_receiver', name: 'person_receiver'},
					{data: 'details', name: 'details'},
					{data: 'value_details', name: 'value_details'},
					{data: 'send_at', name: 'send_at'},
					{data: 'action', name: 'action', orderable: false, searchable: false},
				]
			});
		});

	</script>


    @endauth
@endsection


