@extends('layouts.app')

@extends('navbar.navbar')

@section('clients')
<div id="main" class="container main">
	@include('clients.clients_list')
	<div id="Clients-div">
		<passport-clients></passport-clients>
		<passport-authorized-clients></passport-authorized-clients>
		<passport-personal-access-tokens></passport-personal-access-tokens>	
	</div>
	
</div>
<script src="/js/clients.js"></script>
@endsection