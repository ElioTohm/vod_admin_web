@extends('layouts.app')

@extends('navbar.navbar')

@section('clients')
<div id="main" class="container main">
	@include('clients.clients_list')	
</div>
<script src="/js/clients.js"></script>
@endsection