@extends('layouts.app')



@section('content')

<div id="main" class="container main">
    <div id="movies_gallery" class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach ($categories as $categorie)
		        {{ $categorie->categorie_name }}
		    @endforeach
        </div>
    </div>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddMovie">Add Categorie</button>
</div>

<!-- Modal -->
<div class="modal fade" id="AddMovie" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title">Add a Category</h4>
	    </div>
	    <div class="modal-body">
	      	<form class="form-horizontal" role="form" name="form_addMovie">
			    {{ csrf_field() }}
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				<div class="form-group">
		      		<label for="imdbID" class="col-sm-2 control-label">Category Name</label>
			      	<div class="col-sm-10">
			    	    <input class="form-control" id="categorie_name" type="text" placeholder="imDB id">
				    </div>
			    </div>
			</form>
	    </div>
	    <div class="modal-footer">
	      <button type="button" id ="btn_addCategory" class="btn btn-primary">Add</
	      button>
	    </div>
	  </div>
	  
	</div>
</div>

@push('scripts')
	<script src="/js/category.js"></script>
@endpush

@endsection