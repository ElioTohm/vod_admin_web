@extends('layouts.app')

@section('clients')
<div id="main" class="container main">
	@include('clients.clients_list')	
</div>
<script src="{{ url('/js/clients.js') }}"></script>
@endsection