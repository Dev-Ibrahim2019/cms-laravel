<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::paginate(12);
        return response()->view('cms.spatie.permissions.index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.spatie.permissions.create');
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
            'name'=>'required||string||min:3||max:120',
            'guard_name' => 'required||string||in:admin,user',
        ]);
        if (!$validator->fails()) {
            $permission = new Permission();
            $permission->name = $request->get('name');
            $permission->guard_name = $request->get('guard_name');
            $isSaved = $permission->save();
            return response()->json([
                'message'=>$isSaved ? 'Saved Successfully' : 'Failed to save'
            ], $isSaved? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
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
    public function edit(Permission $permission)
    {
        return response()->view('cms.spatie.permissions.edit', ['permission'=>$permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator($request->all(), [
            'name'=>'required||string||min:3||max:120',
            'guard_name' => 'required||string||in:admin,user',
        ]);
        if (!$validator->fails()) {
            $permission->name = $request->get('name');
            $permission->guard_name = $request->get('guard_name');
            $isSaved = $permission->save();
            return response()->json([
                'message'=>$isSaved ? 'Updated Successfully' : 'Failed to udate'
            ], $isSaved? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } else {
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
    public function destroy(Permission $permission)
    {
        $isDeleted = $permission->delete();
        if ($isDeleted) {
            return response()->json([
                'title'=>'Success',
                'text'=>'Role Deleted successfully',
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
