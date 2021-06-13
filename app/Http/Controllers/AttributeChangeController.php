<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Attributes;
use App\AttributeMaster;
use Illuminate\Support\Str;


class AttributeChangeController extends Controller
{
    public function approve(Request $request, $id){
        $affected = DB::table('attributes')
        ->where('id', $id)
        ->update(['published' => 'Y' ]);
        return back();

    }

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
            'published' => 'N',
            'created_by' => Auth::user()->email,
        ]);

        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully approved a new attribute!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return back()->with('success', 'Successfully approved a new attribute!');
        }
    }

    public function destroy(Request $request,$id)
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
            return back()->with('success', 'Successfully Rejected Attribute!');
        }

    }
}
