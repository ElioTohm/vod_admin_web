@extends('layouts.app')

@extends('navbar.navbar')


@section('movie_list')
<div id="main" class="container main">
    @include('movie.movie_list')
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddMovie_modal">Add movie</button>
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
	      <h4 class="modal-title">Add a Movie</h4>
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
			        	<input class="form-control" id="stream" name="stream" type="text" placeholder="stream location" >
		      		</div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	      <button type="button" id ="btn_addMovie" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>

<script src="/js/movies.js"></script>
@endsection