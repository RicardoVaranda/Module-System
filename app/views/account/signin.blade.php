<html>
	<head>
		<title>CIT Modules :: Module System Login!</title>
		<meta name="description" content="Module System Login Page" />
		<meta charset="UTF-8" />
		{{ HTML::style('./css/loginStyle.css') }}
		{{ HTML::script('./js/jquery.js') }}
		{{ HTML::script('./js/jquery.ui.core.js') }}
		{{ HTML::script('./js/jquery.ui.widget.js') }}
		{{ HTML::script('./js/touch.js') }}
		{{ HTML::script('./js/moment.js') }}
		{{ HTML::script('./js/script.js') }}
	</head>
	<body>
		<div class="fullScreenItem" id="loginPage">
			<div id="loginFormCenter">
				<div id="LoginFormContainer">
					<img src="{{URL::to('/')}}/images/me.png">
					<div id="rightContainer">
						<h1>
							<span id="user" ContentEditable="false" style="text-transform:uppercase">{{ (Input::old('username')) ? e(Input::old('username')) : '[Student ID]' }}</span>
							<span id="notyou">(not you?)</span>
						</h1>
						<h4>CIT Module System</h4>
						<form id="loginForm" action="{{ URL::route('account-sign-in-post') }}" method="POST">
							<input id="username" name="username" style="display:none;" {{ (Input::old('username')) ? ' value="'. e(Input::old('username')) . '"' : '' }} required>
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
					@if(Session::has('global'))
						<div class="global"> {{ Session::get('global') }} </div>
					@endif
				</div>
			</div>
		</div>
		<div id="rightBar" class="bottomBar">
			<a href="www.mycit.ie" target="_blank">
				<img src="{{URL::to('/')}}/images/myCIT.png" alt="myCIT homepage" title="myCIT Homepage" />
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