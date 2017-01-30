


@foreach ($seasons as $season)
	{{$season->season}}
	
	@foreach ($episodes[$season->season] as $episode)
		<div>
			{{ $episode->Title }}
		</div>
	@endforeach

@endforeach

