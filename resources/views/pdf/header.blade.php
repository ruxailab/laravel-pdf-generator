<!DOCTYPE html>
<html>
<head>
	<title>My Project Title</title>
	<style>
		html, body {
			margin: 0;
			padding: 0;
		}
		
		body {
			background-color: #f5f5f5;
		}
		
		.cape {
			background-color: #ff6600;
			height: 150px;
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
			font-size: 24px;
			color: #333;
			margin: 0;
			padding: 0 30px;
			position: absolute;
			bottom: 0;
			left: 2%;
			margin-top: 2%;
		}
		/* .bubble {
            position: absolute;
            bottom: 25px;
            left: 15%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.7;
            box-shadow: 0px 0px 30px #ff6600;
            background: linear-gradient(135deg, #ff7f00 0%, #ff4d00 100%);
        }

        .bubble2 {
            position: absolute;
            bottom: 25px;
            left: 35%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.7;
            box-shadow: 0px 0px 30px #ff6600;
            background: linear-gradient(135deg, #ff7f00 0%, #ff4d00 100%);
        }

        .bubble3 {
            position: absolute;
            bottom: 25px;
            left: 55%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            opacity: 0.7;
            box-shadow: 0px 0px 30px #ff6600;
            background: linear-gradient(135deg, #ff7f00 0%, #ff4d00 100%);
        } */
	</style>
</head>
<body>
	<div class="cape">
		<h1 class="title">{{{ $data['actualdate'] }}}</h1>
	</div>
	<div class="info">
		<p style="font-size: 36px; margin: 0;">Author Name</p>
		<p>Date: 11th May, 2023</p>

	</div>
	<!-- <div class="bubble"></div>
   		<div class="bubble2"></div>
    	<div class="bubble3"></div> -->
</body>
</html>
