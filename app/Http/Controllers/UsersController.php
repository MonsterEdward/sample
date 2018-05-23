<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

use Auth;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'create', 'store', 'index', 'confirmEmail']]);

        $this->middleware('guest', ['only' => ['create']]);
    }

    public function create()
    {
    	return view('users.create');
    }

    public function show(User $user)
    {
        //compact将user数据与视图绑定
    	//return view('users.show', compact('user'));
        $statuses = $user->statuses()->orderBy('created_at', 'desc')->paginate(30);
        return view('users.show', compact('user', 'statuses'));
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

    	//Auth::login($user);//使注册成功用户直接登录
        //提示注册成功信息
    	//session()->flash('success', 'Welcome to my site!');
        //return redirect()->route('users.show', [$user]);
    	//等同于redirect()->route('users.show', [$user->id])

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', 'Confirmation email has been sent to your email address, please check out.');
        return redirect('/');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        /*$a = Auth::user();
        var_dump($a);exit;*/
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

    public function index()
    {
        //$users = User::all();
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', 'Delete user success!');
        return back();
    }

    public function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        //$from = '1910612833@qq.com';
        //因已在.env中配置发件人邮箱,这里不需再设置
        //$name = 'Zhan San';
        $to = $user->email;
        $subject = 'Thanks for signing up, please confirm your email.';

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->/*from($from, $name)->*/to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {//路由可传参
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', 'Congratulations, activate success.');
        return redirect()->route('users.show', [$user]);
    }

    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = 'Followers';
        return view('users.show_follow', compact('users', 'title'));
    }

    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = 'Followings';
        return view('users.show_follow', compact('users', 'title'));
    }
}
