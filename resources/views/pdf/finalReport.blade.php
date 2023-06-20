<!DOCTYPE html>
<html>
<head>
    <title>Final Report</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
.orange-bar {
    background-color: orange;
    height: 20px;
    width: 100%;
  }
        .content {
    padding: 20px;
    color: white;
    font-family: Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5;
    text-align: justify;
}
.content h1{
    color:orange !important; 
    padding: 0px !important;
    margin: 0px !important;
    padding-top: 10px !important;
}
.black-text{
    color:black !important;
    padding-top: 1rem;
}
 		@page { margin: 20px 30px 40px 50px; }
    </style>
</head>
<body>
    <div class="content">
        <div class="orange-bar"></div>
        <h1>FINAL REPORT</h1>
        <div class="black-text">
        <?php
      
        $htmlText =  $data['finalReport'];
    
        // Output the inner HTML object
        echo $htmlText;
        ?>
        </div>
    </div>
	<div id="footer">

    </body>
</html>
