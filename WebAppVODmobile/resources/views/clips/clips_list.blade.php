<div id="clips_gallery" class="container" >
	@foreach ($clips as $clip)
		<div class="col-md-4 text-center " id='{{$clip->id}}'>
			<div class="container-fluid well clip-container">
				<br>
				<a>
					<img class="movie-poster" src="{{$clip->Poster}}">	
				</a>
				<br>
	        	<h3>{{ $clip->Title }}</h3	>
	        	<br>
	        	<button class="btn btn-primary" id='{{$clip->id}}' update="clip" data-toggle="modal" data-target="#UpdateClip_custom_modal">Update</button>	
	        	<button class="btn btn-danger" id='{{$clip->id}}' delete="clip" >Delete</button>	
			</div>
			
    	</div>
    @endforeach
</div>
<div>
	{!! $clips->links() !!}
</div>
