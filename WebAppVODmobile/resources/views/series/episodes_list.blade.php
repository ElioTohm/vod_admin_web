

<div class="row">
@foreach ($seasons as $season)
	<div class="panel panel-info">
      <div class="panel-heading">{{$season->season}}</div>
      <div class="panel-body">
      	@foreach ($episodes[$season->season] as $episode)
			<div class="row top-buffer" imdbID="{{ $episode->imdbID }}">
				<div class="col-md-10">
					{{ $episode->Title }}
				</div>
				<div class="col-md-2">
					<button class="btn btn-danger btn-sm" delete="episode" imdbID="{{ $episode->imdbID }}">Delete</button>
				</div>
			</div>  
		@endforeach
      </div>
	</div>	
@endforeach	
</div>
