<?php

namespace App\Http\Controllers;

use App\AttributeMaster;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AttributeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attributeMasters = AttributeMaster::paginate(15);

        return view('attribute.master_list.index', ['attributemasters' => $attributeMasters]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attribute.master_list.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:attribute_masters',

        ]);
        //dd(request('subcategory_id'));
        //ddd(Auth::user()->email);

        AttributeMaster::create([
            'name' => strtoupper(Str::of(request('name'))->trim()),
            'created_by' => Auth::user()->email,
        ]);

        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new attribute!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return back()->with('success', 'Successfully inserted a new attribute!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AttributeMaster  $attributeMaster
     * @return \Illuminate\Http\Response
     */
    public function show(AttributeMaster $attributeMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AttributeMaster  $attributeMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributeMaster $attributeMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AttributeMaster  $attributeMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributeMaster $attributeMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AttributeMaster  $attributeMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $attributeMaster = AttributeMaster::find($id);

        $attributeMaster->delete();
        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully deleted category!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return back()->with('success', 'Successfully deleted category!');
        }
    }
}
