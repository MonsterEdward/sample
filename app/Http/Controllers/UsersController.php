<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'create', 'store']]);

        $this->middleware('guest', ['only' => ['create']]);
    }

    public function create()
    {
    	return view('users.create');
    }

    public function show(User $user)
    {
        //compact将user数据与视图绑定
    	return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|max:50',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|confirmed|min:6'
    	]);

    	$user = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password)
    	]);

    	Auth::login($user);//使注册成功用户直接登录
    	//提示注册成功信息
    	session()->flash('success', 'Welcome to my site!');

    	return redirect()->route('users.show', [$user]);
    	//等同于redirect()->route('users.show', [$user->id])
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min"6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        /*$user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);*/
        session()->flash('success', 'Your information modified!');

        return redirect()->route('users.show', $user->id);
    }
}
