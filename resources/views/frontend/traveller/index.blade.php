@extends('frontend.layouts.masterProfile')
@section('title') Dashboard | {{ $siteTitle }}@endsection
@section('content')

<section class="dashboard">
		<div class="profile">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
					    <div class="profile-img pull-left">
					        <span class="avatar"><i class="fa fa-user"></i></span>
					        <label class="username">{{ auth()->user()->username;}}</label>
					    </div>

					    <div class="view-profile pull-right">
					        {!! link_to('traveller/profile', trans('navs.view_profile'), ['class' =>'btn btn-danger']) !!}
					    </div>
					</div>
				</div>
			</div>	
		</div>
		<div class="container">
			<div class="wrapper">
				<div class="row">
					<div class="col-md-12">
						<div class="recentactives">
							<h1>Recently Addes Guides</h1>
							<div class="post">
								<div class="row">
									<div class="col-md-10">
										<div class="user">
											<a href="#" style="background-image:url(images/guide-1.jpg)"></a>
											<div class="name">
												<h5>Anna Rosee</h5>
												<span>2 year(experience)</span>
												<div>
													<span title="" date-placement="top" data-toggle="tooltip" class="rating average" data-original-title="Average">
														<span>3</span>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 text-center">
										<span class="booked">Booked 1 day ago</span>
										<button class="btn btn-primary cust-btn-sm">View Detail</button>
									</div>
								</div>
							</div>
							<div class="post">
								<div class="row">
									<div class="col-md-10">
										<div class="user">
											<a href="#" style="background-image:url(images/guide-2.jpg)"></a>
											<div class="name">
												<h5>Anthony Bell</h5>
												<span>2 year(experience)</span>
												<div>
													<span title="" date-placement="top" data-toggle="tooltip" class="rating remarkable" data-original-title="Remarkable">
														<span>5</span>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 text-center">
										<span class="booked">Booked 2 day ago</span>
										<button class="btn btn-primary cust-btn-sm">View Detail</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>


@endsection