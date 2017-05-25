@extends('layouts.app')

@extends('navbar.navbar')

@section('clients')
<div id="main" class="container main">
	@include('clients.clients_list')
</div>

<passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens>

<script src="/js/clients.js"></script>
@endsection