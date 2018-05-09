<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;//use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
	//guest
	public function __construct()
	{
		$this->middleware('guest', ['only' => ['create']]);
	}

    public function create()
    {
    	return view('sessions.create');
    }

    public function store(Request $request)
    {
    	$credentials = $this->validate($request, [
    	    'email' => 'required|email|max:255',
            'password' => 'required'
            ]);

    	if(Auth::attempt($credentials, $request->has('remember'))) {
    	    session()->flash('success', 'Welcome back.');
    	    //根本不明白return的用法,照葫芦画瓢还写错,redirect根本没用return出来
    	    //return redirect()->route('users.show', [Auth::user()]);
    	    return redirect()->intended(route('users.show', [Auth::user()]));
        }else{
    	    session()->flash('danger', 'This E-mail not matchs the password.');
    	    return redirect()->back();
        }
    }

    public function destroy()
    {
    	Auth::logout();
    	session()->flash('success', 'Logout success');
    	return redirect('login');
    }
}
