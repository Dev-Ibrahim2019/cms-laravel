<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::where('id', '!=', auth('admin')->id())->paginate(12);
        return response()->view('cms.admin.index', ["admins"=>$admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name'=>'required||string||min:3||max:20',
            'email' => 'required||email',
            'active'=>'required||boolean'
        ]);
        if (!$validator->fails()) {
            //TODO: CREATE NEW CATEGORY
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make('secret');
            $admin->active = $request->active;
            $isSaved = $admin->save();
            Mail::to($admin->email)->send(new WelcomeEmail($admin));
            return response()->json([
                'message'=>$isSaved ? 'Saved Successfully' : 'Failed to save'
            ], $isSaved? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            // VALIDATION FAILED
            return response()->json([
                'message'=>$validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return response()->view('cms.admin.edit', ['admin'=>$admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validator = Validator($request->all(), [
            'name'=>'required||string||min:3||max:20',
            'email' => 'required||email',
            'active'=>'required||boolean'
        ]);
        if (!$validator->fails()) {
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make('secret');
            $admin->active = $request->active;
            $isUpdated = $admin->save();
            return response()->json([
                'message'=>$isUpdated ? 'Updated Successfully' : 'Failed to Update'
            ], $isUpdated? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
            // VALIDATION FAILED
            return response()->json([
                'message'=>$validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $isDeleted = $admin->delete();
        if ($isDeleted) {
            return response()->json([
                'title'=>'Success',
                'text'=>'Admin Deleted successfully',
                'icon'=>'success'
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'title'=>'Failed',
                'text'=>'Failed to delete',
                'icon'=>'error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
