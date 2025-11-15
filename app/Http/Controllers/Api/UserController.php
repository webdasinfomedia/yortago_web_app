<?php

namespace App\Http\Controllers\Api;

use App\Console\Commands\SendEmail;
use App\Http\Controllers\Controller;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\NotificationTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB; 
use Carbon\Carbon; 
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    use ResponseTrait, NotificationTrait, ImageUploadTrait;

    public function register_user(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->returnApiResponse(422, "Validation error", array('error' => $validator->errors()));
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 'OnlineTraining';
            $user->save();

            $data['user'] = $user;
//            event(new Registered($user));
            sendEmail("yortago@gmail.com","New User Registration Notification",'mail.new_user_registeration_email',$data);
            return $this->returnApiResponse(200, 'User registered successfully', array('user' => $user));
        } catch (\Exception $e) {
            return $this->returnApiResponse(400, $e->getMessage(), array('error' => $e));
        }
    }
    public function registerUserForCRM(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
            ]);
            if ($validator->fails()) {
                return $this->returnApiResponse(422, "Validation error", array('error' => $validator->errors()));
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_type = 'OnlineTraining';
            $user->password = Hash::make('123456789');
            $user->save();

            $token = Str::random(64);

            DB::table('password_resets')->where('email',$request->email)->delete();
            

          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()

            ]);

            $data['user'] = User::where('email',$request->email)->first();
            $data['user']['token'] = $token;

            sendEmail($request->email,"Reset password",'mail.forgot-password-link',$data);

            return $this->returnApiResponse(200, 'User registered successfully and please check your email to rest your password', array('user' => $user));
        } catch (\Exception $e) {
            return $this->returnApiResponse(400, $e->getMessage(), array('error' => $e));
        }
    }

    public function login_user(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->returnApiResponse(400, 'Invalid credentials', array('error' => 'Invalid credentials'));
            }
            $token  = $user->createToken('authToken')->accessToken;
            return $this->returnApiResponse(200, 'User logged in successfully', array('user' => $user, 'token' => $token));
        } catch (\Exception $e) {
            return $this->returnApiResponse(400, $e->getMessage(), array('error' => $e->getMessage()));
        }
    }

    public function update_profile(Request $request)
{
    $user = $request->user();  // Get the logged-in user
    
    $request->validate([
        'name' => 'required',
        'user_name' => 'required',
        'gender_id' => 'required',
        'dob' => 'required',
        'bio' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'required',
        
        // Validation for the current, new, and confirm passwords
        'current_password' => 'nullable|required_with:new_password', // current password must match stored password
        'new_password' => 'nullable|required_with:current_password|different:password', // new password must be different from the current password
        'confirm_password' => 'nullable|required_with:new_password|same:new_password', // confirm password must match the new password
        
        'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Check if the current password is correct
    if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
        return $this->returnApiResponse(400, 'The current password is incorrect',[]);
    }

    // Update user profile
    $user->name = $request->name;
    $user->username = $request->user_name;
    $user->gender_id = $request->gender_id;
    $user->dob = $request->dob;
    $user->bio = $request->bio;
    $user->email = $request->email;
    $user->phone_no = $request->phone;
    $user->user_type = 'OnlineTraining';

    // Update password if provided
    if ($request->filled('new_password')) {
        $user->password = Hash::make($request->new_password);
    }

    // Update profile picture if uploaded
    if ($request->hasFile('profile_pic')) {
        $image = $this->upload_image($request->file('profile_pic'));
        $user->profile_pic = $image;
    }

    // Save the updated user
    $user->save();

    // Retrieve updated user data
    $userData = User::find($user->id);

    // Return success response
    return $this->returnApiResponse(200, 'Profile updated successfully', ['user' => $userData]);
}


    public function updateSubscriptionStatus()
    {
        $user = auth()->user();

        if (!$user) {
            return $this->returnApiResponse(400, 'User not found!', []);
        }

        // Toggle subscription status and save in one operation
        $user->update(['is_subscribed' => true]);

        return $this->returnApiResponse(200, 'User details updated successfully', $user->fresh());
    }

    public function forgotPassword(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);
            if ($validator->fails()) {
                return $this->returnApiResponse(422, $validator->errors()->first(),[]);
            }

            $token = Str::random(64);

            DB::table('password_resets')->where('email',$request->email)->delete();
            

          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()

            ]);

            $data['user'] = User::where('email',$request->email)->first();
            $data['user']['token'] = $token;

            sendEmail($request->email,"Reset password",'mail.forgot-password-link',$data);
            return $this->returnApiResponse(200, "Please check your email to reset your password",[]);
        } catch (\Exception $e) {
            return $this->returnApiResponse(400, $e->getMessage(), array('error' => $e->getMessage()));
        }
    }
    public function showResetPasswordForm($token) { 

        return view('auth.reset-password-by-token', ['token' => $token]);
    }
    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->returnApiResponse(422, $validator->errors()->first(),[]);
        }
        $updatePassword = DB::table('password_resets')->where([
                                'token' => $request->token
                              ])->first();

        if(!$updatePassword){
            return $this->returnApiResponse(422, "Invalid token",[]);
        }
        // return Hash::make($request->password);
        $user = User::where('email', $updatePassword->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();
        return redirect('/');
    }

}
