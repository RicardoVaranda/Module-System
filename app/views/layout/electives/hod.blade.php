<li class="mix all"> 
	<a data-toggle="modal" role="button" href="{{ $type=='edit' ? '#editElec'.$elec->classid : '#newElec'}}"> <img src="{{ $type=='edit' ? URL::route('getImg', $elec->module->mcode) : URL::route('getImg', 'newElec')}}" alt="portfolio">
		<div><span>{{ $type=='edit' ? $elec->module->mshorttitle : 'Create new Elective'}}</span></div>
	</a>
	<div class="modal fade" id="{{ $type=='edit' ? 'editElec'.$elec->classid : 'newElec'}}" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div  class="contact-box">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            <form name="contactform" id="{{ $type=='edit' ? 'editFormElec' : 'newFormElec'}}" action="{{ $type=='edit' ? URL::route('module-change-post') : URL::route('module-new-post') }}" method="post">
	                <fieldset>
	                    <h4 class="h4">{{ $type=='edit' ? 'Edit Elective' : 'Create new Elective'}}</h4>
	                    <div class="form-group">
	                        <i class="fa fa-user"></i>
	                        <input type="text" value="{{ $type=='edit' ? User::find($elec->classlecturer)->first()->name : '' }}" name="classlecturer" id="lect" list="lecturers" class="form-control" placeholder="Elective Lecturer" required>
							<datalist id="lecturers">
							   <select onchange="$('#lect').val(this.value)">
							   	@foreach(User::where('rank', '>', '0')->where('rank', '!=', '3')
							   		->where('department', Auth::user()->department)->get() as $coord);
							   		<option label="{{ $coord->username }}" value="{{ $coord->name }}"></option>
								@endforeach
							   </select>
							</datalist>
	                    </div>
	                    <div id="classlecturer_Errors" class="isa_error" style="display: none;"></div>
	                    <div id="rank_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                        <i class="fa fa-question"></i>
	                        <input type="text" name="classmodule" value="{{$type=='edit' ? $elec->classmodule : ''}}" id="module" list="modules" class="form-control" placeholder="Class Module" required>
							<datalist id="modules">
							   <select onchange="$('#module').val(this.value)">
								   <option value="BIG ASS FORLOOP HERE LELELELEL"></option>
							   </select>
							</datalist>
	                    </div>
	                    <div id="classmodule_Errors" class="isa_error" style="display: none;"></div>
	                    <div class="form-group">
	                    	<i class="fa fa-sort-numeric-asc"></i>
	                    	<input type="number" value="{{ $type=='edit' ? $elec->classlimit : '' }}" name="classlimit" id="limit" class="form-control" placeholder="Class Limit" min="5" max="30" required>
	                    </div>
	                    <div id="classlimit_Errors" class="isa_error" style="display: none;"></div>
	                    <input type="hidden" name="classid" value="{{$type=='edit' ? $elec->classid : ''}}">
	                    <div class="form-group">
	                        <i class="fa fa-arrow-right"></i>
	                        <button type="submit" id="submit" class="btn btn-info btn-block">Save Elective</button>
	                		{{Form::token()}}
	                    </div>
	                </fieldset>
	            </form>
	            <div id="successMessage"></div>
			</div>
		</div>
	</div>
</li>