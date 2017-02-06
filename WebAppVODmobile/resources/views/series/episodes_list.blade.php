

<div class="row">
<br>
@foreach ($seasons as $season)
	<div class="panel panel-info">
      <div class="panel-heading">Season {{$season->season}}</div>
      <div class="panel-body">
      	@foreach ($episodes[$season->season] as $episode)
			<div class="row top-buffer" imdbID="{{ $episode->id }}">
				<div class="col-md-3">
					{{ $episode->Title }}
				</div>
				<div class="col-md-6">
					<label>{{$episode->stream}}</label> 
					<input id="Stream" type="file" name="Stream" imdbID="{{ $episode->id }}">
				</div>
				<div class="col-md-1">
					<button class="btn btn-success btn-sm updateepisode" seriesID="{{$serie->id}}" udpate="episode" Title="{{ $episode->Title }}" imdbID="{{ $episode->id }}">Update</button>
				</div>
				<div class="col-md-1">
					<button class="btn btn-danger btn-sm" delete="episode" imdbID="{{ $episode->id }}">Delete</button>
				</div>
			</div>  
		@endforeach
      </div>
	</div>	
@endforeach	
</div>
