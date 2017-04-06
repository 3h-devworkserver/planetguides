@extends('frontend.layouts.master')

@section('content')
	<section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-wrap">
                        <h2 class="text-center">Looking for a Guide? <small>Lorem ipsum dolor sit amet.</small></h2>
                        @include('frontend.includes.searchbar');
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2 class="text-center">Top Guides</small></h2>
                    </div>
                </div>
            </div>
            <div class="guides">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="profile.html">
                                <div style="background-image:url(images/guide-2.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="profile.html">Anthony Bell</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <div style="background-image:url(images/guide-1.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <div style="background-image:url(images/guide-3.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <div style="background-image:url(images/guide-2.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail" style="background-image:url(images/guide-1.jpg)">
                            <a href="#">
                                <div style="background-image:url(images/guide-1.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="profile.html">
                                <div style="background-image:url(images/guide-3.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="profile.html">
                                <div style="background-image:url(images/guide-1.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="profile.html">
                                <div style="background-image:url(images/guide-2.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <div style="background-image:url(images/guide-3.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <div style="background-image:url(images/guide-2.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <div style="background-image:url(images/guide-1.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <a href="#">
                                <div style="background-image:url(images/guide-3.jpg)"></div>
                            </a>
                            <div class="caption">
                                <h3><a href="#">Anna Rosee</a></h3>
                                <div class="experience pull-left">
                                    <em>Experience : 1 year</em>
                                </div>
                                <div class="rating pull-right">
                                    <ul>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                        <li><i class="fa fa-star-o"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary cust-btn-lg"> View more</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('after-scripts-end')
	<script>
		//Being injected from FrontendController
		console.log(test);
	</script>
@stop