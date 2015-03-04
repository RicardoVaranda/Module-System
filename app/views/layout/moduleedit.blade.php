<li class="mix all"> 
	<a data-toggle="modal" role="button" href="{{ $type=='edit' ? '#editMod'.$mod->mcode : '#newMod'}}"> <img src="{{ $type=='edit' ? URL::route('getImg', $mod->mcode) : URL::route('getImg', 'new')}}" alt="portfolio">
		<div><span>{{ $type=='edit' ? $mod->mshorttitle : 'Create new Module'}}</span></div>
	</a>
	<div class="modal fade" id="{{ $type=='edit' ? 'editMod'.$mod->mcode : 'newMod'}}" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div  class="contact-box">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            <form name="contactform" id="{{ $type=='edit' ? 'editForm' : 'newForm'}}" action="{{ $type=='edit' ? URL::route('module-change-post') : URL::route('module-new-post') }}" method="post">
	                <fieldset>
	                    <h4 class="h4">{{ $type=='edit' ? 'Edit Module' : 'Create new Module'}}</h4>
	                    <div class="form-group">
	                        <i class="fa fa-university"></i>
	                        <input type="text" value="{{ $type=='edit' ? $mod->mfulltitle : '' }}" name="mname" id="name" class="form-control" placeholder="Module Title (required)" required>
	                    </div>
	                    <div id="mfulltitle" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                        <i class="fa fa-university"></i>
	                        <input type="text" value="{{ $type=='edit' ? $mod->mshorttitle : '' }}" name="mshorttitle" id="name" class="form-control" placeholder="Module Short Title (required)" required>
	                    </div>
	                    <div id="mshorttitle_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                        <i class="fa fa-university"></i>
	                        <textarea type="text" name="mdescription" id="desc" class="form-control" placeholder="Module Description (required)" required>{{ $type=='edit' ? $mod->mdescription : ''}}</textarea>
	                    </div>
	                    <div id="mdescription_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                        <i class="fa fa-code"></i>
	                        <input type="text" value="{{ $type=='edit' ? $mod->mcode : '' }}" name="mcode" id="code" class="form-control" placeholder="Module Code(required)" required>
	                    </div>
	                    <div id="mcode_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                        <i class="fa fa-book"></i>
	                        <input type="text" value="{{ $type=='edit' ? $mod->mfieldofstudy : '' }}" name="mfieldofstudy" id="field" class="form-control" placeholder="Module Field of Study(required)" required>
	                    </div>
	                    <div id="mfieldofstudy_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                        <i class="fa fa-user"></i>
	                        <input type="text" value="{{ $type=='edit' ? $mod->mcoordinator : '' }}" name="mcoordinator" id="coord" list="coordinators" class="form-control" placeholder="Module Coordinator" required>
							<datalist id="coordinators">
							   <select onchange="$('#coord').val(this.value)">
							   	@foreach(User::where('rank', '>', '0')->where('rank', '!=', '3')
							   		->where('department', Auth::user()->department)->get() as $coord);
							   		<option label="{{ $type=='edit' ? $coord->username : $coord->username }}" value="{{ $type=='edit' ? $coord->name : $coord->name }}"></option>
								@endforeach
							   </select>
							</datalist>
	                    </div>
	                    <div id="mcoordinator_Errors" class="isa_error" style="display: none;"></div>
	                    <div id="rank_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                        <i class="fa fa-question"></i>
	                        <input type="text" name="mlevel" value="{{$type=='edit' ? $mod->mlevel : ''}}" id="level" list="levels" class="form-control" placeholder="Module Level" required>
							<datalist id="levels">
							   <select onchange="$('#level').val(this.value)">
								   <option value="Fundamental"></option>
								   <option value="Intermediate"></option>
								   <option value="Advanced"></option>
								   <option value="Expert"></option>
							   </select>
							</datalist>
	                    </div>
	                    <div id="mlevel_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                    	<i class="fa fa-sort-numeric-asc"></i>
	                    	<input type="number" value="{{ $type=='edit' ? $mod->mcredits : '' }}" name="mcredits" id="credits" class="form-control" placeholder="Module Credits Awarded" min="5" max="25" required>
	                    </div>
	                    <div id="mcredits_Errors" class="isa_error" style="display: none;"></div>
	                    <input type="hidden" name="mid" value="{{$type=='edit' ? $mod->mid : ''}}">
	                    <div class="form-group">
	                        <i class="fa fa-arrow-right"></i>
	                        <button type="submit" id="submit" class="btn btn-info btn-block">Submit new Module</button>
	                		{{Form::token()}}
	                    </div>
	                </fieldset>
	            </form>
	            <div id="successMessage"></div>
			</div>
		</div>
	</div>
</li>