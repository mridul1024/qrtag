<?php

namespace App\Http\Controllers;

use App\Attributes;
use App\AttributeMaster;
use App\UnitMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $attributeMasters = AttributeMaster::all();

        $unitmasters = UnitMaster::all();

        return view('attribute.create', ['id' => $id, 'attributemasters' => $attributeMasters, 'unitmasters' => $unitmasters]);
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
            'name' => 'required|string|max:255',
            

        ]);
        //dd(request('subcategory_id'));
        //ddd(Auth::user()->email);

        Attributes::create([
            'name' => strtoupper(Str::of(request('name'))->trim()),
            'value' => request('value'),

            'subcategorytype_id' => request('subcategorytype_id'),
            'published' => 'Y',
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
     * @param  \App\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function show(Attributes $attributes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function edit(Attributes $attributes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attributes $attributes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $Attributes = Attributes::find($id);

        $Attributes->delete();
        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully deleted attribute!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return back()->with('success', 'Successfully deleted Attribute!');
        }

    }
}
