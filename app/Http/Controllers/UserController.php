<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasAnyRole(['admin'])){

               $users1 = User::with('roles');

               $users = $users1->whereNotIn('name', [ 'admin','super-admin'])->paginate(15);
               //ddd($users1);

            }else{
                $users = User::with('roles')->paginate(15);
               // ddd($users);

        }
        //ddd($users);

        return view('user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Auth::user()->hasAnyRole(['super-admin'])){

            $roles = Role::all()->whereNotIn('name', ['super-admin']);

        }else{

            $roles = Role::all()->whereNotIn('name', ['super-admin','admin']);
        }

       // ddd(response()->json($roles));
        return view('user.create', ['roles' => $roles]);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255',
            'role' =>  'required',
        ]);

        $user = factory(\App\User::class)->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),

        ]);

        $user->assignRole($request->role);

        return back()->with('success','Successfully registered a new user!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if (Auth::user()->hasAnyRole(['super-admin'])){

            $roles = Role::all()->whereNotIn('name', ['super-admin']);

        }else{

            $roles = Role::all()->whereNotIn('name', ['super-admin','admin']);
        }

        $role = Auth::user()->getRoleNames();
        //ddd($role[0]);
        return view('user.edit', ['user'=> $user,'role' => $role[0], 'roles' => $roles]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
