@extends('admin.layouts.admin')

@section('page-title','Total Batteries')
@section('heading','Total Batteries')
@section('breadcrumbs', 'Total Batteries')

@section('content')

	<div class="card" id="section-overview">
		<div
			class="card-header bg-teal-400 header-elements-inline">
			<h6 class="card-title">In Field Batteries</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover" id="table-batteries">
					<thead>
					<tr>
						<th>Sr#</th>
						<th>Date</th>
						<th>Battery</th>
						<th>Issued By</th>
						<th>Issued To</th>
						<th>Remarks</th>
						<th>Status</th>
					</tr>
					</thead>
					<tbody>
					@foreach($data as $d)

						<tr>
							<th>{{$loop->iteration}}</th>
							<th>{{\Carbon\Carbon::make($d->created_at)->format('d-M-Y h:i A')}}</th>
							<th>{{$d->battery->name}}</th>
							<th>{{$d->by->name}}</th>
							<th>{{$d->to->name}}</th>
							<th>{{$d->remarks}}</th>
							<th> @if( $d->status == 'Good' )
									<span class="badge bg-success">Good</span>
								@elseif( $d->status == 'Bad' )
									<span class="badge bg-danger">Bad</span>
								@else
									<span class="badge bg-warning">Charging</span>
								@endif</th>
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