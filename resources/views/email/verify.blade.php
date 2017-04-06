<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>           
        <div>
        <div>
            <h3>Greetings</h3>
            <h4>{{$fname}} {{$lname}}</h4>
        </div>

        <div>Welcome to GUIDENP!</div><br/>	

        <div>
            You have just signed up to our GUIDENP services. Please click on below link to activate your account. This is for security confirmation that no one else uses your account. Click below link or copy paste below link into any browser address bar and you are done.           
		</div><br/>
		<!--<div>{{ trans('strings.click_here_to_reset') }}</div> -->
		<div> {{ url('register/verify/' . $confirmation_code) }}</div><br/><br/>
		<div> Thank you for your support. We will always try harder to serve you best.</div>		
		</div><br/><br/>

        <div>
        <div>Regards</div><br/>
        <div>
        	<a  href="http://guidenp.com">
			<img src="http://guidenp.com/images/logo.png" style="width: 72px;">
			</a>
        </div>
		<div>GUIDENP Team</div>
		<div>
		<a href="mailto:info@guidenp.com">info@guidenp.com</a><br/>
		<a href="www.guidenp.com">www.guidenp.com</a>
		</div>
        </div>

    </body>
</html>