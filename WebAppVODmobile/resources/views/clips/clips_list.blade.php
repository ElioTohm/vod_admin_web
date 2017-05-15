<div id="clips_gallery" >
	<table class="table table-striped">
		<thead>
			<tr>
				<th><h3><b>name</b></h3></th>
				<th><h3><b>update</b></h3></th>
				<th><h3><b>delete</b></h3></th>
			</tr>
			<tbody>
				@foreach ($clips as $clip)
					<tr id='{{$clip->id}}'>
						<td>
							{{ $clip->Title }}
						</td>
						<td>
							<button class="btn btn-primary" id='{{$clip->id}}' update="clip" data-toggle="modal" data-target="#UpdateClip_custom_modal">Update</button>	
						</td>
						<td>
							<button class="btn btn-danger" id='{{$clip->id}}' delete="clip" >Delete</button>								
						</td>
					</tr>
				@endforeach
			</tbody>
		</thead>
	</table>	
</div>
<div>
	{!! $clips->links() !!}
</div>
