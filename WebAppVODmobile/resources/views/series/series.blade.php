@extends('layouts.app')

@extends('navbar.navbar')

@section('series_list')
<div id="main" class="container main">
	@include('series.series_list')
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddSerie_modal">Add a Serie</button>
</div>
@endsection
@section('series')
<!-- Modal -->
<div class="modal fade" id="AddSerie_modal" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
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
	    <input type="submit" name="submit">
			    
			</form>
	    </div>
	    <div class="modal-footer">
	      <button type="button" id ="btn_addSerie" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>

<script src= {{ url("/js/series.js") }} ></script>
@endsection