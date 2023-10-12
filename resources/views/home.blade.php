@extends('layouts.back_layouts.back-master')
@section('content')
<p>
@if (!(auth()->user()->details))
<h4 class="text-center"><strong>Za potpuno korištenje platforme molimo vas uredite <a href="/profile" style="color:blue;">vaše korisničke podatke</a>!</strong></h4>
@endif
</p>
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
<h4>Dashboard</h4>
</div>
</div>
</div>

@endsection