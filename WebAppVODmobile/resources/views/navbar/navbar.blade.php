@section('navbar')
<div id="sidebar">
	<div id="navbar" class="navbar sidenav navbar-default">
		<a class="menubtn" id="menubtn" ><span class="glyphicon glyphicon-menu-hamburger"></span></a>
		<!-- List of Videoss -->
		<div class="form-inline menusection">
			<b><u>
				<p>Videos</p>
			</b></u>
			<div class="list-group">
				<a href="/movies" class="list-group-item">
					<p class="list-group-item-heading">Movies</p>
					
				</a>
				<a href="/series" class="list-group-item">
					<p class="list-group-item-heading">Series</p>
				</a>
				<a href="/genres" class="list-group-item">
					<p class="list-group-item-heading">Genres</p>
				</a>
			</div>
		</div>	
		<!-- list of clients -->
		<div class="form-inline menusection">
			<b><u>
			<p>Clients</p>
			</b></u>
			<div class="list-group">
					<a href="/activeclients" class="list-group-item">
						<p class="list-group-item-heading">Active</p>
					</a>
					<a href="/clients" class="list-group-item">
						<p class="list-group-item-heading">Non-Active</p>
					</a>
				</div>
		</div>
	</div>
</div>
<script src="/js/home.js"></script>

@endsection