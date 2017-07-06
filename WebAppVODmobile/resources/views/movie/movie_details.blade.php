@extends('layouts.app')



@section('movie_detail')

<div id="main" class="container main">
	<h1>{{$movie->Title}}</h1>
	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
	<button id="updatemovie_btn" class="pull-right btn btn-success" Movieid='{{$movie->id}}' imdbID="{{$movie->imdbID}}">Update</button>
	<div class="container">
		<div class="row">
			<dir class="col-md-4">
				<img class="movie-poster-detail" src="{{$movie->Poster}}">
			</dir>
			<dir class="col-md-8">
				<div class="form-horizontal" role="form" name="form_addCustomMovie">
					
					<div class="form-group">
						<label for="Title" class="col-sm-1 control-label">Title</label>
						<div class="col-sm-5">
							<input class="form-control" id="Title" name="Title" type="text" value="{{$movie->Title}}" placeholder="Title" required>
						</div>
						<label for="Genre" class="col-sm-1 control-label">Genre</label>
						<div class="col-sm-5">
							<select class="js-example-basic-multiple" multiple="multiple" style="width: 100%" placeholder="{{$movie->Genre}}">
								@foreach ($allgenres as $genre) 
									<option>{{$genre->genre_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="subtitle" class="col-sm-1 control-label">Subtitle</label>
			      		<div class="col-sm-5">
			      			<input class="form-control" id="Subname" type="text" class="control-label" value="{{$movie->Subtitle}}">
				        	<input class="form-control" id="Subtitle" name="subtitle" type="file" placeholder="Subtitle" value="{{$movie->Subtitle}}">
			      		</div>
						<label for="Stream" class="col-sm-1 control-label">Stream</label>
						<div class="col-sm-5">
							<label class="control-label">{{$movie->stream}}</label>
							<input id="Stream" name="Stream" type="file" value="{{$movie->stream}}" placeholder="Stream" required>
						</div>
					</div>
					<div class="form-group">
						<label for="Year" class="col-sm-1 control-label">Year</label>
						<div class="col-sm-5">
							<input class="form-control" id="Year" name="Year" type="number" value="{{$movie->Year}}" placeholder="Year" >
						</div>
						<label for="Ratings" class="col-sm-1 control-label">Rated</label>
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
						<label for="Poster"   class="col-sm-1 control-label">Poster URL</label>
						<div class="col-sm-5">
							<input class="form-control" id="Poster" name="Poster" type="url" value="{{$movie->Poster}}" placeholder="Country" >
						</div>
						<form action="{{url('/uploadMoviePoster')}}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
							<input type="hidden" value="{{$movie->id}}" name="movieid">
							<label for="PosterUpload" class="col-sm-1 control-label">Poster Upload</label>
							<div class="col-sm-5">
								<input class="form-control" id="PosterUpload" name="PosterUpload" type="file" value="{{$movie->Poster}}" placeholder="Country" >
								<input type="submit" value="Upload Poster" class="btn btn-primary brn-small" name="">
							</div>	
						</form>
					</div>
					<div class="form-group">
						<label for="Plot" class="col-sm-1 control-label">Plot</label>
						<div class="col-sm-11">
							<textarea class="form-control" rows="5" id="Plot" name="Plot">{{$movie->Plot}}</textarea>
						</div>
					</div>
				</div>
			</dir>
		</div>
	</div>
	
	
</div>

<link href="{{url('css/select2.min.css')}}" rel="stylesheet" />
<script src="{{url('js/select2.min.js')}}"></script>
<script src="{{ url('/js/movies.js')}} "></script>
<script type="text/javascript">
	$(".js-example-basic-multiple").select2().val(
			[
				@foreach($genres as $genre)
					"{{$genre->genre_name}}",	
				@endforeach
			]
		).trigger("change");
</script>
@endsection