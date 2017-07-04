<div id="movies_gallery" class="container" >
    @if ($active == 1) 
        <div id="Clients-div">
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
        </div>    
    @endif
    
	@foreach ($clients as $client)
        @if ($active == 0)
    		<div class="col-md-4 text-center" clientid='{{$client->client_id}}'>
    			<div class="container-fluid well">
                    <br>
                    <h3>{{ $client->email }}</h3    >
                    <br>
                        <button class="btn btn-primary" clientid='{{$client->client_id}}' activate="client" >Activate</button>
                        <button class="btn btn-danger" clientid='{{$client->client_id}}' delete="client" >Delete</button>    
                </div>

        	</div>
        @endif
    @endforeach
</div>
<div>
	{{ $clients->links() }}
</div>
