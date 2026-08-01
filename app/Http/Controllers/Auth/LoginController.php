<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // true if checkbox is checked

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if user is a coordinator and redirect accordingly
            $user = Auth::user();
            
            if ($user->user_type === 'coordinator') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'redirect' => url('/coordinator/dashboard')
                ]);
            }

            if ($user->user_type === 'admin') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'redirect' => url('/admin/dashboard')
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => url('/') // Default redirect for other users
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();                     // Log out the user
        $request->session()->invalidate();   // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/');                // Redirect to homepage
    }
}