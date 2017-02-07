<div id="movies_gallery" class="container" >
	@foreach ($movies as $movie)
		<div class="col-md-4 text-center " imdbID='{{$movie->imdbID}}'>
			<div class="container-fluid well movie-container">
				<br>
				<a href="/moviedetails/{{$movie->id}}">
					<img class="movie-poster" src="{{$movie->Poster}}">	
				</a>
				<br>
	        	<h3>{{ $movie->Title }}</h3	>
	        	<br>
	        	<button class="btn btn-danger" imdbID='{{$movie->imdbID}}' delete="movie" >Delete</button>	
			</div>
			
    	</div>
    @endforeach
</div>
<div>
	{!! $movies->links() !!}
</div>
