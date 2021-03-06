<?php

namespace App\Http\Controllers;

use App\Attributes;
use App\Category;
use App\Subcategory;
use App\Subcategorytype;
use Illuminate\Support\Str;
use App\Product;
use App\UnitMaster;
use App\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public  function create(Request $request, $id)
    {
        $categories = Category::all();
        //
        if ($request->is('api/*')) {

            $response = [
                'id' => $id, 'categories' => $categories
            ];

            return response($response, 201);
        } else {
            return view('jobs.products.create', ['id' => $id, 'categories' => $categories]);
        }
    }

    public function getSubcategories(Request $request, $id)
    {

        echo json_encode(Subcategory::where('category_id', '=', $id)->get());;
    }

    public function getTypes(Request $request, $id)
    {
        echo json_encode(Subcategorytype::where('subcategory_id', '=', $id)->get());
    }

    public function getAttributes(Request $request, $id)
    {
        echo json_encode(Attributes::where('subcategorytype_id', '=', $id)->where('published', '=', 'Y')->get());
    }

    public function getUnits(Request $request)
    {
        echo json_encode(UnitMaster::all());
    }

    public function GetSubCatAgainstMainCatEdit(Request $request, $id)
    {
        echo json_encode(Subcategory::where('category_id', '=', $id)->get());
    }


    //Caching function
    public function cacheFields(){
        return response()->json([
            "id" => Cache::get("dynamic_fields"),
            "value" => Cache::get("dynamic_values")
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
            'sub_category_name' => 'string',
            'sub_category' => 'string',
            'subcategorytype_id' => 'required',
            'bu_code' => 'required|string|min:3',
            'wh_code' => 'required|string|min:3'
        ]);

        if($request->dynamic == null ){
            if ($request->is('api/*')) {
                $response = [
                    'status' => 'success',
                    'msg' => 'ERROR!!!! Attributes are not assigned to this type of subcategory! Kindly add them under the subcatgory>type> add attribute'
                ];

                return response($response, 201);
            }else{

            return back()->with('success', 'ERROR!!!! Attributes are not assigned to this type of subcategory! Kindly add them under the subcatgory>type> add attribute');

        }
        }

        //Caching dynamic fields
        Cache::set("dynamic_fields", $request->dynamic_storage);
        Cache::set("dynamic_values", $request->dynamic);

        // validation for dynamic form fields
        foreach ($request->dynamic as $key => $value) {
            $unit = null;
            $unit = DB::table('unit_masters')->where('name', $value['unit'])->first();

            if ($unit->type == 'alpha_num') {    //checking attribute value with type of unit

                $request->validate(
                    [
                        'dynamic.' . $key . '.value' => 'required|alpha_num',
                    ],
                    ['dynamic.' . $key . '.value.alpha_num' => 'The attribute field value ' . $value['value'] . ' must be alpha numeric.']
                );
            } elseif ($unit->type == 'numeric') {


                $request->validate(
                    [
                        'dynamic.' . $key . '.value' => 'required|numeric',
                    ],
                    ['dynamic.' . $key . '.value.numeric' => 'The attribute field value  ' . $value['value'] . ' must be numeric.']
                );
            }
        }




        //
        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();

            $product = Product::create([
                'job_id' => request('job_id'),
                'subcategorytype_id' => request('subcategorytype_id'),
                'material_id' => 'GRP-' . Str::substr(request('bu_code'), 0, 3) . '-' . Str::substr(request('wh_code'), 0, 3) . '-' . date("Y-m-d H:i:s", time()),
                'latitude' => request('latitude'),
                'longitude' => request('longitude'),
                'status' => 'N',
                'created_by' => $loggedinUser->email,
            ]);

            if (request('dynamic')) {

                foreach ($request->dynamic as $key => $value) {
                    // $validatedData = $request->validate([
                    //     'product_id' => 'required',
                    //     'name' => 'required',
                    //     'value' => 'required',
                    //     'unit' => 'required',
                    // ]);

                    ProductAttribute::create([

                        'product_id' => $product->id,
                        'name' => $value['name'],
                        'value' => $value['value'],
                        'unit' => $value['unit'],

                    ]);
                }
            }

            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new item!'
            ];

            return response($response, 201);
        } else {



            $product = Product::create([
                'job_id' => request('job_id'),
                'subcategorytype_id' => request('subcategorytype_id'),
                'material_id' => 'GRP-' . strtoupper(Str::substr(request('bu_code'), 0, 3)) . '-' . strtoupper(Str::substr(request('wh_code'), 0, 3)) . '-' . date("YmdHis", time()),
                'status' => 'N',
                'created_by' => Auth::user()->email,
            ]);

            if (request('dynamic')) {

                foreach ($request->dynamic as $key => $value) {
                    // $validatedData = $request->validate([
                    //     'dynamic['.$key.'][name]' => 'required',
                    //     'dynamic['.$key.'][value]' => 'required',
                    //     'dynamic['.$key.'][unit]' => 'required',
                    // ]);
                    ProductAttribute::create([

                        'product_id' => $product->id,
                        'name' => $value['name'],
                        'value' => $value['value'],
                        'unit' => $value['unit'],

                    ]);
                }
            }

            //Clearing cached data
            Artisan::call('cache:clear');

            return back()->with('success', 'Successfully inserted a new item!');
        }
        //
    }

    public function edit(Request $request, $id){

        $product = Product::find($id);

        if ($request->is('api/*')) {
            //write your logic for api call
            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser) {
                if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'editor', 'approver'])) {
                    $product = Product::find($id);
                    $units = UnitMaster::all();
                    $response = [
                        'status' => 'success',
                        'product' => $product,
                        'description' => $product->subcategorytype->subcategory->description,
                        'category' => $product->subcategorytype->subcategory->category->name,
                        'subcategory' => $product->subcategorytype->subcategory->name,
                        'subcategorytype' => $product->subcategorytype->name,
                        'subcategorytype_image' => $product->subcategorytype->image,
                        'attributes' => $product->productsattributes,
                        'units'=> $units
                    ];
                }
            }

            return response($response, 201);
        } else {
            if (Auth::user()) {
                if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'editor', 'approver'])) {
                    $product = Product::find($id);
                    $units = UnitMaster::all();
                    return view('jobs.products.edit',['product' => $product, 'units' => $units]);

                }

            }

        }



    }

    public function update(Request $request){
        
        //ddd($request->dynamic );
        // validation for dynamic form fields
        // foreach ($request->dynamic as $key => $value) {
        //     $unit = null;
        //     $unit = DB::table('unit_masters')->where('name', $value['unit'])->first();
        //     //dd($unit);

        //     if ($unit->type == 'alpha_num') {    //checking attribute value with type of unit
        //            ddd($request->dynamic[$key]);
        //         $request->validate(
        //             [
        //                 'dynamic.' . $key . '.value' => 'required|alpha_num',
        //             ],
        //             ['dynamic.' . $key . '.value.alpha_num' => 'The attribute field value ' . $value['value'] . ' must be alpha numeric.']
        //         );
        //     } elseif ($unit->type == 'numeric') {


        //         $request->validate(
        //             [
        //                 'dynamic.' . $key . '.value' => 'required|numeric',
        //             ],
        //             ['dynamic.' . $key . '.value.numeric' => 'The attribute field value  ' . $value['value'] . ' must be numeric.']
        //         );
        //     }
        // }

        foreach ($request->dynamic as $key => $value) {

            $product_attribute = ProductAttribute::find($value['productid']);
            $product_attribute->value = $value['value'] ;
            $product_attribute->unit = $value['unit'] ;
            $product_attribute->save();

        }
        if ($request->is('api/*')) {
            $response = [
                'status' => 'success',
                'msg' => 'Successfully updated product!'
            ];

            return response($response, 201);
        }else{
        return back()->with('success', 'Successfully updated item!');
    }

    }


    public function generateQr(Request $request, $id)
    {


        return view('jobs.products.generateqr', [
            'items' => Product::where('job_id', $id)->get(), 'height' => request('height'),
            'width' => request('width')
        ]);
    }

    public function show(Request $request, $id)
    {
        // $user = User::find($id);
        // $permissions = $user->getAllPermissions();
        // $role = $user->getRoleNames();
        $product = Product::find($id);

        if ($request->is('api/*')) {
            //write your logic for api call
            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser) {
                if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'editor', 'approver'])) {
                    $product = Product::find($id);
                    $response = [
                        'authorised' => 'Y',
                        'approved' => 'Y',
                        'product' => $product,
                        'description' => $product->subcategorytype->subcategory->description,
                        'category' => $product->subcategorytype->subcategory->category->name,
                        'subcategory' => $product->subcategorytype->subcategory->name,
                        'subcategorytype' => $product->subcategorytype->name,
                        'subcategorytype_image' => $product->subcategorytype->image,
                        'attributes' => $product->productsattributes
                    ];
                }
            } else {
                $product = Product::find($id);
                if ($product->status == 'Y') {

                    $response = [
                        'authorised' => 'N',
                        'approved' => 'Y',
                        'product' => $product,
                        'description' => $product->subcategorytype->subcategory->description,
                        'category' => $product->subcategorytype->subcategory->category->name,
                        'subcategory' => $product->subcategorytype->subcategory->name,
                        'subcategorytype' => $product->subcategorytype->name,
                        'subcategorytype_image' => $product->subcategorytype->image,
                        'attributes' => $product->productsattributes
                    ];
                } else {
                    $response = [
                        'authorised' => 'N',
                        'approved' => 'N',

                    ];
                }
            }

            return response($response, 201);
        } else {
            if (Auth::user()) {
                if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'editor', 'approver'])) {
                    $product = Product::find($id);
                    return view('jobs.products.show', ['product' => $product]);
                } else {
                    if ($product->status == 'Y') {
                        return view('jobs.products.show', ['product' => $product]);
                    } else {
                        return view('jobs.products.show', ['product' => NULL]);
                    }
                }
            } else {
                $product = Product::find($id);
                if ($product->status == 'Y') {
                    return view('jobs.products.show', ['product' => $product]);
                } else {
                    return view('jobs.products.show', ['product' => NULL]);
                }
            }
            //write your logic for web call

        }
    }

    public function showMId(Request $request)
    {   $id= Product::where('material_id', request('material_id') )->first();
       // $id = $id->id;
        //dd($id);
        if($id == null){
            if ($request->is('api/*')) {
                return response(['Material ID not found'], 201);
            }else{
                return back()->with('error', 'Material ID not found');
            }

        }
        $id = $id->id;
        // $user = User::find($id);
        // $permissions = $user->getAllPermissions();
        // $role = $user->getRoleNames();
        $product = Product::find($id);

        if ($request->is('api/*')) {
            //write your logic for api call
            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser) {
                if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'editor', 'approver'])) {
                    $product = Product::find($id);
                    $response = [
                        'authorised' => 'Y',
                        'approved' => 'Y',
                        'product' => $product,
                        'description' => $product->subcategorytype->subcategory->description,
                        'category' => $product->subcategorytype->subcategory->category->name,
                        'subcategory' => $product->subcategorytype->subcategory->name,
                        'subcategorytype' => $product->subcategorytype->name,
                        'subcategorytype_image' => $product->subcategorytype->image,
                        'attributes' => $product->productsattributes
                    ];
                }
            } else {
                $product = Product::find($id);
                if ($product->status == 'Y') {

                    $response = [
                        'authorised' => 'N',
                        'approved' => 'Y',
                        'product' => $product,
                        'description' => $product->subcategorytype->subcategory->description,
                        'category' => $product->subcategorytype->subcategory->category->name,
                        'subcategory' => $product->subcategorytype->subcategory->name,
                        'subcategorytype' => $product->subcategorytype->name,
                        'subcategorytype_image' => $product->subcategorytype->image,
                        'attributes' => $product->productsattributes
                    ];
                } else {
                    $response = [
                        'authorised' => 'N',
                        'approved' => 'N',

                    ];
                }
            }

            return response($response, 201);
        } else {
            if (Auth::user()) {
                if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'editor', 'approver'])) {
                    $product = Product::find($id);
                    return view('jobs.products.show', ['product' => $product]);
                } else {
                    if ($product->status == 'Y') {
                        return view('jobs.products.show', ['product' => $product]);
                    } else {
                        return view('jobs.products.show', ['product' => NULL]);
                    }
                }
            } else {
                $product = Product::find($id);
                if ($product->status == 'Y') {
                    return view('jobs.products.show', ['product' => $product]);
                } else {
                    return view('jobs.products.show', ['product' => NULL]);
                }
            }
            //write your logic for web call

        }
    }


    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'approver'])) {

                $product->delete();
                //write your logic for api call
                $response = [
                    'status' => 'success',
                    'msg' => 'Successfully deleted product!'
                ];

                return response($response, 201);
            }
        } else {
            if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product->delete();
                //write your logic for web call
                return back()->with('success', 'Successfully deleted product!');
            }
        }
    }

    public function approve(Request $request, $id)
    {
        if ($request->is('api/*')) {

            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product = Product::find($id);

                $product->update([
                    'status' => 'Y',
                ]);
                //write your logic for api call
                $response = [
                    'status' => 'success',
                    'msg' => 'Successfully updated approval!'
                ];

                return response($response, 201);
            }
        } else {
            if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product = Product::find($id);

                $product->update([
                    'status' => 'Y',
                ]);

                //write your logic for web call
                return redirect()->back();
            }
        }
    }


    public function reject(Request $request, $id)
    {
        //$some = $request->id;
        $product = Product::find($id);

        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();
            //write your logic for api call
            if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product->update([
                    'status' => 'R',
                    'rejectinfo' => request('rejectinfo')
                ]);
                $response = [
                    'status' => 'success',
                    'msg' => 'Successfully rejected!'
                ];

                return response($response, 201);
            }
        } else {
            //$products = Product::where('job_id', '=', $id)->get();
            if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product->update([
                    'status' => 'R',
                    'rejectinfo' => request('rejectinfo')
                ]);
                //write your logic for web call
                return redirect()->back();
            }
        }
    }

    public function listaction(Request $request){
        $items = $request->input('items');
        switch ($request->input('action')) {
            case 'approve':
                foreach($items as $item){
                    $this->approveall($request,$item);
                }
                if ($request->is('api/*')) {
                    $response = [
                        'status' => 'success',
                        'msg' => 'Successfully approved!'
                    ];
                    return response($response, 201);
                }else{
                    return redirect()->back();
                }
                break;

            case 'reject':
                foreach($items as $item){
                    $this->rejectall($request,$item);
                }
                if ($request->is('api/*')) {
                    $response = [
                        'status' => 'success',
                        'msg' => 'Successfully rejected!'
                    ];
                    return response($response, 201);
                }else{
                    return redirect()->back();
                }
                break;

            case 'delete':
                foreach($items as $item){
                    $this->destroyall($request,$item);
                }
                if ($request->is('api/*')) {
                    $response = [
                        'status' => 'success',
                        'msg' => 'Successfully deleted!'
                    ];
                    return response($response, 201);
                }else{
                    return redirect()->back();
                }
                break;
        }
    }

    public function approveall(Request $request, $id)
    {
        if ($request->is('api/*')) {

            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product = Product::find($id);

                $product->update([
                    'status' => 'Y',
                ]);
            }
        } else {
            if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product = Product::find($id);

                $product->update([
                    'status' => 'Y',
                ]);
            }
        }
    }

    public function rejectall(Request $request, $id)
    {
        //$some = $request->id;
        $product = Product::find($id);

        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();
            //write your logic for api call
            if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product->update([
                    'status' => 'R',
                    'rejectinfo' => request('rejectinfo')
                ]);
            }
        } else {
            //$products = Product::where('job_id', '=', $id)->get();
            if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product->update([
                    'status' => 'R',
                    'rejectinfo' => request('rejectinfo')
                ]);
                //write your logic for web call
               // return redirect()->back();
            }
        }
    }

    public function destroyall(Request $request, $id)
    {
        $product = Product::find($id);
        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser->hasAnyRole(['super-admin', 'admin', 'approver'])) {

                $product->delete();
            }
        } else {
            if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'approver'])) {
                $product->delete();
            }
        }
    }
}
