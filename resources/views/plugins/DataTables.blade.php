@push('head')
	<link rel="stylesheet" href="{{asset('themes/default/DataTables/dataTables.min.css')}}"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"/>

@endpush

@push('footer')

	<script src="{{asset('themes/default/DataTables/dataTables.min.js')}}"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

@endpush
