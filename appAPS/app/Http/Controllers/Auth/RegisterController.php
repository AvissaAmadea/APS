<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Dinas;
use App\Models\Roles;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\Console\Input\Input;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', 'unique:users'],
            'jabatan'=> ['required', 'string', 'max:255'],
            'telp'=> ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dinas_id' => ['required', 'exists:dinas,id'],
            'role_id'=> ['required','exists:roles,id'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    // Passing the $request as a parameter
    protected function create(Request $request, array $data)
    {
        $nama_dinas = $request->input('nama_dinas');
        $dinasId = Dinas::where('nama_dinas', $nama_dinas)->first();
        $role_id = Roles::where('name', $data['name'])->value('id');
        
        return User::create([
            'nama' => $data['nama'],
            'nip'=> $data['nip'],
            'jabatan'=> $data['jabatan'],
            'telp'=> $data['telp'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'dinas_id' => $dinasId->id, // setting $dinasId in Model Dinas to find nama_dinas based on dinas_id
            'role_id' => $role_id, // Set default role 'opd'
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request, array $data) 
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', 'unique:users'],
            'jabatan'=> ['required', 'string', 'max:255'],
            'telp'=> ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dinas_id' => ['required', 'exists:dinas,id'],
            'role_id'=> ['required','exists:roles,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validation passes, create user
        $nama_dinas = $request->input('nama_dinas');
        $dinasId = Dinas::where('nama_dinas', $nama_dinas)->first();
        $role_id = Roles::where('name', $data['name'])->value('id');

        $user = User::create([
            'nama' => $data['nama'],
            'nip'=> $data['nip'],
            'jabatan'=> $data['jabatan'],
            'telp'=> $data['telp'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'dinas_id' => $dinasId->id, // setting $dinasId in Model Dinas to find nama_dinas based on dinas_id
            'role_id' => $role_id,
        ]);

        // Redirect based on the created user's role_id
        if ($user->role_id === 1) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->role_id === 2) {
            return redirect()->route('sekda.dashboard');
        } elseif ($user->role_id === 3) {
            return redirect()->route('opd.dashboard');
        }

        return back()->withErrors(['email' => 'Registration failed']);
    }
}
