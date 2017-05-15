@extends('layouts.app')

@extends('navbar.navbar')

@section('content')
<div id="main" class="container main">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddArtists_modal">Add Artist</button>
			</div>
		</div>
	</div>
	<br>
	<div class="container" >
		@foreach ($artists as $artist)
			<div class="col-md-4 text-center" id="{{$artist->id}}">
				<div class="container-fluid well movie-container">
					<br>
					<a href="/clips/{{$artist->id}}">
						<img class="movie-poster" src="/videos/clips_posters/{{ $artist->image}}">    
					</a>
					<br>
					<h3>{{ $artist->name }}</h3>
					<br>
					<button id="{{$artist->id}}" class="btn btn-primary " data-toggle="modal" data-target="#UpdateArtists_modal">Update</button>
					<button id="{{$artist->id}}" class="btn btn-danger ">Delete</button>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="AddArtists_modal" role="dialog">
	<div class="modal-dialog">
	  	<!-- Modal content-->
	  	<div class="modal-content">
		    <div class="modal-header">
		      <h4 class="modal-title">Add an Episode</h4>
		    </div>
		    <div class="modal-body">
		      	<div class="form-group">
					<label class="col-sm-1 control-label" for="Artist_Name">Artist</label>
					<div class="col-sm-5">
						<input class="form-control" id="Artist_Name" name="Artist_Name" type="text" placeholder="Artist Name">
					</div>
					<label for="Artist Image" class="col-sm-1 control-label">Image</label>
					<div class="col-sm-5">
						<input class="form-control" id="Artist_Image" name="Artist_Image" type="file" placeholder="Artist Image">
					</div>
				</div>
		    </div>
			<br>
		    <div class="modal-footer">
		    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
		      	<button class='btn btn-primary' id="AddArtist_btn">Add</button>
		    </div>
	  	</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="UpdateArtists_modal" role="dialog">
	<div class="modal-dialog">
	  	<!-- Modal content-->
	  	<div class="modal-content">
		    <div class="modal-header">
		      <h4 class="modal-title">Add an Episode</h4>
		    </div>
		    <div class="modal-body">
		      	<div class="form-group">
					<label class="col-sm-1 control-label" for="Artist_Name">Artist</label>
					<div class="col-sm-5">
						<input class="form-control" id="Update_Artist_Name" name="Artist_Name" type="text" placeholder="Artist Name">
					</div>
					<label for="Artist Image" class="col-sm-1 control-label">Image</label>
					<div class="col-sm-5">
						<input class="form-control" id="Update_Artist_Image" name="Artist_Image" type="file" placeholder="Artist Image">
					</div>
				</div>
		    </div>
			<br>
		    <div class="modal-footer">
		    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
				  <button class='btn btn-primary' id="UpdateArtist_btn" update="{{$artist->id}}">Update</button>
		    </div>
	  	</div>
	</div>
</div>

<script type="text/javascript" src="{{url('/js/artist.js')}}"></script>

@endsection