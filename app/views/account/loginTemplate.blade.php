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
		{{ HTML::script('./js/test.js') }}
	</head>
	<body>
		<div class="fullScreenItem" id="loginPage">
			<div id="loginFormCenter">
				<div id="LoginFormContainer">
					<img src="{{URL::to('/')}}/images/me.png">
					<div id="rightContainer">
						@yield('content')
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
	</body>
</html>