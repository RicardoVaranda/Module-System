{{ HTML::style('css/style.css') }}

@if(!Request::ajax())
	{{ HTML::script('js/jquery-1.10.2.min.js') }}
@endif

<script type="text/javascript">
	
	$(document).ready(function(){
		times = [{{$elec->classtimes}}];
		$("#classesPerWeek").val(times.length);
		$("#classTimesThisWeek").text(times);
		for(var i = 0; i < times.length; i++){
			switch(times[i][0]){
				case 'monday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(1)").text(times[i][2]);
				break;
				case 'tuesday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(2)").text(times[i][2]); 
				break;
				case 'wednesday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(3)").text(times[i][2]);
				break;
				case 'thursday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(4)").text(times[i][2]); 
				break;
				case 'friday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(5)").text(times[i][2]); 
				break;
			}
		}
	});

</script>
	<?php $mod = Modules::find($elec->classmodule);?>
	<input type="hidden" id="classesPerWeek">
	<input type="hidden" id="classTimesThisWeek">
<div class="col-sm-12 custTable">
    <table id="timetable" class="heavyTable">
    	<thead>
    		<tr>
    			<th colspan="6"><h1>{{$mod->mshorttitle}}</h1><h4>ID:<code id="classId">{{$elec->classid}}</code>  --   Spaces Available: {{($elec->classlimit-$elec->classcurrent)}}</h4></th>
    		</tr>
    	</thead>
		<thead>
			<tr id="days">
				<th></th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
			</tr>
		</thead>
		<tbody>
			<tr id="9">
				<td class="time">9:00</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr id="10">
				<td class="time">10:00</td>
				<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
			<tr id="11">
			  	<td class="time">11:00</td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
			<tr id="12">
			  	<td class="time">12:00</td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
			<tr id="13">
			  	<td class="time">13:00</td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
			<tr id="14">
			  	<td class="time">14:00</td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
			<tr id="15">
			  	<td class="time">15:00</td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
			<tr id="16">
			  	<td class="time">16:00</td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
			<tr id="17">
			  	<td class="time">17:00</td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			  	<td></td>
			</tr>
		</tbody>
    </table>
</div>