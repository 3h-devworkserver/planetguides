<div class="dashboard-navbar">
	<div class="container">
		<ul>
			<li class="{{ Active::pattern('traveller/dashboard*') }}">
				<a href="{{ URL::to('traveller/dashboard') }}">
					<i class="fa fa-tachometer"></i>
					dashboard
				</a>
			</li>
			<li class="{{ Active::pattern('traveller/activity*') }}">
				<a href="{{url('traveller/activity')}}">
					<i class="fa fa-calendar-o"></i>
					Booking history
				</a>
			</li>
			<li class="{{ Active::pattern('admin/pages*') }}">
				<a href="#">
					<i class="fa fa-star"></i>
					your reviews
				</a>
			</li>
			<li class="{{ Active::pattern('traveller/favorites*') }}">
				<a href="{{url('traveller/favorites')}}">
					<i class="fa fa-heart"></i>
					your favourite
				</a>
			</li>
			<li class="{{ Active::pattern('traveller/profile*') }}">
				<a href="{{url('/traveller/profile')}}">
					<i class="fa fa-user"></i>
					profile
				</a>
			</li>
		</ul>
	</div>
</div>