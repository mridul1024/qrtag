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


class ProductController extends Controller {
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



            return view('jobs.products.create',['id' => $id, 'categories' => $categories]);

        }

    }

    public function getSubcategories(Request $request, $id){

        echo json_encode(Subcategory::where('category_id','=',$id)->get());
;
    }

    public function getTypes(Request $request, $id)
    {
        echo json_encode(Subcategorytype::where('subcategory_id','=',$id)->get());
    }

    public function getAttributes(Request $request, $id)
    {
        echo json_encode(Attributes::where('subcategorytype_id','=',$id)->get());
    }

    public function getUnits(Request $request)
    {
        echo json_encode(UnitMaster::all());
    }

    public function GetSubCatAgainstMainCatEdit(Request $request,$id){
        echo json_encode(Subcategory::where('category_id','=',$id)->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'job_id' => 'required',
            'subcategorytype_id' => 'required',
        ]);

        //dd(request('dynamic'));



            //
            if ($request->is('api/*')) {
                $loggedinUser = User::where('email', $request->email)->first();

                $product = Product::create([
                    'job_id' => request('job_id'),
                    'subcategorytype_id' => request('subcategorytype_id'),
                    'material_id' => time().'-'.Str::random(10),
                    'latitude' => request('latitude'),
                    'longitude' => request('longitude'),
                    'status' => 'N',
                    'created_by' => $loggedinUser->email,
                ]);

                if(request('dynamic')){

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
                    'material_id' => time().'-'.Str::random(10),
                    'status' => 'N',
                    'created_by' => Auth::user()->email,
                ]);

                if(request('dynamic')){

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


                    return back()->with('success', 'Successfully inserted a new item!');

            }
            //
     }


//      public function generateQr(Request $request){
//         // //  $path = QrCode::size(500)
//         // //  ->format('png')
//         // //  ->generate(request('qrcode'), public_path('images/qrcode.png'));
//         // $image = QrCode::format('eps')->generate(request('qrcode'));
//         //dd($image);
//          $path = QRCode::text('QR Code Generator for Laravel!')->png()->store('product_qrcodes');

//    // $result = ;
//         dd($result);
//          $affected = DB::table('products')
//                ->where('id', request('id'))
//                ->update(['qrcode' => $path]);

//          return route('/product/show/' + request('id'));

//      }

     public function show(Request $request, $id)
     {
         // $user = User::find($id);
         // $permissions = $user->getAllPermissions();
         // $role = $user->getRoleNames();
         $product = Product::find($id);

         if ($request->is('api/*')) {
             //write your logic for api call
             $loggedinUser = User::where('email', $request->email)->first();
             if($loggedinUser){
                 if($loggedinUser->hasAnyRole(['super-admin','admin','editor']) ){
                    $product = Product::find($id);
                    $response = [
                       'authorised' => 'Y',
                       'approved' => 'Y',
                       'product' => $product,
                       'category' => $product->subcategorytype->subcategory->category->name,
                       'subcategory' => $product->subcategorytype->subcategory->name,
                       'subcategorytype' => $product->subcategorytype->name,
                       'subcategorytype_image' =>$product->subcategorytype->image ,
                       'attributes' => $product->productsattributes
                    ];

                 }
             }else{
                $product = Product::find($id);
                if($product->status == 'Y'){

                    $response = [
                       'authorised' => 'N',
                       'approved' => 'Y',
                       'product' => $product,
                       'category' => $product->subcategorytype->subcategory->category->name,
                       'subcategory' => $product->subcategorytype->subcategory->name,
                       'subcategorytype' => $product->subcategorytype->name,
                       'subcategorytype_image' =>$product->subcategorytype->image ,
                       'attributes' => $product->productsattributes
                    ];

                }else{
                    $response = [
                        'authorised' => 'N',
                        'approved' => 'N',

                    ];
                }
             }

             return response($response, 201);
         } else {
            if(Auth::user()){
                if(Auth::user()->hasAnyRole(['super-admin','admin','editor']) ){
                   $product = Product::find($id);
                   return view('jobs.products.show', ['product' => $product ]);
                }
            }else{
               $product = Product::find($id);
               if($product->status == 'Y'){
                return view('jobs.products.show', ['product' => $product ]);


               }else{
                return view('jobs.products.show', ['product' => NULL ]);
               }
            }
             //write your logic for web call

         }
     }

     public function destroy(Request $request,$id)
     {
         $product = Product::find($id);

         $product->delete();
         if ($request->is('api/*')) {
             //write your logic for api call
             $response = [
                 'status' => 'success',
                 'msg' => 'Successfully deleted product!'
             ];

             return response($response, 201);
         } else {
             //write your logic for web call
             return back()->with('success', 'Successfully deleted product!');
         }
     }

     public function approve(Request $request, $id)
    {
        $product = Product::find($id);

        $product->update([
            'status' => 'Y',
        ]);

        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully updated approval!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return redirect()->back();
        }
    }




    public function reject(Request $request, $id)
    {
        //$some = $request->id;
        $product = Product::find($id);

        //$products = Product::where('job_id', '=', $id)->get();

        $product->update([
            'status' => 'R',
            'rejectinfo' => request('rejectinfo')


        ]);


        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully rejected!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return redirect()->back();
        }
    }
}
