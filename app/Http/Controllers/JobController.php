<?php

namespace App\Http\Controllers;

use App\Job;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\User;

class JobController extends Controller
{
    public function index(Request $request)
    {
        //
        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();
            if ($loggedinUser->hasAnyRole(['editor'])) {
                $jobs = Job::where('created_by', '=', $loggedinUser->email)->paginate(15);
            } else {
                $jobs = Job::orderBy('created_at', 'desc')->paginate(15);
            }
            $response = [
                'jobs' => $jobs,

            ];

            return response($response, 201);
        } else {
            if (Auth::user()->hasAnyRole(['editor'])) {
                $jobs = Job::where('created_by', '=', Auth::user()->email)->orderBy('created_at', 'desc')
                ->paginate(15);
            } else {
                $jobs = Job::orderBy('created_at', 'desc')->paginate(15);
            }
            return view('jobs.index', ['jobs' => $jobs]);
        }
    }

    public function create(Request $request)
    {

        if ($request->is('api/*')) {
            $loggedinUser = User::where('email', $request->email)->first();

            $job = job::create([
                'created_by' => $loggedinUser->email,
                'qrcode' => 'example string',
                'job_number' => time().'-'.Str::random(10)
            ]);
            $job = Job::find($job->id);


            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully inserted a new job!'
            ];

            return response($response, 201);
        } else {

            $job = job::create([
                'created_by' => Auth::user()->email,
                'qrcode' => 'example string',
                'job_number' => time().'-'.Str::random(10)
            ]);
            $job = Job::find($job->id);

            $jobs = Job::paginate(12);

            return redirect('/jobs');
        }
    }
    public function show(Request $request, $id)
    {

        $job = Job::find($id);


        //dd($products);
        if ($request->is('api/*')) {
                $loggedinUser = User::where('email', $request->email)->first();
                if($loggedinUser){
                    if($loggedinUser->hasAnyRole(['super-admin','admin','approver','editor']) ){
                    $products = Product::where('job_id', '=', $id)->get();
                    }
                }else{
                    $products = Product::where('job_id', '=', $id)->where('status', '=', 'Y')->get();
                }
            //write your logic for api call
            $response = [
                'job' => $job, 'products' => $products
            ];

            return response($response, 201);
        } else {
            if(Auth::user() ){
                if(Auth::user()->hasAnyRole(['super-admin','admin','approver', 'editor']) ){
                $products = Product::where('job_id', '=', $id)->get();
                }else{
                    $products = Product::where('job_id', '=', $id)->where('status', '=', 'Y')->get();
                }
            }else{
                $products = Product::where('job_id', '=', $id)->where('status', '=', 'Y')->get();
            }
            //write your logic for web call
            return view('jobs.show', ['job' => $job, 'products' => $products]);
        }
    }

    public function approve(Request $request, $id)
    {
        //$some = $request->id;
        $job = Job::find($id);

        $products = Product::where('job_id', '=', $id)->get();

        $job->update([
            'published' => 'Y',

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
            return view('jobs.show', ['job' => $job, 'products' => $products]);
        }
    }
    public function disapprove(Request $request, $id)
    {
        //$some = $request->id;
        $job = Job::find($id);

        $products = Product::where('job_id', '=', $id)->get();

        $job->update([
            'published' => 'N',
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
            return view('jobs.show', ['job' => $job, 'products' => $products]);
        }
    }

    public function reject(Request $request, $id)
    {
        $job = Job::find($id);

        $products = Product::where('job_id', '=', $id)->get();

        $job->update([
            'status' => 'R',
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
            return view('jobs.show', ['job' => $job, 'products' => $products]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $job = Job::find($id);

        $job->delete();
        if ($request->is('api/*')) {
            //write your logic for api call
            $response = [
                'status' => 'success',
                'msg' => 'Successfully deleted job!'
            ];

            return response($response, 201);
        } else {
            //write your logic for web call
            return redirect('/jobs');
        }
    }
}
