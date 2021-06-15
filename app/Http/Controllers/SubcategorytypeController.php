<?php

namespace App\Http\Controllers;

use App\Subcategorytype;
use App\Subcategory;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

class SubcategorytypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);

        if ($request->is('api/*')) {


            $subcategorytypes = Subcategorytype::find($id)->get()->paginate(15);


            return response()->json($subcategorytypes);
        } else {

            $subcategorytypes = Subcategorytype::where('subcategory_id', '=', $id)->paginate(10);
            //ddd($subcategorytypes);
            return view('subcategory.type.index', ['subcategorytypes' => $subcategorytypes, 'subcategory' => $subcategory]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);
        if ($request->is('api/*')) {
            return response()->json($subcategory);
        } else {
            return view('subcategory.type.create', ['subcategory' => $subcategory] );
        }

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
            'image' => 'image'
        ]);

        $image = NULL;
        if(request('image')) {
                $image = request('image')->store('subcategorytype_images');
        }

        //    ddd(Auth::user()->email);

        if ($request->is('api/*')) {

            $loggedinUser = User::where('email', $request->email)->first();
            Subcategorytype::create([
                'subcategory_id' => request('subcategory_id'),
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'image' => $image,
                'qrcode' => request('qrcode'),
                'created_by' => $loggedinUser->email,
            ]);
            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new type!'
            ];

            return response($response, 201);
        } else {
            Subcategorytype::create([
                'subcategory_id' => request('subcategory_id'),
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'image' => $image,
                'qrcode' => request('qrcode'),
                'created_by' => Auth::user()->email,
            ]);
            //write your logic for web call
            return back()->with('success', 'Successfully inserted a new type!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategorytype  $subcategorytype
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        $subcategorytype = Subcategorytype::find($id);

        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'subcategorytype' => $subcategorytype,
                'pattributes' => $subcategorytype->attributes->where('published','Y'),
                'nattributes' => $subcategorytype->attributes->where('published','N')
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return view('subcategory.type.show', ['subcategorytype' => $subcategorytype, 'pattributes' => $subcategorytype->attributes->where('published','Y'),'nattributes' => $subcategorytype->attributes->where('published','N')]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategorytype  $subcategorytype
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $subcategorytype = Subcategorytype::find($id);


        if ($request->is('api/*')) {


            $response = [
                'subcategorytype' => $subcategorytype,
                            ];

            return response($response, 201);
        } else {

            return view('subcategory.type.edit', ['subcategorytype' => $subcategorytype]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategorytype  $subcategorytype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //$some = $request->id;
       $subcategorytype= Subcategorytype::find($id);

       $validatedData = $request->validate([
           'name' => 'required|string|max:255',

       ]);
       $image = NULL;
       if (request('image')) {
          Storage::delete($subcategorytype->image);
           $image = request('image')->store('subcategorytype_images');
       }
       $subcategorytype->update([
        'name' => strtoupper(Str::of(request('name'))->trim()),

        'image' => $image,
       ]);


       if ($request->is('api/*')) {
           //write your logic for api call
           $response = [
               'status' => 'success',
               'msg' => 'Successfully updated!'
           ];

           return response($response, 201);
       } else {
           //write your logic for web call
           return back()->with('success', 'Successfully updated!');
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategorytype  $subcategorytype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $subcategorytype = Subcategorytype::find($id);
        Storage::delete($subcategorytype->image);
        $subcategorytype->delete();
        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully deleted!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return back()->with('success', 'Successfully deleted!');
        }
    }
}
