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



class ProductController extends Controller {
    public  function create(Request $request, $id)
    {
        $categories = Category::all();

        return view('jobs.products.create',['id' => $id, 'categories' => $categories]);

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

    public function GetSubCatAgainstMainCatEdit(Request $request,$id){
        echo json_encode(Subcategory::where('category_id','=',$id)->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quanity' => 'required|numeric',
            'value' => 'required|numeric'
        ]);


        //dd(request('dynamic'));
       $product = Product::create([
            'job_id' => request('job_id'),
            'subcategorytype_id' => request('subcategorytype_id'),
            'material_id' => Str::uuid(),
            'quantity' => request('quantity'),
            'created_by' => Auth::user()->email,
        ]);
       //dd( $product);
        if(request('dynamic')){
          //  dd(request('dynamic'));
            foreach ($request->dynamic as $key => $value) {

                ProductAttribute::create([

                    'product_id' => $product->id,
                    'name' => $value['name'],
                    'value' => $value['value'],
                    'unit' => $value['unit'],

                ]);

            }
           }


            return back()->with('success', 'Successfully inserted a new type!');
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
             $response = [
                 // 'status' => 'success',
                 // 'user' => $user,
                 // 'role' => $role,
                 // 'permissions' => $permissions
             ];

             return response($response, 201);
         } else {
             //write your logic for web call
             return view('jobs.products.show', ['product' => $product ]);
         }
     }

}
