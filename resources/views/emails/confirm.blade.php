<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>signup activation</title>
	</head>
	<body>
		<h1>Thank U for signing up for sample site</h1>
		<p>Please click:<a href="{{ route('confirm_email', $user->activation_token) }}">{{ route('confirm_email', $user->activation_token) }}</a></p>

		<p>If it is not your reply, ignore please.</p>
	</body>
</html>