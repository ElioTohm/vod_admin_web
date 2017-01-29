<div id="movies_gallery" class="container" >
	@foreach ($clients as $client)
		<div class="col-md-4 text-center" clientid='{{$client->client_id}}'>
			<div class="container-fluid well">
                <br>
                <h3>{{ $client->email }}</h3    >
                <br>
                @if ($active == 0) 
                <button class="btn btn-primary" clientid='{{$client->client_id}}' activate="client" >Activate</button>
                @else
                <button class="btn btn-warning" clientid='{{$client->client_id}}' deactivate="client" >Deactivate</button>
                @endif
                <button class="btn btn-danger" clientid='{{$client->client_id}}' delete="client" >Delete</button>    
            </div>
    	</div>
    @endforeach
</div>
<div>
	{{ $clients->links() }}
</div>
