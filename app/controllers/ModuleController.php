<?php

class ModuleController extends BaseController {

	public function postModuleNew(){

		$inputData = Input::get('modData');
	    parse_str($inputData, $formFields);  
	    $moduleData = array(
	      'mfulltitle'      => $formFields['mname'],
	      'mshorttitle'		=> $formFields['mshorttitle'],
	      'mdescription'     =>  $formFields['mdescription'],
	      'mcode'     =>  $formFields['mcode'],
	      'mfieldofstudy'     =>  $formFields['mfieldofstudy'],
	      'mcoordinator'     =>  $formFields['mcoordinator'],
	      'mlevel'     =>  $formFields['mlevel'],
	      'mcredits'     =>  $formFields['mcredits'],
	      'departmentid' => Auth::user()->department,
	    ); 

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			// This is the correct way to do this.
			$coord = User::where('name', $value)->first();
			if(!$coord && $coord->rank < 1){
				return false;
			}
		   
		  return true;
		});

	    $rules = array(
			'mfulltitle' 	=> 'required|max:50|unique:modules',
			'mshorttitle'	=> 'required|max:50|unique:modules',
			'mdescription'	=> 'required|min:30',
			'mcode'		 	=> 'required|min:7|max:8|alpha_num|unique:modules',
			'mfieldofstudy'	=> 'required|max:100',
			'mcoordinator' 	=> 'required|exists:users,name|ranked',
			'mlevel' 		=> 'required|in:Fundamental,Intermediate,Advanced,Expert',
			'mcredits'	 	=> 'required|integer|between:5,25',
			'departmentid'	=> 'required',
		);
		
		$messages = [
		    'ranked' => "This user can't coordinate this class.",
		];

		$validator = Validator::make($moduleData,$rules,$messages);

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	if(Modules::create($moduleData)){
	    		Session::flash('global', 'You have created the module "'. $moduleData['mfulltitle'].'".');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => $moduleData['mfulltitle']
		        ));
	    	}
		}
	}

	public function postModuleChange(){

		$inputData = Input::get('modData');
	    parse_str($inputData, $formFields);  
	    $moduleData = array(
	      'mfulltitle'      => $formFields['mname'],
	      'mshorttitle'		=> $formFields['mshorttitle'],
	      'mdescription'     =>  $formFields['mdescription'],
	      'mcode'     =>  $formFields['mcode'],
	      'mfieldofstudy'     =>  $formFields['mfieldofstudy'],
	      'mcoordinator'     =>  $formFields['mcoordinator'],
	      'mlevel'     =>  $formFields['mlevel'],
	      'mcredits'     =>  $formFields['mcredits'],
	      'mid'			=>	$formFields['mid'],
	      'departmentid' => Auth::user()->department,
	    );

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			$coord = User::where('name', $value)->first();
			if($coord && $coord->rank < 1){
				return false;
			}
		   
		  return true;
		});

	    $rules = array(
			'mfulltitle' 	=> 'required|max:50|unique:modules,mfulltitle,'.$formFields['mcode'].',mcode',
			'mshorttitle'	=> 'required|max:50|unique:modules,mshorttitle,'.$formFields['mcode'].',mcode',
			'mdescription'	=> 'required|min:30',
			'mcode'		 	=> 'required|min:7|max:8|alpha_num|unique:modules,mcode,'.$formFields['mcode'].',mcode',
			'mfieldofstudy'	=> 'required|max:100',
			'mcoordinator' 	=> 'required|exists:users,name|ranked',
			'mlevel' 		=> 'required|in:Fundamental,Intermediate,Advanced,Expert',
			'mcredits'	 	=> 'required|integer|between:5,25',
			'mid'			=> 'required|exists:modules,mid',
			'departmentid'	=> 'required',
		);

		$messages = [
		    'ranked' => "This user can't coordinate this class.",
		];

		$validator = Validator::make($moduleData,$rules,$messages);
		

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	$mod = Modules::where('mid', $moduleData['mid'])->first();

	    	$mod->mfulltitle = $moduleData['mfulltitle'];
	    	$mod->mshorttitle = $moduleData['mshorttitle'];
	    	$mod->mdescription = $moduleData['mdescription'];
	    	$mod->mcode = $moduleData['mcode'];
	    	$mod->mfieldofstudy = $moduleData['mfieldofstudy'];
	    	$mod->mcoordinator = $moduleData['mcoordinator'];
	    	$mod->mlevel = $moduleData['mlevel'];
	    	$mod->mcredits = $moduleData['mcredits'];
	    	$mod->departmentid = $moduleData['departmentid'];
	    	
	    	if($mod->save()){
	    		Session::flash('global', 'You have edited the module "'. $moduleData['mfulltitle'].'".');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => $moduleData['mfulltitle']
		        ));
	    	}
		}
	}

	public function getModules(){
		if(Auth::check()){
			if (Auth::user()->rank >= 2) 
				return View::make('layout.modules.load') ;
			else
				return;
		}
		else
		{
			return Redirect::route('account-sign-in');
		}
	}



	public function postElectiveNew(){

		$inputData = Input::get('elecData');
	    parse_str($inputData, $formFields);  
	    $moduleData = array(
	      'classlecturer'      => $formFields['classlecturer'],
	      'classmodule'		=> $formFields['classmodule'],
	      'classlimit'     =>  $formFields['classlimit'],
	    ); 

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			// This is the correct way to do this.
			$coord = User::where('name', $value)->first();
			if($coord && $coord->rank < 1){
				return false;
			}
		   
		  return true;
		});

        Validator::extend('indep', function($attribute, $value, $parameters)
    {
      // This is the correct way to do this.
      $mod = Modules::find($value);
      if($mod && $mod->departmentid !== Auth::user()->department){
        return false;
      }
       
      return true;
    });

	    $rules = array(
			'classmodule'	=> 'required|exists:modules,mid|indep',
			'classlecturer' 	=> 'required|exists:users,name|ranked',
			'classlimit'	 	=> 'required|integer|between:5,30',
		);
		
		$messages = [
		    'ranked' => "This user can't coordinate this class.",
		    'indep'  => "This module is not in your department.",
		];

		$validator = Validator::make($moduleData,$rules,$messages);

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	if(Classes::create($moduleData)){
	    		Session::flash('global', 'You have created an elective.');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => Modules::find($moduleData['classmodule'])->mshorttitle 
		        ));
	    	}
		}
	}

	public function postElectiveChange(){

		$inputData = Input::get('elecData');
	    parse_str($inputData, $formFields);  
	    $moduleData = array(
	      'classlecturer'      => User::where('name', $formFields['classlecturer'])->first()->id,
	      'classmodule'		=> $formFields['classmodule'],
	      'classlimit'     =>  $formFields['classlimit'],
	    ); 

	    Validator::extend('ranked', function($attribute, $value, $parameters)
		{
			// This is the correct way to do this.
			$coord = User::find($value);
			if($coord && $coord->rank < 1){
				return false;
			}
		   
		  return true;
		});

        Validator::extend('indep', function($attribute, $value, $parameters)
    {
      // This is the correct way to do this.
      $mod = Modules::find($value);
      if($mod && $mod->departmentid !== Auth::user()->department){
        return false;
      }

      return true;
    });


	    $rules = array(
			'classmodule'	=> 'required|exists:modules,mid|indep',
			'classlecturer' 	=> 'required|exists:users,id|ranked',
			'classlimit'	 	=> 'required|integer|between:5,30',
		);

		$messages = [
		    'ranked' => "This user can't coordinate this class.",
                    'indep'  => "This module is not in your department.",

		];

		$validator = Validator::make($moduleData,$rules,$messages);
		

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	$elec = Classes::where('classid', $formFields['classid'])->first();

	    	$elec->classmodule = $moduleData['classmodule'];
	    	$elec->classlecturer = $moduleData['classlecturer'];
	    	$elec->classlimit = $moduleData['classlimit'];
	    	
	    	if($elec->save()){
	    		Session::flash('global', 'You have edited a module.');
	    		  //return success  message
		        return Response::json(array(
		          'success' => true,
		          'mName' => Modules::find($moduleData['classmodule'])->mshorttitle
		        ));
	    	}
		}
	}
 
}
?>
