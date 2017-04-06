<footer>
    <div class="container">
        <div class="col-md-6 col-sm-6">
            <div class="logo-quote" style="background: rgba(0, 0, 0, 0) url({{ asset($siteLogo) }}) no-repeat scroll 0 0 / 59px auto;">
                <h4>{{ $siteTitle }}</h4>
                <small>{{ $siteDesc }}</small>
            </div>
            <div class="nav">
                <ul>
                    <li><a href="{{ URL::to('about') }}">About</a></li>
                    <li><a href="{{ URL::to('how-it-works') }}">How it Works</a></li>
                    <li><a href="{{ URL::to('contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 text-right col-sm-6">
            <h4>Go Social</h4>
            <div class="social">
                <ul>
                @foreach ($socials as $name => $url)
                    <li><a href="{{ $url }}"><i class="fa fa-{{ $name }}"></i></a></li>
                @endforeach
                    
                </ul>

            </div>

            <div class="links">
                <ul>
                    <li><a href="{{ URL::to('privacy') }}">Privacy</a></li>
                    <li><a href="{{ URL::to('terms-n-conditions') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ URL::to('sitemap') }}">Sitemap</a></li>
                </ul>
            </div>
            <a class="agency" href="http://www.3hammers.com">
                Digital Agency<img alt="3hammers" src="{{ URL::to("") }}/images/3hammers_footer.png">
            </a>
        </div>
    </div>
</footer>