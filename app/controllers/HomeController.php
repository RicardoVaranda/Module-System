<?php

class HomeController extends BaseController {

	public function home(){
		if(Auth::check())
			return View::make('home');
		else
			return Redirect::route('account-sign-in');
	}

	public function test(){
		return View::make('test');
	}

}
