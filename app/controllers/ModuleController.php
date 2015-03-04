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

	    $rules = array(
			'mfulltitle' 	=> 'required|max:50|unique:modules',
			'mshorttitle'	=> 'required|max:50|unique:modules',
			'mdescription'	=> 'required|min:30',
			'mcode'		 	=> 'required|min:7|max:8|alpha_num|unique:modules',
			'mfieldofstudy'	=> 'required|max:100',
			'mcoordinator' 	=> 'required|exists:users,name,rank,1',
			'mlevel' 		=> 'required|in:Fundamental,Intermediate,Advanced,Expert',
			'mcredits'	 	=> 'required|integer|between:5,25',
			'departmentid'	=> 'required',
		);

		$validator = Validator::make($moduleData,$rules);

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

	public function postModuleEdit(){

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

	    $rules = array(
			'mfulltitle' 	=> 'required|max:50|unique:modules',
			'mshorttitle'	=> 'required|max:50|unique:modules',
			'mdescription'	=> 'required|min:30',
			'mcode'		 	=> 'required|min:7|max:8|alpha_num|unique:modules',
			'mfieldofstudy'	=> 'required|max:100',
			'mcoordinator' 	=> 'required|exists:users,name,rank,1',
			'mlevel' 		=> 'required|in:Fundamental,Intermediate,Advanced,Expert',
			'mcredits'	 	=> 'required|integer|between:5,25',
			'departmentid'	=> 'required',
		);

		$validator = Validator::make($moduleData,$rules);

		if($validator->fails()){
	        return Response::json(array(
	            'fail' => true,
	            'errors' => $validator->getMessageBag()->toArray()
	        ));
	    } else {

	    	$mod = Modules::where('mcode', $moduleData['mcode']);

	    	$mod->mfulltitle = $moduleData['mfulltitle'];
	    	$mod->mshorttitle = $moduleData['mshorttitle'];
	    	$mod->mdescription = $moduleData['mdescription'];
	    	$mod->mcode = $moduleData['mcode'];
	    	$mod->mfieldofstudy = $moduleData['mfieldofstudy'];
	    	$mod->mcoordinator = $moduleData['mcoordinator'];
	    	$mod->mlevel = $moduleData['mlevel'];
	    	$mod->mcredits = $moduleData['mcredits'];
	    	$mod->departmentid = $moduleData['departmentid'];
	    	
	    	if(Modules::create($moduleData)){
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

		public function getImage($modCode){

		    $cacheKey = md5($modCode);

		    $image = Cache::remember($cacheKey, 3600, function() use ($modCode) {
		        // start making our image (this assumes your original image is within "app/storage/img")
		        $colors = array('#00c6ff', '#f39c12', '#ff0000', '#49E035');
		        $color = $colors[array_rand($colors)];
		        $img = Image::canvas(384, 384, $color);
		        $img->insert(public_path('images/layout.png'), 'top-left', 5, 0);

		        $mod = Modules::where('mcode', $modCode);

		        if($mod->count()){
		        	$mod = $mod->first();

		        	$img->text($mod->department->name(), 192, 250, function($font) {
					    $font->file(public_path('fonts/segoeui.ttf'));
					    $font->size(30);
					    $font->color('#fff');
					    $font->align('center');
					});

					$img->text($mod->mshorttitle, 192, 320, function($font) {
					    $font->file(public_path('fonts/segoeui.ttf'));
					    $font->size(25);
					    $font->color('#fff');
					    $font->align('center');
					});

		        } elseif ($modCode == 'new') {
		        	$img->text('Create new Module!', 192, 300, function($font) {
					    $font->file(public_path('fonts/segoeui.ttf'));
					    $font->size(30);
					    $font->color('#fff');
					    $font->align('center');
					});
		        } else {
			        $img->text('Error: Module not Found!', 192, 300, function($font) {
					    $font->file(public_path('fonts/segoeui.ttf'));
					    $font->size(30);
					    $font->color('#fff');
					    $font->align('center');
					});
		   		}

		        // return the image as a JPG
		        return $img->encode('jpg');
		    });

		    // return the image
		    $headers = [
		        'Content-Type'        => 'image/jpeg',
		        'Content-Disposition' => 'inline',
		        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
		        'Pragma'              => 'public',
		        'Etag'                => md5($image),
		    ];

		    return Response::make($image, 200, $headers)->setTtl((60 * 30));
		}
 
	}
?>