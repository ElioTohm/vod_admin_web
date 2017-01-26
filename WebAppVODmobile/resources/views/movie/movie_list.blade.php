<div id="movies_gallery" class="container" >
	@foreach ($movies as $movie)
		<div class="col-md-4 well text-center " imdbID='{{$movie->imdbID}}'>
			<img src="{{$movie->Poster}}">
			<br>
        	<h3>{{ $movie->Title }}</h3	>
        	<br>
        	<button class="btn btn-danger" imdbID='{{$movie->imdbID}}' delete="movie" >Delete</button>
    	</div>
    @endforeach
</div>
<div>
	{{ $movies->links() }}
</div>
