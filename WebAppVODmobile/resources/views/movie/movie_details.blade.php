@extends('layouts.app')

@extends('navbar.navbar')

@section('movie_detail')
<div id="main" class="container main">
	<h1>{{$movie->Title}}</h1>
	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
	<button id="updatemovie_btn" class="pull-right btn btn-success" imdbID="{{$movie->imdbID}}">Update</button>
	<div class="container">
		<div class="row">
			<dir class="col-md-4">
				<img class="movie-poster" src="{{$movie->Poster}}">
			</dir>
			<dir class="col-md-8">
				<form action="{{url('/updatemovies')}}" method="post"  class="form-horizontal" role="form" name="form_addCustomMovie">
					{{ csrf_field() }}
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					<div class="form-group">
						<label for="ID" class="col-sm-1 control-label">ID</label>
						<div class="col-sm-5">
							<input class="form-control" id="ID" name="ID" type="text" value="{{$movie->imdbID}}" placeholder="Custom ID for the movie" required>
						</div>
						<label for="Title" class="col-sm-1 control-label">Title</label>
						<div class="col-sm-5">
							<input class="form-control" id="Title" name="Title" type="text" value="{{$movie->Title}}" placeholder="Title" required>
						</div>
					</div>
					<div class="form-group">
						<label for="Year" class="col-sm-1 control-label">Year</label>
						<div class="col-sm-5">
							<input class="form-control" id="Year" name="Year" type="number" value="{{$movie->Year}}" placeholder="Year" >
						</div>
						<label for="Ratings" class="col-sm-1 control-label">Ratings</label>
						<div class="col-sm-5">
							<input class="form-control" id="Ratings" name="Ratings" type="text" value="{{$movie->Rated}}" placeholder="Ratings" >
						</div>
					</div>
					<div class="form-group">
						<label for="Released" class="col-sm-1 control-label">Released</label>
						<div class="col-sm-5">
							<input class="form-control" id="Released" name="Released" type="date" value="{{$movie->Released}}" placeholder="Released" >
						</div>
						<label for="Runtime" class="col-sm-1 control-label">Runtime</label>
						<div class="col-sm-5">
							<input class="form-control" id="Runtime" name="Runtime" type="text" value="{{$movie->Runtime}}" placeholder="Runtime" >
						</div>
					</div>
					<div class="form-group">
						<label for="Director" class="col-sm-1 control-label">Director</label>
						<div class="col-sm-5">
							<input class="form-control" id="Director" name="Director" type="text" value="{{$movie->Director}}" placeholder="Director" >
						</div>
						<label for="Writer" class="col-sm-1 control-label">Writer</label>
						<div class="col-sm-5">
							<input class="form-control" id="Writer" name="Writer" type="text" value="{{$movie->Writer}}" placeholder="Writer" >
						</div>
					</div>
					<div class="form-group">
						<label for="Actors" class="col-sm-1 control-label">Actors</label>
						<div class="col-sm-5">
							<input class="form-control" id="Actors" name="Actors" type="text" value="{{$movie->Actors}}" placeholder="Actors" >
						</div>
						<label for="Awards" class="col-sm-1 control-label">Awards</label>
						<div class="col-sm-5">
							<input class="form-control" id="Awards" name="Awards" type="text" value="{{$movie->Awards}}" placeholder="Country" >
						</div>
					</div>
					<div class="form-group">
						<label for="Language" class="col-sm-1 control-label">Language</label>
						<div class="col-sm-5">
							<input class="form-control" id="Language" name="Language" type="text" value="{{$movie->Language}}" placeholder="Language" >
						</div>
						<label for="Country" class="col-sm-1 control-label">Country</label>
						<div class="col-sm-5">
							<input class="form-control" id="Country" name="Country" type="text" value="{{$movie->Country}}" placeholder="Country" >
						</div>
					</div>
					<div class="form-group">
						<label for="Stream" class="col-sm-1 control-label">Stream</label>
						<div class="col-sm-5">
							<input class="form-control" id="Stream" name="Stream" type="text" value="{{$movie->stream}}" placeholder="Stream" required>
						</div>
						<label for="Poster"   class="col-sm-1 control-label">Poster</label>
						<div class="col-sm-5">
							<input class="form-control" id="Poster" name="Poster" type="url" value="{{$movie->Poster}}" placeholder="Country" >
						</div>
					</div>
					<div class="form-group">
						<label for="Plot" class="col-sm-1 control-label">Plot</label>
						<div class="col-sm-11">
							<textarea class="form-control" rows="5" id="Plot" name="Plot">{{$movie->Plot}}</textarea>
						</div>
					</div>
				</form>
			</dir>
		</div>
	</div>
	
	
</div>


<script src="{{ url('/js/movies.js')}} "></script>
@endsection