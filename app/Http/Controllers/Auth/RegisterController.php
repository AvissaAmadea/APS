<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Dinas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'nama' => $data['nama'],
            'nip'=> $data['nip'],
            'jabatan'=> $data['jabatan'],
            'telp'=> $data['telp'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'dinas_id' => $data['dinas_id'],
            'role_id' => 3, // role default untuk opd
        ]);

        event(new Registered($user));

        return $user; // Mengembalikan objek User setelah berhasil dibuat
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Setelah pengguna berhasil dibuat, arahkan ke halaman login
        return redirect()->route('login')->with('Success', 'Registrasi berhasil! Silakan masuk.');
    }


    public function showRegistrationForm()
    {
        $dinas = Dinas::all(); // Mengambil semua data dinas

        return view('auth.register', compact('dinas'));
    }
}
