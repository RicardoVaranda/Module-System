<html>
<head></head>
<body>
	<h1>Testing</h1>
	@foreach(Modules::where('melective', 1)->get() as $mod)
		{{$mod->mshorttitle}} belongs to department: {{ $mod->department->name() }}
	@endforeach
</body>
<html>