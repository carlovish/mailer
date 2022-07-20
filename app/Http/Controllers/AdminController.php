<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    
    public function index()
    {
        $users = User::orderBy('name')->with('city');
        $users->where('role', 'user');
        return Inertia::render('Admin/Index', [
            "users" => $users->paginate(10),
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Register',[
            "countries"=>Country::orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => ['required', 'max:100'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => [
                    'required',
                    'confirmed',
                    'string',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
                'phone' => ['min:10', 'numeric'],
                'card_id' => ['required', 'min:11', 'string'],
                'city_id' => ['required', 'numeric'],
                'day_of_birth' => ['required', 'date', 'before:-18 years']
            ],
            [
                'day_of_birth.before' => 'you must be at least 18 years old',

            ]
        );

        $user = new User();
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->phone = $request->input("phone");
        $user->card_id = $request->input("card_id");
        $user->day_of_birth = $request->input("day_of_birth");
        $user->city_id = $request->input("city_id");
        $user->password = Hash::make($request->input("password"));
        $user->save();

        //$request->session()->put('success', 'User registered successfully! you can sign in now');

        return redirect()->route('admin.index');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Admin/Edit', [
            'user' => User::findOrFail($id)
        ]);
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
        $this->validate(
            $request,
            [
                'name' => ['required', 'max:100'],
                'phone' => ['min:10', 'numeric'],
                'day_of_birth' => ['required', 'date', 'before:-18 years']
            ],
            [
                'day_of_birth.before' => 'you must be at least 18 years old',

            ]
        );

        $user = User::find($id);
        $user->name = $request->input("name");
        $user->phone = $request->input("phone");
        $user->day_of_birth = $request->input("day_of_birth");
        $user->password = Hash::make($request->input("password"));
        $user->save();

        //$request->session()->put('success', 'Post updated successfully!');

        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        User::find($id)->delete();

        return redirect()->route('admin.index');
        
    }

    public function showEmails($id)
    {
        $user=User::find($id);
        return Inertia::render('User/Index', [
            "emails" => Email::whereBelongsTo($user)->paginate(10)
        ]);
    }


   

    
}
