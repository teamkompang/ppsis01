<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Report Financings PDF</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style type="text/css">
    	.table td, .table th {
    		padding: 3px;
    	}
    </style>
</head>
<body>
	<h3>{{$title}}</h3>
	<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				{{-- <th></th> --}}
				<th>Solicitors Name</th>
				<th>Applicant Name</th>
				<th>Type</th>
				<th>Issue Date</th>
				<th>Details</th>
				<th>Updates by</th>
				<th>Updates at</th>
				<th>Status Comment</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($com_vlo as $comm)
			<tr>
				{{-- <td>{{ ++$i }}</th> --}}
				<td>{{ $comm->Name }}</td>
				<td>{{ $comm->FULLNAME }}</td>
				<td>{{ $comm->description }}</td>
				<td>{{ $comm->issue_date }}</td>
				<td>{{ $comm->details }}</td>
				<td>{{ $comm->pic }}</td>
				<td>{{ \Carbon\carbon::parse($comm->update_date)->format('d/m/Y') }}</td>
				<td>{{ $comm->status_comment }}</td>
			</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</body>
</html>
