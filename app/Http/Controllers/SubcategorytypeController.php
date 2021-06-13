<?php

namespace App\Http\Controllers;

use App\Subcategorytype;
use App\Subcategory;
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

        return view('subcategory.type.create', ['subcategory' => $subcategory] );
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
        Subcategorytype::create([
            'subcategory_id' => request('subcategory_id'),
            'name' => strtoupper(Str::of(request('name'))->trim()),
            'image' => $image,
            'qrcode' => request('qrcode'),
            'created_by' => Auth::user()->email,
        ]);

        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new type!'
            ];

            return response($response, 201);
        } else {
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
        // $user = User::find($id);
        // $permissions = $user->getAllPermissions();
        // $role = $user->getRoleNames();
        $subcategorytype = Subcategorytype::find($id);

        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                // 'status' => 'success',
                // 'user' => $user,
                // 'role' => $role,
                // 'permissions' => $permissions
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return view('subcategory.type.show', ['subcategorytype' => $subcategorytype, 'pattributes' => $subcategorytype->attributes->where('published','Y'),'nattributes' => $subcategorytype->attributes->where('published','N')]);
        }
    }

    // public function generateQr(Request $request){
    //    // $image = new \ImagickPixel(QrCode::format('svg')->size(150)->generate( request('qrcode')));

    //     // $image =;
    //    // dd($image);
    //    // $imagepath = ->store('qr_images');
    //    //$path = $image->store('qrcodes');
    //    $path = Storage::putFile('qrcodes', $image);
    //    // $path = (String)$image->store('avatars');
    //     $affected = DB::table('subcategorytypes')
    //           ->where('id', request('id'))
    //           ->update(['qrcode' => $path]);

    //     return redirect( request('subcategory_id'));

    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategorytype  $subcategorytype
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategorytype $subcategorytype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategorytype  $subcategorytype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategorytype $subcategorytype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategorytype  $subcategorytype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategorytype $subcategorytype)
    {
        //
    }
}
