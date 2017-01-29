@extends('layouts.app')

@extends('navbar.navbar')

@section('episodesdetails')
<div id="main" class="container main">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<img src="{{$serie->Poster}}">
				</div>
				<br>
				<div class="row">
					<button type="button"  id ="btn_addEpisode" class="btn btn-primary" data-toggle="modal" data-target="#AddEpisodes_modal">Add episodes</button>	
				</div>
			</div>
			<div class="col-md-6">
				@include('series.episodes_list')
			</div>
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
	      	<form action="{{url('episode')}}" method="post" class="form-horizontal" role="form" name="form_addSerie">
		      	{{ csrf_field() }}
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
		      		<label for="imdbID" class="col-sm-2 control-label">Episode IMDB id</label>
			      	<div class="col-sm-10">
			    	    <input class="form-control" id="imdbID" name="imdbID" type="text" placeholder="imDB id">
				    </div>
			    </div>
			    <div class="form-group">
		      		<label for="imdbID" class="col-sm-2 control-label">Episode File</label>
			      	<div class="col-sm-10">
			    	    <input class="form-control" id="stream" name="stream" type="text" placeholder="Episode file">
				    </div>
			    </div>
			    <input type="submit" name="submit" / >
			</form>
	    </div>
	    <div class="modal-footer">
	      <button type="button" id ="btn_addSerie" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>

<script src= {{ url("/js/episode.js") }} ></script>
@endsection