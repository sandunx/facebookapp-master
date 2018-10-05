<?php // Include FB config file
require_once 'fbConfig.php';
error_reporting(0);
if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb -> setDefaultAccessToken($_SESSION['facebook_access_token']);

	} else {
		// Put short-lived access token in session
		$_SESSION['facebook_access_token'] = (string)$accessToken;

		// OAuth 2.0 client handler helps to manage access tokens
		$oAuth2Client = $fb -> getOAuth2Client();

		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client -> getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string)$longLivedAccessToken;

		// Set default access token to be used in script
		$fb -> setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// Redirect the user back to the same page if url has "code" parameter in query string
	if (isset($_GET['code'])) {
		header('Location: ./');
	}

	// Getting user facebook profile info
	try {
		$profileRequest = $fb -> get('/me?fields=name,first_name,last_name,birthday,picture');
		$requestPicture = $fb -> get('/me/picture?redirect=false&height=310&width=300');
		$birthday = $fb -> get('/me?fields=birthday');

		$user = $profileRequest -> getGraphNode() -> asArray();
		$picture = $requestPicture -> getGraphNode();
		$bday = $birthday -> getGraphNode();

		//Seperating Month from the birthday string
		$month = substr($bday, 18, 2);
		//echo "$month";

		$character = null;
		$imgC = null;
		//matching month to a character
		switch ($month) {
			case '01' :
				$character = "Severus Snape";
				$imgC = "images/snape.jpg";
				break;

			case '02' :
				$character = "Arthur Weasley";
				$imgC = "images/arthur.jpg";
				break;

			case '03' :
				$character = "Ron Weasley";
				$imgC = "images/ron.jpg";
				break;

			case '04' :
				$character = "Fred & George Weasley";
				$imgC = "images/twins.jpg";
				break;

			case '05' :
				$character = "Harry Potter";
				$imgC = "images/harry.jpg";
				break;

			case '06' :
				$character = "Dobby";
				$imgC = "images/dobby.jpg";
				break;

			case '07' :
				$character = "Neville Longbottom";
				$imgC = "images/neville.jpg";
				break;

			case '08' :
				$character = "Sirius Black";
				$imgC = "images/black.jpg";
				break;

			case '09' :
				$character = "Hermione Granger";
				$imgC = "images/hermione.jpg";
				break;

			case '10' :
				$character = "Dolores Umbridge";
				$imgC = "images/umbridge.jpg";
				break;

			case '11' :
				$character = "Draco Malfoy";
				$imgC = "images/malfoy.jpg";
				break;

			case '12' :
				$character = "Rubeus Hagrid";
				$imgC = "images/hagrid.jpg";
				break;

			default :
				break;
		}

		//Obtaining user's profile picture
		$requestPicture = $fb -> get('/me/picture?redirect=false&height=300');
		$picture = $requestPicture -> getGraphUser();
		//echo "<img src='".$picture['url']."'/>";

		//echo"<img src='".$imgC."'/>";
		$GLOBALS['character'] = $character;
		$GLOBALS['charImg'] = $imgC;
		$GLOBALS['userImg'] = $picture['url'];
		$GLOBALS['userName'] = $user['name'];

		if(isset($_POST['msg'])){
			$request = $fb->post('/me/feed',array('message'=>$_POST['msg']));
			$response = $request->getGraphNode()->asArray;
		}
		
	} catch(FacebookResponseException $e) {

		echo 'Graph returned an error: ' . $e -> getMessage();
		session_destroy();
		// Redirect user back to app login page
		header("Location: ./");
		exit ;
	} catch(FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e -> getMessage();
		exit ;
	}

} else {
	echo "no token";
	// Get login url
	$loginURL = $helper -> getLoginUrl($redirectURL, $fbPermissions);

	// Render facebook login button
	$output = '<a href="' . htmlspecialchars($loginURL) . '"><img src="images/fblogin-btn.png"></a>';
}
?>
<html>
<head>
<title>Facebook app</title>
<link href="https://fonts.googleapis.com/css?family=Ravi+Prakash" rel="stylesheet">	
 <style>
	#backM {
		width: 70em;
		height: 40em;
		margin-left: 10em;
		margin-top: 1em;
		
		background: rgba(76,76,76,1);
		background: -moz-linear-gradient(left, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(0,0,0,1) 50%, rgba(44,44,44,1) 50%, rgba(17,17,17,1) 51%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%);
		background: -webkit-gradient(left top, right top, color-stop(0%, rgba(76,76,76,1)), color-stop(12%, rgba(89,89,89,1)), color-stop(25%, rgba(102,102,102,1)), color-stop(39%, rgba(71,71,71,1)), color-stop(50%, rgba(0,0,0,1)), color-stop(50%, rgba(44,44,44,1)), color-stop(51%, rgba(17,17,17,1)), color-stop(76%, rgba(43,43,43,1)), color-stop(91%, rgba(28,28,28,1)), color-stop(100%, rgba(19,19,19,1)));
		background: -webkit-linear-gradient(left, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(0,0,0,1) 50%, rgba(44,44,44,1) 50%, rgba(17,17,17,1) 51%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%);
		background: -o-linear-gradient(left, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(0,0,0,1) 50%, rgba(44,44,44,1) 50%, rgba(17,17,17,1) 51%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%);
		background: -ms-linear-gradient(left, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(0,0,0,1) 50%, rgba(44,44,44,1) 50%, rgba(17,17,17,1) 51%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%);
		background: linear-gradient(to right, rgba(76,76,76,1) 0%, rgba(89,89,89,1) 12%, rgba(102,102,102,1) 25%, rgba(71,71,71,1) 39%, rgba(0,0,0,1) 50%, rgba(44,44,44,1) 50%, rgba(17,17,17,1) 51%, rgba(43,43,43,1) 76%, rgba(28,28,28,1) 91%, rgba(19,19,19,1) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c', endColorstr='#131313', GradientType=1 );
		
		
	}
	#headBanner{
		font-size: 7em; 
		font-family: 'Ravi Prakash', cursive;  
		margin-left: 1.8em; 
		color:aliceblue;
	}
	#charImg{
		margin-left: 10%;
		margin-top: -5%;
		height: 300px;
		width: 300px;
	}
	#userImg{
		margin-left: 25%;
		margin-top: -5%;
		height: 300px;
		width: 300px;
	}
	#charName{
		font-size: 7em; 
		font-family: 'Ravi Prakash', cursive; 
		color:aliceblue;
		margin-left: 2.7em;
	}
	#shareBtn{
		background-image: url("images/fbShare.png");
		height: 20px;
		width: 200px;
		background-repeat: no-repeat;
		border: 0;
	}
	.glass{
		/* background styles */
			position: relative;
			display: inline-block;
			padding: 15px 25px;
			background-color: green; /*for compatibility with older browsers*/
			background-image: linear-gradient(green,lightgreen);
		
			/* text styles */
			text-decoration: none;
			color: #fff;
			font-size: 25px;
			font-family: sans-serif;
			font-weight: 100;
			
			border-radius: 3px;
			box-shadow: 0px 1px 4px -2px #333;
			text-shadow: 0px -1px #333;
	}
	.glass:after{
				content: '';
				position: absolute;
				top: 2px;
				left: 2px;
				width: calc(100% - 4px);
				height: 50%;
				background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
	}
	.glass:hover{
			background: linear-gradient(#073,#0fa);
	}
	
	
	#formShare{
		margin-top: -3em;
		margin-left: 29em;
	}
	
	
	
 </style>
   
 
</head>
<body>
	<div id="backM" >
		<div id="banner">
			<span id="headBanner">Your Character is</span>  
		<!--
			<?php echo $GLOBALS['character']; ?>	
			<?php echo $GLOBALS['userName']; ?>
			
			<img src='<?php echo $GLOBALS['userImg']; ?>'/>
		-->
		</div>
		<div >
			<img src='<?php echo $GLOBALS['charImg']; ?>'id="charImg" />
		
			<img src='<?php echo $GLOBALS['userImg']; ?>'id="userImg" />
		</div>
		<div id="charName">
			<?php echo $GLOBALS['character']; ?>
		</div>
		<div id='formShare'>
			<form action="" method="post">
				<input type="hidden" name="msg" value="find yours at http://localhost/facebookapp/"  />
				<input type="submit" class="glass" value="Share App" />
			</form>
		</div>
	</div>
</body>
</html>
