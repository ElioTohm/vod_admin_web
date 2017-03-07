@extends('layouts.app')

@extends('navbar.navbar')


@section('clip_list')
<div id="main" class="container main">
	<div>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddClip_custom_modal">Add clip</button>
	</div>
	<br>
	<div>
		@include('clips.clips_list')	
	</div>
</div>
@endsection

@section('clips')
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
		      		<label for="Genre" class="col-sm-1 control-label">Genre</label>
					<div class="col-sm-5">
						<input name="mySelect2" type="hidden" id="mySelect2">
						<select id="multiselectupdate" class="js-example-basic-multiple" multiple="multiple" style="width: 100%" placeholder="Genre">
							@foreach ($allgenres as $genre) 
								<option>{{$genre->genre_name}}</option>
							@endforeach
						</select>
					</div>
			    </div>
			    <div class="form-group">
		      		<label for="Poster" class="col-sm-1 control-label">Poster</label>
		      		<div class="col-sm-8">
			    		<input class="form-control" type="text" id="Posterupdatetxt" >
			    	</div>
		      		<div class="col-sm-3">
			        	<input class="form-control" id="Posterupdate" name="Poster" type="file" placeholder="Poster URL" >
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
			        	<input class="form-control" id="Subtitle2update" type="file" placeholder="subtitle location" >
		      		</div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	    	<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
      		<button type="button" id ="btn_UpdateCustomClip" class="btn btn-primary">Update</button>
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
		      		<label for="Genre" class="col-sm-1 control-label">Genre</label>
					<div class="col-sm-5">
						<select id="addgenre" class="js-example-basic-multiple" multiple="multiple" style="width: 100%" placeholder="Genre">
							@foreach ($allgenres as $genre) 
								<option>{{$genre->genre_name}}</option>
							@endforeach
						</select>
					</div>
		      		<label for="Poster" class="col-sm-1 control-label">Poster</label>
		      		<div class="col-sm-5">
			        	<input class="form-control" id="Poster" name="Poster" type="file" placeholder="Poster URL" >
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
      		<button type="button" id ="btn_addCustomClip" class="btn btn-primary">Add</button>
	    </div>
	  </div>
	  
	</div>
</div>


<link href="{{url('/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{url('/js/select2.min.js')}}"></script>
<script src="{{ url('/js/clips.js')}} "></script>
@endsection


