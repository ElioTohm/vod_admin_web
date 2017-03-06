

<div class="row">
<br>
@foreach ($seasons as $season)
	<div class="panel panel-info">
      <div class="panel-heading">Season {{$season->season}}</div>
      <div class="panel-body">
      	@foreach ($episodes[$season->season] as $episode)
			<div class="row top-buffer" imdbID="{{ $episode->id }}">
				<div class="col-md-2">
					{{ $episode->Title }}
				</div>
				<div class="col-md-8">
					<label class="col-sm-2 control-label">Stream</label>
					<div class="col-sm-5">
		      			<input class="form-control" type="text" id="Streamtext" class="control-label" value="{{$episode->stream}}">
			        	<input id="Stream" type="file" name="Stream" imdbID="{{ $episode->id }}" value="{{$episode->stream}}">
		      		</div>
					<label for="subtitle" class="col-sm-2 control-label">Subtitle</label>
		      		<div class="col-sm-5">
		      			<input class="form-control" id="Subname" type="text" class="control-label" value="{{$episode->Subtitle}}">
			        	<input class="form-control" id="Subtitle" name="subtitle" type="file" placeholder="Subtitle" value="{{$episode->Subtitle}}">
		      		</div>
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
