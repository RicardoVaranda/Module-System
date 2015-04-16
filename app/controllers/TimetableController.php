<?php

class TimetableController extends BaseController {

	public function getTimetable($class){

		$elec = Classes::find($class);

		if($elec !== NULL){
			return View::make('layout.timetables.layout', array('elec' => $elec));
		}

		 App::abort(404, 'Timetable Not Found');
	}

}
?>