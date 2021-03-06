<?php

namespace App\Http\Controllers;

use App\UnitMaster;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UnitMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitmasters = UnitMaster::paginate(15);
        //
        if ($request->is('api/*')) {
            return response()->json($unitmasters);
        } else {
            return view('unitmaster.index', ['unitmasters' => $unitmasters]);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unitmaster.create');
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
            'name' => 'required|string|max:255|unique:unit_masters',
            'type' => 'required'

        ]);

        if ($request->is('api/*')) {

            $loggedinUser = User::where('email', $request->email)->first();

            UnitMaster::create([
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'type' => request('type'),
                'created_by' => $loggedinUser->email,
            ]);

            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new unit!'
            ];

            return response($response, 201);
        } else {
            UnitMaster::create([
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'type' => request('type'),
                'created_by' => Auth::user()->email,
            ]);
            //write your logic for web call
            return back()->with('success', 'Successfully inserted a new unit!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UnitMaster  $unitMaster
     * @return \Illuminate\Http\Response
     */
    public function show(UnitMaster $unitMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UnitMaster  $unitMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(UnitMaster $unitMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UnitMaster  $unitMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnitMaster $unitMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UnitMaster  $unitMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $unitMaster = UnitMaster::find($id);

        $unitMaster->delete();
        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully deleted unit!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return back()->with('success', 'Successfully deleted unit!');
        }
    }
}
