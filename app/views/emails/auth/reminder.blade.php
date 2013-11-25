<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{{ Lang::get('confide.password_reset.subject') }}}</h2>

		<div>
			{{Lang::get('confide.password_reset.info')}} {{ URL::to('password/reset', array($token)) }}.
		</div>
	</body>
</html>