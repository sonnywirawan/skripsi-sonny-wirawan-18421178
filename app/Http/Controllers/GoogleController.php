<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;
use Hash;
use Alert;

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
            $findemail = User::where('email', $user->email)
                            ->whereNull('google_id')->first();
            if($findemail) {
                Alert::error('Error', 'Email is already registered!');
                return redirect()->route('login');
            }

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
