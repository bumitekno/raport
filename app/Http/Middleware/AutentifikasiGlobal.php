<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Teacher;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutentifikasiGlobal
{

    public function decript($ciphertext,$key)
    {
        $result = '';
        for ($i = 0; $i < strlen($ciphertext); $i++) {
            $char = $ciphertext[$i];
            $ascii = ord($char);
          
            // Pergeseran huruf
            if ($ascii >= 65 && $ascii <= 90) {
              $ascii -= $key;
              if ($ascii < 65) {
                $ascii += 26;
              }
            } else if ($ascii >= 97 && $ascii <= 122) {
              $ascii -= $key;
              if ($ascii < 97) {
                $ascii += 26;
              }
            }
          
            $result .= chr($ascii);
        }
        return $result;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        //Jika belum login master
        if(!isset($_COOKIE['ACC'])){
            $externalUrl = 'http://localhost:3000';
    
            // Mengarahkan pengguna ke URL eksternal
            return redirect($externalUrl);
        }else{ 

            $data = $this->decript(urldecode($_COOKIE['ACC']),3);
            //$data = urldecode($_COOKIE['ACC']);
            
            $data = explode("/",$data);

            $role = $data[1];
            $email = $data[0];
            //dd($email);

            if (Auth::guard('admin')->check()) {
                return $next($request);
            } else if (Auth::guard('user')->check()) {
                return $next($request);
            } else if (Auth::guard('teacher')->check()) {
                return $next($request);
            } else if (Auth::guard('parent')->check()) {
                return $next($request);
            } 

            if($role == 'admin'){
                $user = Admin::where('email', $email)->first();
                Auth::guard('admin')->loginUsingId($user->id);
                return $next($request);

            }elseif($role == 'guru'){
                $user = Teacher::where('email', $email)->first();
                Auth::guard('teacher')->loginUsingId($user->id);
                return $next($request);
            }else{
                $user = User::where('email', $email)->first();
                Auth::guard('user')->loginUsingId($user->id);
                return $next($request);
            }

            
           

        }

       
    }

   
}
