@extends('layouts.app')

@extends('navbar.navbar')


@section('movie_list')
<div id="main" class="container main">
	<div>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddMovie_modal">Add movie with imdbID</button>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddMovie_custom_modal"W>Add movie with custom input</button>
	</div>
	<br>
	<div>
		@include('movie.movie_list')	
	</div>
</div>
@endsection

@section('movies')
<!-- Modal -->
<div class="modal fade" id="AddMovie_modal" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Add a Movie with imdb</h4>
	    </div>
	    <div class="modal-body">
	      	<form action="{{url('movies')}}" method="post"  class="form-horizontal" role="form" name="form_addMovie">
			    {{ csrf_field() }}
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				<div class="form-group">
		      		<label for="imdbID" class="col-sm-2 control-label">Movie IMDB id</label>
			      	<div class="col-sm-10">
			    	    <input class="form-control" id="imdbID" name="imdbID" type="text" placeholder="imDB id">
				    </div>
			    </div>
			    <div class="form-group">
		      		<label for="stream" class="col-sm-2 control-label">Stream</label>
		      		<div class="col-sm-10">
			        	<input class="form-control" id="stream" name="stream" type="file" placeholder="stream location" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Storage" class="col-sm-1 control-label">Storage</label>
		      		<div class="col-sm-5">
			        	<select id="storage">
			        		<option value="1">1</option>
			        		<option value="2">2</option>
			        	</select>
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="subtitle" class="col-sm-2 control-label">Subtitle</label>
		      		<div class="col-sm-10">
			        	<input class="form-control" id="Subtitle" name="subtitle" type="file" placeholder="subtitle location" >
		      		</div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
        <img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
        <button type="button" id ="btn_addMovie" class=" btn btn-primary">
	      	Add
      	</button>
	    </div>
	  </div>
	  
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="AddMovie_custom_modal" role="dialog">
	<div class="modal-dialog modal-lg">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Add a Movie with custom input</h4>
	    </div>
	    <div class="modal-body">
	      	<form action="{{url('/custommovies')}}" method="post"  class="form-horizontal" role="form" name="form_addCustomMovie">
			    {{ csrf_field() }}
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				<div class="form-group">
		      		<label for="Title" class="col-sm-1 control-label">Title</label>
		      		<div class="col-sm-11">
			        	<input class="form-control" id="Title" name="Title" type="text" placeholder="Title" required>
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Year" class="col-sm-1 control-label">Year</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Year" name="Year" type="number" placeholder="Year" >
		      		</div>
		      		<label for="Ratings" class="col-sm-1 control-label">Ratings</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Ratings" name="Ratings" type="text" placeholder="Ratings" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Released" class="col-sm-1 control-label">Released</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Released" name="Released" type="date" placeholder="Released" >
		      		</div>
		      		<label for="Runtime" class="col-sm-1 control-label">Runtime</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Runtime" name="Runtime" type="text" placeholder="Runtime" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Director" class="col-sm-1 control-label">Director</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Director" name="Director" type="text" placeholder="Director" >
		      		</div>
		      		<label for="Writer" class="col-sm-1 control-label">Writer</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Writer" name="Writer" type="text" placeholder="Writer" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Actors" class="col-sm-1 control-label">Actors</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Actors" name="Actors" type="text" placeholder="Actors" >
		      		</div>
		      		<label for="Plot" class="col-sm-1 control-label">Plot</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Plot" name="Plot" type="text" placeholder="Plot" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Language" class="col-sm-1 control-label">Language</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Language" name="Language" type="text" placeholder="Language" >
		      		</div>
		      		<label for="Country" class="col-sm-1 control-label">Country</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Country" name="Country" type="text" placeholder="Country" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Awards" class="col-sm-1 control-label">Awards</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Awards" name="Awards" type="text" placeholder="Awards" >
		      		</div>
		      		<label for="Poster" class="col-sm-1 control-label">Poster</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Poster" name="Poster" type="url" placeholder="Poster URL" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Stream" class="col-sm-1 control-label">Stream</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Stream" name="Stream" type="file" placeholder="Stream" required>
		      		</div>
		      		<label for="subtitle" class="col-sm-1 control-label">Subtitle</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Subtitle2" name="subtitle" type="file" placeholder="subtitle location" >
		      		</div>
			    </div>
			    <div class="form-group">
		      		<label for="Storage" class="col-sm-1 control-label">Storage</label>
		      		<div class="col-sm-5">
			        	<select id="storage">
			        		<option value="1">1</option>
			        		<option value="2">2</option>
			        	</select>
		      		</div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
      		<button type="button" id ="btn_addCustomMovie" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>



<script src="{{ url('/js/movies.js')}} "></script>
@endsection


