<div id="movies_gallery" class="container" >
	@foreach ($clients as $client)
		<div class="col-md-4 well text-center " clientid='{{$client->client_id}}'>
			<br>
        	<h3>{{ $client->email }}</h3	>
        	<br>
        	<button class="btn btn-primary" clientid='{{$client->client_id}}' activate="client" >Activate</button>
        	<button class="btn btn-danger" clientid='{{$client->client_id}}' delete="client" >Delete</button>
    	</div>
    @endforeach
</div>
<div>
	{{ $clients->links() }}
</div>
