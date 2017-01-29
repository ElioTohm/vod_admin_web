<div id="series_gallery" class="container" >
	@foreach ($series as $serie)
		<div class="col-md-4 text-center" imdbID='{{$serie->imdbID}}'>
			<div class="container-fluid well">
                <br>
                <a href="/seriesDetail/{{$serie->imdbID}}">
                    <img src="{{$serie->Poster}}">    
                </a>
                <br>
                <h3>{{ $serie->Title }}</h3>
                <br>
                <button class="btn btn-danger" imdbID='{{$serie->imdbID}}' delete="serie" >Delete</button>    
            </div>
    	</div>
    @endforeach
</div>
<div>
	{{ $series->links() }}
</div>
