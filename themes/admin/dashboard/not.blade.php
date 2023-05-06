@extends('admin.layouts.admin')

@section('page-title','Total Batteries')
@section('heading','Total Batteries')
@section('breadcrumbs', 'Total Batteries')

@section('content')

	<div class="card" id="section-overview">
		<div
			class="card-header bg-teal-400 header-elements-inline">
			<h6 class="card-title">Not Issue Batteries</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover" id="table-batteries">
					<thead>
					<tr>
						<th>Sr#</th>
						<th>Battery</th>
					</tr>
					</thead>
					<tbody>
					@foreach($data as $d)

						<tr>
							<th>{{$loop->iteration}}</th>
							<th>{{$d->name}}</th>
						</tr>

					@endforeach
					</tbody>
				</table>
			</div>

		</div>
	</div>
@endsection
@include('plugins.DataTables')

@push('footer')

	<script>


	 let table = $('#table-batteries')
	 $(document).ready(function () {
		 table.dataTable({
			 autoWidth: true,
			 ordering: false,
		 dom: 'Bfrtip',
		 buttons: [
			 'copy', 'csv', 'excel', 'pdf', 'print'
		 ]
		 })
	 })


	</script>
@endpush()