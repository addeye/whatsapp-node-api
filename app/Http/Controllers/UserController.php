<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::query();
        
        $sort = request('sort_val') ?? 'DESC';
        if(request('sort_name')=='name'){
    $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
    $user->orderBy('name', request('sort_val'));
}

if(request('sort_name')=='email'){
    $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
    $user->orderBy('email', request('sort_val'));
}

if(request('sort_name')=='email_verified_at'){
    $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
    $user->orderBy('email_verified_at', request('sort_val'));
}

if(request('sort_name')=='password'){
    $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
    $user->orderBy('password', request('sort_val'));
}


        if(request('cari')){
    $user->where(function($q){
        $q->where('name','LIKE','%'.request('cari').'%')
->orWhere('email','LIKE','%'.request('cari').'%')
->orWhere('email_verified_at','LIKE','%'.request('cari').'%')
->orWhere('password','LIKE','%'.request('cari').'%');
    });
}

        $user = $user->orderBy('created_at', $sort)->paginate()->withQueryString();

        return view('pages.user.list', [
            'data' => $user->withPath('user'),
            'sort' => $sort
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.add',[]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =[
    'name' => 'required',
'email' => 'required',
'email_verified_at' => 'required',
'password' => 'required'
];

$messages = [
    'name.required' => 'Name Wajib terisi!',
'email.required' => 'Email Wajib terisi!',
'email_verified_at.required' => 'EmailVerifiedAt Wajib terisi!',
'password.required' => 'Password Wajib terisi!'
];


        $request->validate($rules, $messages);
        $datarow = $request->all();

        

        User::create($datarow);

        return redirect('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('pages.user.detail', [
            'data' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('pages.user.edit', [
            'data' => $user,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules =[
    'name' => 'required',
'email' => 'required',
'email_verified_at' => 'required',
'password' => 'required'
];

$messages = [
    'name.required' => 'Name Wajib terisi!',
'email.required' => 'Email Wajib terisi!',
'email_verified_at.required' => 'EmailVerifiedAt Wajib terisi!',
'password.required' => 'Password Wajib terisi!'
];


        $request->validate($rules, $messages);
        $datarow = $request->all();

        

        $user->update($datarow);

        return redirect('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
        $user->delete();
        return redirect('user');
    }

    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }
}
