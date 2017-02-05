@extends('layouts.app')

@extends('navbar.navbar')

@section('series_list')
<div id="main" class="container main">
	<div>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddSerie_modal">Add a Serie with imdb</button>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddSerie_custom_modal">Add a custom Serie</button>
	</div>
	<br>
	<div>
		@include('series.series_list')	
	</div>
</div>
@endsection

@section('series')
<!-- Modal -->
<div class="modal fade" id="AddSerie_modal" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">WW
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Add a Serie</h4>
	    </div>
	    <div class="modal-body">
	      	<form action="{{url('/series')}}" method="post" class="form-horizontal" role="form" name="form_addSerie">
	      		{{ csrf_field() }}
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
		      		<label for="imdbID" class="col-sm-2 control-label">Serie IMDB id</label>
			      	<div class="col-sm-10">
			    	    <input class="form-control" id="imdbID" name="imdbID" type="text" placeholder="imDB id">
				    </div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
	      	<button type="button" id ="btn_addSerie" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="AddSerie_custom_modal" role="dialog">
	<div class="modal-dialog modal-lg">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Add a Serie with custom input</h4>
	    </div>
	    <div class="modal-body">
	      	<form action="{{url('/customseries')}}" method="post"  class="form-horizontal" role="form" name="form_addCustomSerie">
			    {{ csrf_field() }}
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				<div class="form-group">
		      		<label for="Title" class="col-sm-1 control-label">Title</label>
		      		<div class="col-sm-10">
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
			        	<input class="form-control" id="Awards" name="Awards" type="text" placeholder="Country" >
		      		</div>
		      		<label for="Poster" class="col-sm-1 control-label">Poster</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Poster" name="Poster" type="url" placeholder="Country" >
		      		</div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
      		<button type="button" id ="btn_addCustomSerie" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>

<script src= {{ url("/js/series.js") }} ></script>
@endsection