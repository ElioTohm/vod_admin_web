@extends('layouts.app')

@section('clients')
<div id="main" class="container main">

	<clientcardview v-bind:clients='{!! collect($clients->items())->toJson() !!}' 
					:currentpage="{!! $clients->currentPage() !!}"></clientcardview>
					
	{{ $clients->links() }}
	
</div>

@endsection