<div><a href="http://guidenp.com"> <img style="width: 72px;" src="http://guidenp.com/images/logo.png" alt="" /> </a></div>
<h3>Hello</h3>
<h4>{{$user['fname']}} {{$user['lname']}}</h4>
<br />
<div>As you requested, we have sent you a password reset link to change your password.<br /> Please click below link and change your password.</div>
<br /> <!--<div>{{ trans('strings.click_here_to_reset') }}</div> -->
<div>{{url('password/reset/' . $token) }}</div>
<br /><br />
<div>
<div>Regards,</div>
<div>GUIDENP Team</div>
<div><a href="mailto:info@guidenp.com">info@guidenp.com</a><br /> <a href="/guidenplive/public/admin/settings/www.guidenp.com">www.guidenp.com</a></div>
</div>