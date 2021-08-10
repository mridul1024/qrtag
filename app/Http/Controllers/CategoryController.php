<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->is('api/*')) {

            $categories = Category::orderBy('created_at', 'desc')->paginate(15);

            return response()->json($categories);

        } else {

            $categories = Category::orderBy('created_at', 'desc')->paginate(15);

            return view('category.index', ['categories' => $categories]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create' );
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
            'name' => 'required|string|max:255|unique:categories',

        ]);
        //    ddd(Auth::user()->email);

        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();

            Category::create([
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'description' => request('description'),
                'created_by' => $loggedinUser->email,
            ]);

            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new category!'
            ];

            return response($response, 201);
        } else {
            Category::create([
                'name' => strtoupper(Str::of(request('name'))->trim()),
                'description' => request('description'),
                'created_by' => Auth::user()->email,
            ]);

            //write your logic for web call
            return back()->with('success', 'Successfully inserted a new category!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $category = Category::find($id);

        if ($request->is('api/*')) {


            $response = [
                'category' => $category,
            ];

            return response($response, 201);
        } else {

            return view('category.edit', ['category' => $category]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$some = $request->id;
        $category = Category::find($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        $category->update([
            'name' => strtoupper(Str::of(request('name'))->trim()),
            'description' => $request->description,


        ]);


        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully updated category!'
            ];

            return response($response, 201);
        } else {

            //write your logic for web call
            return back()->with('success', 'Successfully updated category!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $category = Category::find($id);

        $category->delete();
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
