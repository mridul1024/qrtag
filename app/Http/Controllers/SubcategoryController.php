<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subcategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        if ($request->is('api/*')) {


            $subcategories = Subcategory::orderBy('created_at', 'desc')->paginate(15);
            $response = [
                'subcategories' => $subcategories,
                'categories' => $categories,
            ];

            return response($response, 201);
        } else {

            $subcategories = Subcategory::orderBy('created_at', 'desc')->paginate(15);
            return view('subcategory.index', ['subcategories' => $subcategories, 'categories' => $categories]);
        }
    }

    public function indexById(Request $request, $id)
    {
        $categories = Category::all();
        if ($request->is('api/*')) {

            $subcategories = Subcategory::orderBy('created_at', 'desc')->where('category_id', '=', $id)->paginate(15);

            $response = [
                'subcategories' => $subcategories,
                'categories' => $categories,
            ];

            return response($response, 201);
        } else {

            $subcategories = Subcategory::orderBy('created_at', 'desc')->where('category_id', '=', $id)->paginate(15);

            return view('subcategory.index', ['subcategories' => $subcategories, 'categories' => $categories]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        if ($request->is('api/*')) {
            return response()->json($categories);
        } else {
            return view('subcategory.create', ['categories' => $categories]);
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

        if ($request->is('api/*')) {

            $validatedData = $request->validate([
                'category_id' => 'required',
                'name' => 'required|string|max:255|unique:subcategories,name',
                'image' => 'string'
            ]);

            $imageNamepath = NULL;

            if (request('image')) {
                $image = request('image');  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName1 = Str::random(20) . '.png';
                $imageNamepath = 'subcategory_images/' . $imageName1;
                $imageName = 'public/subcategory_images/' . $imageName1;
                Storage::disk('local')->put($imageName, base64_decode($image));
            }

            $loggedinUser = User::where('email', $request->email)->first();
            Subcategory::create([
                'category_id' => request('category_id'),
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'description' => request('description'),
                'image' => $imageNamepath,

                'created_by' => $loggedinUser->email,
            ]);
            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new category!'
            ];

            return response($response, 201);
        } else {
            $validatedData = $request->validate([
                'category_id' => 'required',
                'name' => 'required|string|max:255|unique:subcategories,name',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
            $image = NULL;
            if (request('image')) {

                $image = request('image')->store('subcategory_images');
            }

            Subcategory::create([
                'category_id' => request('category_id'),
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'description' => request('description'),
                'image' => $image,

                'created_by' => Auth::user()->email,
            ]);
            //write your logic for web call
            return back()->with('success', 'Successfully inserted a new subcategory!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // $user = User::find($id);
        // $permissions = $user->getAllPermissions();
        // $role = $user->getRoleNames();
        $subcategory = Subcategory::find($id);

        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'subcategory' => $subcategory, 'attributes' => $subcategory->attributes
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return view('subcategory.show', ['subcategory' => $subcategory, 'attributes' => $subcategory->attributes]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);
        $categories = Category::all();

        if ($request->is('api/*')) {


            $response = [
                'subcategory' => $subcategory,
                'categories' => $categories
            ];

            return response($response, 201);
        } else {

            return view('subcategory.edit', ['categories' => $categories, 'subcategory' => $subcategory]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$some = $request->id;
        $subcategory = Subcategory::find($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

        ]);


        if ($request->is('api/*')) {
            $imageNamepath = NULL;

            if (request('image')) {

                Storage::delete($subcategory->image);
                $image = request('image');  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName1 = Str::random(20) . '.png';
                $imageNamepath = 'subcategory_images/' . $imageName1;
                $imageName = 'public/subcategory_images/' . $imageName1;
                Storage::disk('local')->put($imageName, base64_decode($image));
            }
            $subcategory->update([
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'description' => request('description'),
                'image' => $imageNamepath,
            ]);
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully updated!'
            ];

            return response($response, 201);
        } else {
            $image = NULL;
            if (request('image')) {
                Storage::delete($subcategory->image);
                $image = request('image')->store('subcategory_images');
            }
            $subcategory->update([
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'description' => request('description'),
                'image' => $image,
            ]);

            //write your logic for web call
            return back()->with('success', 'Successfully updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);
        Storage::delete($subcategory->image);
        $subcategory->delete();
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
