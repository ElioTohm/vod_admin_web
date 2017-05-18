@extends('layouts.app')

@extends('navbar.navbar')


@section('clip_list')
<div id="main" class="container main">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<img class="movie-poster-detail" src="/videos/clips_posters/{{ $artist->image }}">
				</div>
				<br>
				<div class="row">
					<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddClip_custom_modal">Add clip</button>
					<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddClip_Multiple_modal">Add Multiple Clips</button>
				</div>
			</div>
			<br>
			<div class="col-md-8">
				@include('clips.clips_list')		
			</div>
		</div>
	</div>
</div>
@endsection

@section('clips')
<div class="modal fade" id="AddClip_Multiple_modal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Add Multiple clips for {{ $artist->name }} </h4>
	    </div>
	    <div class="modal-body">
				<form action="{{url('/customclips')}}" method="post"  class="form-horizontal" role="form" name="form_AddClip_Multiple">
			    {{ csrf_field() }}
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					<div class="form-group">
							<label for="Stream" class="col-sm-1 control-label">Stream</label>
							<div class="col-sm-11">
								<input class="form-control" id="MultiStream" name="Stream" type="file" placeholder="select all files you want to ass" multiple required>
							</div>
					</div>
			</form>
	    </div>
	    <div class="modal-footer">
	    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
      		<button artist_id="{{ $artist->id }}" type="button" id ="btn_UpdateMultiClip" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="AddClip_custom_modal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Add a Clip </h4>
	    </div>
	    <div class="modal-body">
				<form action="{{url('/customclips')}}" method="post"  class="form-horizontal" role="form" name="form_addCustomClip">
						{{ csrf_field() }}
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					<div class="form-group">
						<label for="Title" class="col-sm-1 control-label">Title</label>
						<div class="col-sm-11">
							<input class="form-control" id="Title" name="Title" type="text" placeholder="Title" required>
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
				</form>
	    </div>
	    <div class="modal-footer">
	    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
      		<button artist_id="{{ $artist->id }}" type="button" id ="btn_addCustomClip" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="UpdateClip_custom_modal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Update Clip </h4>
	    </div>
	    <div class="modal-body">
	      	<form action="{{url('/customclips')}}" method="post"  class="form-horizontal" role="form" name="form_UpdateCustomClip">
			    {{ csrf_field() }}
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					<div class="form-group">
						<label for="Title" class="col-sm-1 control-label">Title</label>
						<div class="col-sm-5">
							<input class="form-control" id="Titleupdate" name="Title" type="text" placeholder="Title" required>
						</div>
						<label for="Artist" class="col-sm-1 control-label">Artist</label>
						<div class="col-sm-5">
							<select class="js-example-basic-single" style="width: 100%" placeholder="{{$artist->name}}">
								@foreach ($allartists as $artist) 
									<option value={{$artist->id}}>{{$artist->name}}</option>
								@endforeach
							</select>
						</div>
			    </div>
			    <div class="form-group">
		      		<label for="Stream" class="col-sm-1 control-label">Stream</label>
		      		<div class="col-sm-8">
			    		<input class="form-control" type="text" id="Streamupdatetxt" >
			    	</div>
		      		<div class="col-sm-3">
			        	<input class="form-control" id="Streamupdate" name="Stream" type="file" placeholder="Stream" >
		      		</div>
			    </div>
			    <div class="form-group">
			    	<label  class="col-sm-1 control-label">Subtitle</label>
			    	<div class="col-sm-8">
			    		<input class="form-control" type="text" id="Subtitle2updatetxt" >
			    	</div>
		      		<div class="col-sm-3">
			        	<input artist_id="{{ $artist->id }}" class="form-control" id="Subtitle2update" type="file" placeholder="subtitle location" >
		      		</div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
      		<button artist_id="{{ $artist->id }}" type="button" id ="btn_UpdateCustomClip" class="btn btn-primary">Update</button>
	    </div>
	  </div>
	</div>
</div>

<link href="{{url('/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{url('/js/select2.min.js')}}"></script>
<script src="{{ url('/js/clips.js')}} "></script>
@endsection


