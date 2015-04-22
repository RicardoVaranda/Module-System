<?php

class TimetableController extends BaseController {

	public function getTimetable($class){

		$elec = Classes::find($class);

		if($elec !== NULL){
			return View::make('layout.timetables.layout', array('elec' => $elec));
		}

		 App::abort(404, 'Timetable Not Found');
	}

	public function postSaveTimetable(){
		if (Request::ajax())
		{
			$class = Classes::find(Input::get('id'));

			$times = Input::get('time');

			$times = substr($times, 1, -1);

			$class->classtimes = $times;


			if($class->save()){
				return Response::json('success', 200);
			}
		}
	}

}
?>