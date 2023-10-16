@extends('layouts.back_layouts.back-master')
@section('content')
@php
$korisnik = auth()->user()->details;
$roles = array('admin','trainee','coach');
if ($korisnik)
{
$ime = $korisnik->fname;
$prezime= $korisnik->lname;
$slika = $korisnik->avatar;
$role = $korisnik->role;
}
else
{
$ime = "";
$prezime= "";
$slika = "images/users/default-avatar.png";
$role = "admin";
echo '<h4 class="text-center"><strong>Za potpuno korištenje platforme molimo vas uredite vaše korisničke
        podatke</strong></h4>';
}

@endphp

<div class="card card-primary">
    <div class="card-header t-head">
        <h3 class="card-title">{{ __('About')}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @if ($korisnik)
    <form enctype="multipart/form-data" action="{{ route('users.update', auth()->user()->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('patch') }}
        @else
        <form enctype="multipart/form-data" action="{{route('users.store')}}" method="POST">
            {{ csrf_field() }}
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group align-center">
                            <label for="profile_image">{{ __('Choose new profile photo')}}</label>
                            <br>
                            <img class="align-center img-responsive img-thumbnail" id="output" name="user_image"
                                src="{{asset($slika)}}"  width="250" alt="profile-image">
                                <br>
                            <input type="file" class="form-control-file pt-2" name="user_image"
                            accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name"><b>{{ __('Name:')}} @include('layouts.back_layouts.partials.required-star')</b></label>
                            <input type="text" class="form-control" name="user_fname" value="{{$ime}}" required>
                        </div>
                        <div class="form-group">
                            <label for="name"><b>{{ __('Surname:')}}</b></label>
                            <input type="text" class="form-control" name="user_lname" value="{{$prezime}}">
                        </div>

                        @if ($role == "admin")
                        <div class="form-group">
                            <label for="uloga"><b>{{ __('Role:')}}</b></label>
                            <select name="user_role" class="form-control">
                                @foreach ($roles as $uloga)
                                @if ($uloga == $role)
                                <option value="{{$uloga}}" selected>{{$uloga}}</option>
                                @else
                                <option value="{{$uloga}}">{{$uloga}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                                          
                        @else
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="user_role" value="{{$role}}">
                         </div>
                        @endif
                        <!-- endif admin -->
                        @if ($role != 'admin')
                        <div class="form-group">
                            <label for="status"><strong>Status:</strong> <em>
                                    @if ($role == 'trainee')
                                    Trainee
                                    @elseif ($role == 'coach')
                                    Coach
                                    @endif
                                </em></label><br>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row text-end"><div class="col-md-12"><button type="submit" class="btn btn-primary gumb">{{ __('Save')}}</button></div></div>
            </div>
        </form>
</div>
<!-- /.card -->
@endsection