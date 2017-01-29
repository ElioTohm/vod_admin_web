<div id="series_gallery" class="container" >
	@foreach ($series as $serie)
		<div class="col-md-4 text-center" imdbID='{{$serie->serie_id}}'>
			<div class="container-fluid well">
                <br>
                <h3>{{ $serie->email }}</h3    >
                <br>
                <button class="btn btn-danger" imdbID='{{$serie->serie_id}}' delete="serie" >Delete</button>    
            </div>
    	</div>
    @endforeach
</div>
<div>
	{{ $series->links() }}
</div>
