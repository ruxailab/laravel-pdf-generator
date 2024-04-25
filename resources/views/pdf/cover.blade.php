<!DOCTYPE html>
<html>

<head>
	<title>My Project Title</title>
	<style>
		html,
		body {
			margin: 0;
			padding: 0;
		}

		body {
			background-color: #f5f5f5;
		}

		.cape {
			background-color: #ff6600;
			height: 250px;
			position: relative;
		}

		.cape::after {
			content: "";
			display: block;
			border-top: 40px solid #ff6600;
			border-left: 150px solid transparent;
			position: absolute;
			bottom: -40px;
			right: 0;
		}

		.title {
			font-size: 48px;
			font-weight: bold;
			color: #fff;
			margin: 0;
			padding: 0 0 20px 2%;
			position: absolute;
			bottom: 0;
			left: 2%;
		}

		.info {
			font-size: 36px;
			color: #333;
			margin: 0;
			padding: 0 30px;
			position: absolute;
			bottom: 0;
			left: 2%;
			margin-top: 0;
		}

		#footer {
			position: fixed;
			right: 10px;
			bottom: 10px;
			text-align: center;
		}

		#footer .page:after {
			content: counter(page, decimal);
		}
	</style>
</head>

<body>
	<div class="cape">
		<h1 class="title">{{{ $data['title'] }}}</h1>
	</div>
	<div class="info">
		<p>{{{ $data['actualdate'] }}}</p>
	</div>
	</div>
</body>

</html>