<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function showLogin($guard){
        return response()->view('cms.login', ['guard' => $guard]);
    }
    public function login(Request $request){
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:admins,email', //if (email exists in admins table)
            'password' => 'required|string|min:6',
            'remember' => 'required|boolean',
            'guard' => 'required|String|in:admin,user'
        ], [
            'guard.in' => 'Please, Check Login URL'
        ]);
        if (!$validator->fails()){
            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ];

            if (Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
                return response()->json([
                        'message' => 'Logged in successfully'
                    ], Response::HTTP_OK);
            }else {
                return response()->json([
                    'message' => 'Login faild, wrong credentials'
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    // public function login(Request $request){
    //     $validator = Validator($request->all(), [
    //         'email' => 'required|email|exists:admins,email', //if (email exists in admins table)
    //         'password'=> 'required|string|min:3|max:30',
    //     ]);
    //     if (!$validator->fails()){
    //         $credentials = [
    //             'email' => $request->get('email'),
    //             'password' => $request->get('password')
    //         ];
    //         if (Auth::guard('admin')->attempt($credentials, $request->get('remember'))) {
    //             return response()->json([
    //                 'message' => 'Logged in successfully'
    //             ], Response::HTTP_OK);
    //         } else {
    //             return response()->json([
    //                 'message' => 'Login faild, wrong credentials'
    //             ], Response::HTTP_BAD_REQUEST);
    //         }
    //     } else {
    //         return response()->json([
    //             'message' => $validator->getMessageBag()->first()
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    // }
    public function logout(Request $request){
        // Auth::guard('admin')->logout();

        // if (Auth::guard('admin')->check()){
        //     auth('admin')->logout();
        //     $request->session()->invalidate();
        //     return redirect()->route('login');
        // } else {
        //     auth('user')->logout();
        //     $request->session()->invalidate();
        //     return redirect()->route('login');
        // }
        $guard = auth('admin')->check() ? 'admin' : 'user';
        auth($guard)->logout();
        $request->session()->invalidate();
        return redirect()->route('login', $guard);
    }

    public function editPassword(){
        return response()->view('cms.auth.change-password');
    }

    public function updatePassword (Request $request) {
        $guard = auth('admin')->check() ? 'admin' : 'user';
        $validator = Validator($request->all(), [
            'current_password' => "required|String|current_password:$guard",
            'new_password' => 'required|String|confirmed',
        ]);
        if (!$validator->fails()) {
            $user = auth($guard)->user();
            $user->password  = Hash::make($request->get('new_password'));
            $isSaved = $user->save();
            return response()->json([
                'message' => $isSaved ? 'Password Changed Successfully' : 'Faild to change'
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function editProfile() {
        // if (auth('admin')->check()) {
        //     return response()->view('cms.admin.edit', auth('admin')->user());
        // } else if (auth('user')->check()) {
        //     // return response()->view('cms.user.edit', auth('user')->user());
        // }
        $view = auth('admin')->check() ? 'cms.admin.edit' : 'cms.user.edit';
        $guard = auth('admin')->check() ? 'admin' : 'user';
        return response()->view($view, [$guard => auth($guard)->user()]);
    }
    public function updateProfile(Request $request) {

    }

}
