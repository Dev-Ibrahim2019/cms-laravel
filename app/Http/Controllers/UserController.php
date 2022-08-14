<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', auth('user')->id())->paginate(12);
        return response()->view('cms.user.index', ["users"=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.user.create');
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
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make('secret');
            $user->active = $request->active;
            $isSaved = $user->save();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->view('cms.user.edit', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator($request->all(), [
            'name'=>'required||string||min:3||max:20',
            'email' => 'required||email',
            'active'=>'required||boolean'
        ]);
        if (!$validator->fails()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make('secret');
            $user->active = $request->active;
            $isUpdated = $user->save();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $isDeleted = $user->delete();
        if ($isDeleted) {
            return response()->json([
                'title'=>'Success',
                'text'=>'User Deleted successfully',
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
