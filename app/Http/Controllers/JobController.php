<?php

namespace App\Http\Controllers;

use App\Job;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){

        $jobs = Job::paginate(12);
        return view('jobs.index', ['jobs' => $jobs]);

    }

    public function create(Request $request)
    {

        $job = job::create([

        'created_by' => Auth::user()->email,
        'qrcode' => 'example string',
        'published' => 'N'
    ]);
    $job = Job::find($job->id);
    if ($request->is('api/*')) {
        //write your logic for api call
        $response = [
            'status' => 'success',
            'msg' => 'Successfully inserted a new type!'
        ];

        return response($response, 201);
    } else {

        $jobs = Job::paginate(12);
        return view('jobs.index', ['jobs' => $jobs]);

    }

    }
    public function show(Request $request, $id)
    {
        // $user = User::find($id);
        // $permissions = $user->getAllPermissions();
        // $role = $user->getRoleNames();
        $job = Job::find($id);
        $products = Product::where('job_id', '=', $id)->get();
        //dd($products);
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
            return view('jobs.show', ['job' => $job, 'products' => $products]);
        }
    }



}
