@extends('admin.layouts.admin')

@section('page-title','Dashboard')
@section('heading','Dashboard')
@section('breadcrumbs', 'Dashboard')

@section('content')
	<div class="card" id="section-overview">
		<div class="card-body">
			<form method="post" action="#" name="form-battery" id="form-battery" class="form-horizontal">
				@csrf
				<div class="form-group row">

					<div class="col-md-4">

						<label><strong>Battery Name:</strong></label>
						<select name="battery_id[]" multiple data-placeholder="Select Battery"
						        class="form-control select2 batteries"></select>
					</div>
					<div class="col-md-4">
						<label
							for="status">Status:</label>
						<select id="status" name="status" class="form-control select2">
							<option value="Good">Good</option>
							<option value="Bad">Bad</option>
							<option value="Charging">Charging</option>
						</select>
					</div>
					<div class="col-md-4">

						<label><strong>Remarks:</strong></label>
						<input name="remarks" placeholder="i.e. remarks"
						       class="form-control remarks"></input>
					</div>

					<div class="col-md-4">

						<label><strong>Issue By:</strong></label>
						<select name="issued_by" data-placeholder="Select Issued By"
						        class="form-control select2 issued_by"></select>
					</div>
					<div class="col-md-4">

						<label><strong>Issue To:</strong></label>
						<select name="issued_to" data-placeholder="Select Issued To"
						        class="form-control select2 issued_to"></select>
					</div>
				</div>
				<div class="box-footer text-right">
					<div class="btn-group">
						<input type="button" onclick="submitForm()" id="form-submit" name="form-submit" class="btn btn-primary"
						       form="form-battery"
						       value="Issue">
						<input type="reset" name="form-reset" id="form-reset" class="btn btn-default" form="form-battery">
					</div>
				</div>

			</form>

			<br>

		</div>
		<br>
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

				</table>
			</div>

		</div>
		<br>
		<div class="card-body">
			<h3>Batteries Counting</h3>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover" id="table-counting">
					<thead>
					<tr>
						<th>Total</th>
						<th>In Camp</th>
						<th>In Field</th>
						<th>Not Issued</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td><a href="{{route('admin.batteries')}}">{{$total}}</a></td>
						<td><a href="{{route('camp')}}">{{$camp}}</a></td>
						<td><a href="{{route('field')}}">{{$field}}</a></td>
						<td><a href="{{route('not')}}">{{$notIssued}}</a></td>

					</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
@endsection
@include('plugins.ajax')
@include('plugins.DataTables')
@include('plugins.select2')

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
		 ],
			 ajax: {
				 url: "{{route('dashboard.ajax')}}",
				 type: 'post'
			 },
			 columns: [
				 { data: 'DT_RowIndex' }, // Add index column
				 { data: 'date', searchable: false },
				 { data: 'battery' },
				 { data: 'issued_by' },
				 { data: 'issued_to' },
				 { data: 'remarks' },
				 { data: 'status' },
			 ]
		 })

		 $('body').addClass('sidebar-xs')

		 $('.batteries').select2({
			 ajax: {
				 url: "{{route('select2.batteries')}}",
				 type: 'post',
				 data: function (params) {
					 return {
						 term: params.term
					 }
				 }
			 },
		 })

		 $('.issued_by,.issued_to').select2({
			 ajax: {
				 url: "{{route('select2.employee')}}",
				 type: 'post',
				 data: function (params) {
					 return {
						 term: params.term
					 }
				 }
			 },
		 })
		 
		 var option = new Option('FAUJI CAMP', 51, true, true)
		 $('.issued_by, .issued_to').append(option).trigger('change')
	 })

	 function batteryClick (id) {
		 $.ajax({
			 url: '{{route('batteries.getData')}}',
			 type: 'post',
			 dataType: 'json',
			 data: { battery_id: id },
			 success: function (res) {
				 if (res.status === 'ok') {
					 $('.batteries').empty().trigger('change')
					 $('.issued_by').empty().trigger('change')
					 $('#status').val('').trigger('change')
					 $('.remarks').val('')

					 let data = res.data
					 if (data.batteries) {
						 var $option = $('<option></option>')
							.attr('value', data.batteries.id)
							.text(data.batteries.name)
							.prop('selected', true)
						 $('.batteries').append($option).change()
					 }

					 if (data.issued_by) {
						 let editIssued = new Option(data.issued_by.name, data.issued_by.id, false, false)
						 $('.issued_by').append(editIssued).trigger('change')
					 }
					 $('#status').val(data.status).trigger('change')
					 return true
				 }
				 $('#form-submit').removeAttr('disabled')
				 ui.errorMessage(res.message)
			 },
			 error: function (res) {
				 $('#form-submit').removeAttr('disabled')
				 ui.ajaxError(res)
			 }
		 })
	 }

	 $('#form-reset').on('click', function (e) {
		 e.preventDefault()
		 $('.batteries').empty().trigger('change')
		 $('#status').val('Good').trigger('change')
		 $('.remarks').val('')

		 var option = new Option('FAUJI CAMP', 51, true, true)
		 $('.issued_by, .issued_to').append(option).trigger('change')

	 })

	 function submitForm () {
		 $('#form-submit').attr('disabled', true).html('Wait...')
		 let $form = $('#form-battery')
		 $.ajax({
			 url: '{{route('dashboard.save')}}',
			 type: 'post',
			 dataType: 'json',
			 data: $form.serialize(),
			 success: function (res) {
				 if (res.status === 'ok') {
					 ui.successMessage(res.message)
					 $form[0].reset()
					 $('.issued_by').val('').trigger('change')
					 $('.issued_to').val('').trigger('change')
					 $('.batteries').val('').trigger('change')
					 $('#status').val('Good').trigger('change')
					 table.api().ajax.reload(null, false)
					 var option = new Option('FAUJI CAMP', 51, true, true)
					 $('.issued_by, .issued_to').append(option).trigger('change')

					 $('#form-submit').removeAttr('disabled')
					 return true
				 }
				 $('#form-submit').removeAttr('disabled')
				 ui.errorMessage(res.message)
			 },
			 error: function (res) {
				 $('#form-submit').removeAttr('disabled')
				 ui.ajaxError(res)
			 }
		 })
	 }


	</script>
@endpush()