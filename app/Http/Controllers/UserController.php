<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Photo;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->details->role == "admin")
        {
          $query = (new User())->newQuery();
          $korisnici = $query->orderBy('id')->get();
          return view('back.layouts.users.index')->with('korisnici',$korisnici);
        }
        else {
          return 'nešto drugo za obične uloge';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = new UserDetail();
      $user_id = auth()->user()->id;
      $stored = $user->validateRequest($request)->storeData($request,$user_id);
           
      if ($stored)
      {
        if ($request->hasFile('user_image')) {
          $path = Photo::imageUpload($request->file('user_image'), UserDetail::find($stored), 'users', 'avatar');
          $user->updateImagePath($user_id, $path);
      }
      return redirect('/profile')->with(['success' => 'Podaci o korisniku su uspješno spremljeni!']);
      }

      else
        return redirect()->back()->with(['error' => 'Uf! Došlo je do pogreške u spremanju podataka!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $korisnik = User::find($id);
      return view('back.layouts.users.korisnik')->with('korisnik',$korisnik);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $korisnik = User::find($id);
      return view('back.layouts.users.edit')->with('korisnik',$korisnik);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = UserDetail::where('user_id', $id)->first();
      $updated = $user->validateRequest($request)->updateData($request,$id);
      if ($updated)
      {
        if ($request->hasFile('user_image')) {
          $path = Photo::imageUpload($request->file('user_image'), $user, 'users', 'avatar');
          $user->updateImagePath($id, $path); 
      }
    
      if (auth()->user()->details->role == "admin")
      {
        return redirect('/home')->with(['success' => 'Podaci o korisniku su uspješno spremljeni!']);
      }
      else {
      return redirect('/profile')->with(['success' => 'Podaci o korisniku su uspješno spremljeni!']);
      }

      }

      else
       return redirect()->back()->with(['error' => 'Uf! Došlo je do pogreške u spremanju podataka!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $korisnik = User::find($id);
        $korisnik_detalji = UserDetail::where('user_id', $id)->first();
        if ($korisnik_detalji != NULL)
        {
          if ($korisnik_detalji->avatar != 'images/users/default-avatar.png')
          {
            Photo::imageDelete($korisnik_detalji, 'users', 'avatar');
          }
          $korisnik_detalji->delete();
        }
        $korisnik->delete();
        return redirect('/korisnici')->with(['success' => 'Korisnik je uspješno obrisan!']);
    }
    /* Ubaciti brisanje svih detalja korisnika-slika */
}
