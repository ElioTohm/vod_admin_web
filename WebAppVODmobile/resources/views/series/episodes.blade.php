@extends('layouts.app')

@extends('navbar.navbar')

@section('episodesdetails')
<div id="main" class="container main">
	<h1> {{$serie->Title}} </h1>
	<button id="updatemovie_btn" class="pull-right btn btn-success" imdbID="{{$serie->imdbID}}">Update</button>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<img src="{{$serie->Poster}}">
				</div>
				<br>
				<div class="row">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddEpisodes_modal">Add episodes</button>	
				</div>
			</div>
			<div class="col-md-8">
			<br>
				<form action="{{url('/updateseries')}}" method="post"  class="form-horizontal" role="form" name="form_addCustomMovie">
					{{ csrf_field() }}
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					<div class="form-group">
						<label for="ID" class="col-sm-1 control-label">ID</label>
						<div class="col-sm-5">
							<input class="form-control" id="ID" name="ID" type="text" value="{{$serie->imdbID}}" placeholder="Custom ID for the serie" required>
						</div>
						<label for="Title" class="col-sm-1 control-label">Title</label>
						<div class="col-sm-5">
							<input class="form-control" id="Title" name="Title" type="text" value="{{$serie->Title}}" placeholder="Title" required>
						</div>
					</div>
					<div class="form-group">
						<label for="Year" class="col-sm-1 control-label">Year</label>
						<div class="col-sm-5">
							<input class="form-control" id="Year" name="Year" type="number" value="{{$serie->Year}}" placeholder="Year" >
						</div>
						<label for="Ratings" class="col-sm-1 control-label">Ratings</label>
						<div class="col-sm-5">
							<input class="form-control" id="Ratings" name="Ratings" type="text" value="{{$serie->Rated}}" placeholder="Ratings" >
						</div>
					</div>
					<div class="form-group">
						<label for="Released" class="col-sm-1 control-label">Released</label>
						<div class="col-sm-5">
							<input class="form-control" id="Released" name="Released" type="date" value="{{$serie->Released}}" placeholder="Released" >
						</div>
						<label for="Runtime" class="col-sm-1 control-label">Runtime</label>
						<div class="col-sm-5">
							<input class="form-control" id="Runtime" name="Runtime" type="text" value="{{$serie->Runtime}}" placeholder="Runtime" >
						</div>
					</div>
					<div class="form-group">
						<label for="Director" class="col-sm-1 control-label">Director</label>
						<div class="col-sm-5">
							<input class="form-control" id="Director" name="Director" type="text" value="{{$serie->Director}}" placeholder="Director" >
						</div>
						<label for="Writer" class="col-sm-1 control-label">Writer</label>
						<div class="col-sm-5">
							<input class="form-control" id="Writer" name="Writer" type="text" value="{{$serie->Writer}}" placeholder="Writer" >
						</div>
					</div>
					<div class="form-group">
						<label for="Actors" class="col-sm-1 control-label">Actors</label>
						<div class="col-sm-5">
							<input class="form-control" id="Actors" name="Actors" type="text" value="{{$serie->Actors}}" placeholder="Actors" >
						</div>
						<label for="Awards" class="col-sm-1 control-label">Awards</label>
						<div class="col-sm-5">
							<input class="form-control" id="Awards" name="Awards" type="text" value="{{$serie->Awards}}" placeholder="Country" >
						</div>
					</div>
					<div class="form-group">
						<label for="Language" class="col-sm-1 control-label">Language</label>
						<div class="col-sm-5">
							<input class="form-control" id="Language" name="Language" type="text" value="{{$serie->Language}}" placeholder="Language" >
						</div>
						<label for="Country" class="col-sm-1 control-label">Country</label>
						<div class="col-sm-5">
							<input class="form-control" id="Country" name="Country" type="text" value="{{$serie->Country}}" placeholder="Country" >
						</div>
					</div>
					<div class="form-group">
						<label for="Stream" class="col-sm-1 control-label">Stream</label>
						<div class="col-sm-5">
							<input class="form-control" id="Stream" name="Stream" type="text" value="{{$serie->stream}}" placeholder="Stream" required>
						</div>
						<label for="Poster"   class="col-sm-1 control-label">Poster</label>
						<div class="col-sm-5">
							<input class="form-control" id="Poster" name="Poster" type="url" value="{{$serie->Poster}}" placeholder="Country" >
						</div>
					</div>
					<div class="form-group">
						<label for="Plot" class="col-sm-1 control-label">Plot</label>
						<div class="col-sm-11">
							<textarea class="form-control" rows="5" id="Plot" name="Plot">{{$serie->Plot}}</textarea>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div>
			@include('series.episodes_list')
		</div>
	</div>
</div>
@endsection

@section('episodes')
<!-- Modal -->
<div class="modal fade" id="AddEpisodes_modal" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Add an Episode</h4>
	    </div>
	    <div class="modal-body">
	      	<form action="{{url('/episodes')}}" method="post" class="form-horizontal" role="form" name="form_addEpisode">
		      	{{ csrf_field() }}
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
		      		<label for="imdbID" class="col-sm-2 control-label">Episode IMDB id</label>
			      	<div class="col-sm-10">
			    	    <input class="form-control" id="imdbID" name="imdbID" type="text" placeholder="imDB id">
				    </div>
			    </div>
			    <div class="form-group">
		      		<label for="stream" class="col-sm-2 control-label">Episode File</label>
			      	<div class="col-sm-10">
			    	    <input class="form-control" id="stream" name="stream" type="text" placeholder="Episode file">
				    </div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	      <button type="button" id ="btn_addEpisode" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>

<script src= {{ url("/js/episode.js") }} ></script>
@endsection