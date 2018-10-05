<?php
	require 'fbConfig.php';

?>
<html>
	<link href="https://fonts.googleapis.com/css?family=Ravi+Prakash" rel="stylesheet">
	<style>
		#body{
			background-image: url("images/harryImg.jpg");
			background-color: #000000;  
			height:100%;
			background-repeat:repeat; 
			  
		}
		
		#heading{
			color: #FFFFFF; 
			font-size: 7em; 
			font-family: 'Ravi Prakash', cursive;  
			text-align: center; 
			
		}
		#try {
		    background-color: #008CBA;
		    border: none;
		    color: white;
		    padding: 20px 40px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 16px;
		    font-family:"Bodoni MT Black";
		    font-style: oblique;
		    border-radius: 4px;
		    margin: 4px 2px;
		    cursor: pointer;
		    -webkit-transition-duration: 0.4s; /* Safari */
		    transition-duration: 0.4s;
		    margin-left: 45%;
		    margin-top: -7%;
		}
	
	</style>
	
	<body>
		<div id="body">	
			<h1 id="heading"> Which Harry Potter Character Are You? </h1>
			<form method="post" action="ops.php" >
				<input type="submit" id="try" value="Try Now" />
				
			</form>
		</div>
	</body>		
</html>