@extends('layouts.front_layouts.front-master')
@section('content')

<section class="vh-100">
	<div class="container-fluid overflow-hidden p-0">
@php
header("Location: /login");
die();
@endphp
	</div>
</section>

@endsection
