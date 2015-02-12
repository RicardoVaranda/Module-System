@extends('layout.main')

@section('content')
	<p>{{ e($user ->username) }} ({{ e($user ->email) }})</p>
@stop