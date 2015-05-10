<p>Dear, {{$user->email}}</p>

<p>You have been invited to ThunderDrive by {{$from->name}} in collaborating using the drive for {{$org->name}} organization</p>

<p>
	If you have not registered to our service, please <a href='{{route("web.register.get", ['email' => $user->email])}}'>Register here</a> or
	if you already have an account in our servive please <a href='{{route("web.signin.get", ['email' => $user->email])}}'>sign in here</a>
</p>

<p>
	Your sincerely,
	<br/>ThunderDrive team
</p>