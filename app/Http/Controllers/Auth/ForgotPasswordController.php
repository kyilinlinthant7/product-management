<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\ResetPasswordRequest;
use App\User;
use \Carbon\Carbon;

class ForgotPasswordController extends Controller
{
	public function showForm() {
		return view('forgot-password');
	}

	public function sendResetLinkEmail(Request $request)
	{
		$email = $request->input('email');
    	$user = DB::table('users')->where('email', $email)->first();

		if (!$user) {
			return back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
		}

		$token = Str::random(60);

		DB::table('password_resets')->insert([
			'email' => $email,
			'token' => $token,
			'created_at' => now(),
		]);

		$subject = 'Get Reset Password Link';
		$message = 'Please reset your password by clicking the button below.';
		$resetLink = route('reset-password-form', ['token' => $token]);
		
		Mail::to($email)->send(new ForgotPasswordMail($subject, $message, $resetLink));

		$request->session()->put('reset_link_sent', true);

		return redirect()->back()->with('success', 'Password reset link was sent to your email. Check for now!');
	}

	public function showResetPasswordForm(Request $request) {
		$token = $request->query('token');
		$resetRecord = DB::table('password_resets')->where('token', $token)->first();

		if (!$resetRecord || Carbon::parse($resetRecord->created_at)->addHour()->isPast()) {
			return redirect()->route('login')->with('error', 'Invalid or expired password reset link.');
		}

		$request->session()->forget('reset_link_sent');

		return view('reset-password-form', ['token' => $token]);
	}

	public function resetPassword(ResetPasswordRequest $request) {
		$email = $request->email;
		$newPassword = $request->password;
		$confirmPassword = $request->confirm_password;
	
		if ($newPassword == $confirmPassword) {

			$user = User::where('email', $email)->first();
	
			if ($user) {
				try {
					DB::beginTransaction();
	
					$user->password = Hash::make($newPassword);
					$user->save();
	
					DB::commit();
	
					return redirect()->route('login')->with('success', 'Password reset successful. Please log in with your new password.');
				} catch (\Exception $e) {
					DB::rollBack();
					return redirect()->back()->with('error', 'Password reset failed. Please try again.');
				}
			} else {
				return redirect()->back()->with('error', 'No user found with the provided email address.');
			}
		} else {
			return redirect()->back()->with('error', 'Passwords do not match.');
		}
	}
}
