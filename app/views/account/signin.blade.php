<html>
	<head>
		<title>CIT Modules :: Module System Login!</title>
		<meta name="description" content="Module System Login Page" />
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="css/loginStyle.css" />
		<script src="js/jquery.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		<script src="js/touch.js"></script>
		<script src="js/moment.js"></script>
		<script src="js/script.js"></script>
	</head>
	<body>
		<div class="fullScreenItem" id="loginPage">
			<div id="loginFormCenter">
				<div id="LoginFormContainer">
					<img src="images/me.png">
					<div id="rightContainer">
						<h1>
							<span id="user" ContentEditable="false" {{ (Input::old('username')) ? ' value="'. Input::old('username') .'"' : ''}}>[Username]</span>
							<span id="notyou">(not you?)</span>
						</h1>
						<h4>CIT Module System</h4>
						<form id="loginForm" action="{{ URL::route('account-sign-in-post') }}" method="POST">
							<input id="username" name="username" style="display:none;" required>
							<input id="pass" name="password" type="password" text="" placeholder="Password" required>
							<div id="showPass"></div>
							<div id="submit"></div>
							{{ Form::token()}}
						</form>
						<input type="checkbox" name="remember" id="remember">
							<label for="remember" id="remember">
								Remember me
							</label>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div id="rightBar" class="bottomBar">
			<a href="www.mycit.ie" target="_blank">
				<img src="images/myCIT.png" alt="myCIT homepage" title="myCIT Homepage" />
			</a>
		</div>
		<div id="leftBar" class="bottomBar">
			<!--<a href="http://AlirezaDesigner.com/" target="_blank">
				<img src="images/alirezadesigner.png" alt="Go to AlirezaDesigner.com!" title="Go to AlirezaDesigner.com!" />
			</a> -->
		</div>
		<div class="fullScreenItem draggable" id="loginCover" style="display:none">
			<p id="time">13:56</p>
			<p id="date">Thursday, Decemeber 14</p>
		</div>
	</body>
</html>