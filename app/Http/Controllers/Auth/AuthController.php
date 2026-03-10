<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Jenssegers\Agent\Agent;
use App\Helpers\DeviceLocationHelper;
use App\Mail\PasswordResetMail;
use App\Mail\WelcomeMail;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('products.list'); // already logged in → go home
        }

        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
    
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
       
               
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            $loginData = DeviceLocationHelper::getDeviceLocationData($request);

            User::where('_id', Auth::id())
                ->update([
                    'login_device' => $loginData,
                    'last_login_at' => new UTCDateTime(Carbon::now()->getTimestamp()*1000)
                ]);

            return redirect()->intended('home')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withErrors('Oppes! You have entered invalid credentials')->withInput();
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone'=>'required|numeric',
        ]);
           

        $user = $this->create($request->all());

        // call mail controller function
        Mail::to($user->email)->send(new WelcomeMail($user));

        $registerData = DeviceLocationHelper::getDeviceLocationData($request);

        User::where('_id', $user->_id)
            ->update(['register_device' => $registerData]);
         
        if(Auth::check()){
            return redirect("home")->withSuccess('Great! You have Successfully loggedin');

        }
        
        return redirect("login")->withSuccess('Opps! You do not have access')->withInput();
        
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("/")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role'=>'User',
        'phone'=>$data['phone'],
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }

    public function showForgotForm()
    {
        return view('auth.forgotPassword');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|same:confirm-password',
            'confirm-password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        // update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        // send reset confirmation email
        Mail::to($user->email)->send(new PasswordResetMail($user));
        return redirect()->route('login')
            ->with('success', 'Password reset successful. Please login.');
    }
}
