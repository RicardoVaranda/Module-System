<?php

class HomeController extends BaseController {

	public function home(){
		if(Auth::check()){
			if(Auth::user()->rank == 1) 
				return View::make('layout.lecturer');
			elseif (Auth::user()->rank == 2) 
				return View::make('layout.hod');
			elseif (Auth::user()->rank == 3) 
				return View::make('layout.tech');
			else
				return View::make('layout.student');
		}
		else
		{
			return Redirect::route('account-sign-in');
		}
	}

}