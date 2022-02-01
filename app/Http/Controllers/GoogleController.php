<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;
use Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback()
    {
        try {
      
            $user = Socialite::driver('google')->stateless()->user();
       
            $finduser = User::where('google_id', $user->id)->first();
       
            if($finduser){
       
                Auth::login($finduser);
      
                return redirect()->route('home');
       
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => Hash::make('password')
                ]);

                $newUser->syncRoles(['Pendaftar']);
                $permissionsByRole = $newUser->getPermissionsViaRoles()->pluck('id');
                $newUser->syncPermissions($permissionsByRole);
      
                Auth::login($newUser);
      
                return redirect()->route('home');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
