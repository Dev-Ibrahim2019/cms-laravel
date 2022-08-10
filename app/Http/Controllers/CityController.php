<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::orderby('id')->paginate(10);
        return view('cms.city.index', compact('cities'));
        // $cities = City::all();
        // return response()->view('cms.city.index', compact('cities'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required||String||min:3||max:20'
        ], [
            'name.required' => 'City Name field is required'
        ]);

       $city = new City();
       $city->name = $request->name;
       $isSaved = $city->save();
       if ($isSaved) {
        // return redirect()->route('cities.index');
        session()->flash('message', 'City created successfully');
        return redirect()->back();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return response()->view('cms.city.edit', ["city"=>$city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {

        $request->validate([
            'name'=>'required||String||min:3||max:20'
        ]);
        $city->name = $request->name;
        $isUpdated = $city->save();
        if ($isUpdated) {
            session()->flash('message', 'City Updated Successfully');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $isDeleted = $city->delete();
        if ($isDeleted) {
            return response()->json([
                'title'=>'Success',
                'text'=>'City Deleted Successfully',
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
