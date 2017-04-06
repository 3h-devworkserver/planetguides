<div class="dash-profile">
	<div class="profile">
		<div class="profile-img bg-wrap" style="background-image:url({{asset($user->profilePic)}})"></div>
		<div class="top-right-separator"></div>
		<div class="top-left-separator"></div>
		<div class="circle-img bg-wrap" style="background-image:url({{asset($user->profilePic)}})"></div>
	</div>
	<h4 class="profile-name">{{ $user->name }}</h4>
		<h5 class="start-using">Started using Planet guide<small>{{$user->created_at->diffForHumans()}}</small></h5>
	{!! Form::open() !!}
		<div class="view-profile {{ Active::pattern('traveller/profile*', 'dash-profile-upload') }}">
			<a href="{{url('/traveller/profile')}}">View Profile</a>
			<span class="file-input">
			  upload
			<input 
	        	type="file" 
	        	accept="image/*" 
	        	data-url="{{ route('frontend.traveller.profile.pic.upload') }}" 
	        	name="profilePic" 
	        	id="profilePic">
			</span>
			
		</div>
	{!! Form::close() !!}
</div>