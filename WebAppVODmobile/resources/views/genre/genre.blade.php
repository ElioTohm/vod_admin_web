@extends('layouts.app')



@section('genres')
<div id="main" class="container main">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="control-label">Genre</label>
						<input class="form-control" id="Genre_Name" name="Genre" type="text" placeholder="Genre Name">
					</div>
					<div class="form-group">
						<button id="AddGenre_btn" class="btn btn-primary">Add Genre</button>
						<img hidden="true" class="loadingif" src=" {{url('/images/ajax-loader.gif')}} ">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="list-group">
					@foreach ($genres as $genre)
							<a class="list-group-item" id="{{$genre->genre_id}}">
								<p class="list-group-item-heading">
									{{$genre->genre_name}}
									<button id="{{$genre->genre_id}}" class="btn btn-danger pull-right">Delete</button>
								</p>
							</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="{{url('/js/genre.js')}}"></script>
@endsection
