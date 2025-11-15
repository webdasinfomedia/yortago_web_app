<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Age;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\NewsLetter;
use App\Models\StreamSession;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Mail\InPersonContactReplyMail;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }


        /*****     Dashboard Page       *****/


    public function dashboard(Request $request)
    {

        $users=User::where('role','user')->where('user_type','Stream')->count();
       
        $total_session=StreamSession::count();
        $total_earning=Transaction::where('stream_id','!=',0)->get()->sum('amount');

// Online Training
        $users_online=User::where('role','user')->where('user_type','!=','Stream')->count();
        $total_earning_online=Transaction::where('stream_id',0)->get()->sum('amount');


        return view('admin.dashboard.dashboard',get_defined_vars());
    }

        /*****     Profile Page       *****/

    public function profile(Request $request)
    {

        $user=Auth::user();
        $timezones = array(
            'Pacific/Midway'       => "(GMT-11:00) Midway Island",
            'US/Samoa'             => "(GMT-11:00) Samoa",
            'US/Hawaii'            => "(GMT-10:00) Hawaii",
            'US/Alaska'            => "(GMT-09:00) Alaska",
            'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana'      => "(GMT-08:00) Tijuana",
            'US/Arizona'           => "(GMT-07:00) Arizona",
            'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
            'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
            'America/Mexico_City'  => "(GMT-06:00) Mexico City",
            'America/Monterrey'    => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
            'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
            'America/Bogota'       => "(GMT-05:00) Bogota",
            'America/Lima'         => "(GMT-05:00) Lima",
            'America/Caracas'      => "(GMT-04:30) Caracas",
            'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz'       => "(GMT-04:00) La Paz",
            'America/Santiago'     => "(GMT-04:00) Santiago",
            'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland'            => "(GMT-03:00) Greenland",
            'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
            'Atlantic/Azores'      => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca'    => "(GMT) Casablanca",
            'Europe/Dublin'        => "(GMT) Dublin",
            'Europe/Lisbon'        => "(GMT) Lisbon",
            'Europe/London'        => "(GMT) London",
            'Africa/Monrovia'      => "(GMT) Monrovia",
            'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
            'Europe/Berlin'        => "(GMT+01:00) Berlin",
            'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
            'Europe/Brussels'      => "(GMT+01:00) Brussels",
            'Europe/Budapest'      => "(GMT+01:00) Budapest",
            'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
            'Europe/Madrid'        => "(GMT+01:00) Madrid",
            'Europe/Paris'         => "(GMT+01:00) Paris",
            'Europe/Prague'        => "(GMT+01:00) Prague",
            'Europe/Rome'          => "(GMT+01:00) Rome",
            'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
            'Europe/Skopje'        => "(GMT+01:00) Skopje",
            'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
            'Europe/Vienna'        => "(GMT+01:00) Vienna",
            'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
            'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
            'Europe/Athens'        => "(GMT+02:00) Athens",
            'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
            'Africa/Cairo'         => "(GMT+02:00) Cairo",
            'Africa/Harare'        => "(GMT+02:00) Harare",
            'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
            'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
            'Europe/Kiev'          => "(GMT+02:00) Kyiv",
            'Europe/Minsk'         => "(GMT+02:00) Minsk",
            'Europe/Riga'          => "(GMT+02:00) Riga",
            'Europe/Sofia'         => "(GMT+02:00) Sofia",
            'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
            'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
            'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
            'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
            'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
            'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
            'Europe/Moscow'        => "(GMT+03:00) Moscow",
            'Asia/Tehran'          => "(GMT+03:30) Tehran",
            'Asia/Baku'            => "(GMT+04:00) Baku",
            'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
            'Asia/Muscat'          => "(GMT+04:00) Muscat",
            'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
            'Asia/Kabul'           => "(GMT+04:30) Kabul",
            'Asia/Karachi'         => "(GMT+05:00) Karachi",
            'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
            'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty'          => "(GMT+06:00) Almaty",
            'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
            'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth'      => "(GMT+08:00) Perth",
            'Asia/Singapore'       => "(GMT+08:00) Singapore",
            'Asia/Taipei'          => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
            'Asia/Seoul'           => "(GMT+09:00) Seoul",
            'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
            'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
            'Australia/Darwin'     => "(GMT+09:30) Darwin",
            'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
            'Australia/Canberra'   => "(GMT+10:00) Canberra",
            'Pacific/Guam'         => "(GMT+10:00) Guam",
            'Australia/Hobart'     => "(GMT+10:00) Hobart",
            'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney'     => "(GMT+10:00) Sydney",
            'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
            'Asia/Magadan'         => "(GMT+12:00) Magadan",
            'Pacific/Auckland'     => "(GMT+12:00) Auckland",
            'Pacific/Fiji'         => "(GMT+12:00) Fiji",
        );


        return view('admin.profile.profile',get_defined_vars());
    }

     /*****     Profile Update       *****/

    public function updateProfile(Request $request)
    {
    //  return  $request;
      $user = User::find(Auth::User()->id);

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'username'=>'required',
        ]);
        // return 1;
        if ($request->email != $user->email) {
            $request->validate([
                'email' =>'required|email|unique:users',
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->time_zone = $request->time_zone;

        if($request->hasfile('profile_pic')){
            $image = $request->file('profile_pic');
            $filename = 'uploads/users/'.time() . '.' . $image->getClientOriginalExtension();
            $movedFile = $image->move('uploads/users/', $filename);
            $user->profile_pic = $filename;
            $user->save();
        }else {
            $user->save();
        }

        $path = base_path('.env');

        self::changeEnvironmentVariable('TIME_ZONE',$request->time_zone);

        config(['app.timezone' => $request->time_zone]);
        date_default_timezone_set($request->time_zone);
        return redirect()->back()->with('message','Profile has been updated');
    }

    public static function changeEnvironmentVariable($key,$value)
{
    $path = base_path('.env');

    if(is_bool(env($key)))
    {
        $old = env($key)? 'true' : 'false';
    }
    elseif(env($key)===null){
        $old = 'null';
    }
    else{
        $old = env($key);
    }

    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            "$key=".$old, "$key=".$value, file_get_contents($path)
        ));
    }
}


     /*****     Password Update      *****/

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->back()->with('message','Password has been updated');

    }


   public function newsLetter()
    {
        // Delete duplicates and keep only latest record for each email
        \DB::table('news_letters')
        ->whereNotIn('id', function ($query) {
            $query->from(\DB::raw('(SELECT MAX(id) as id FROM news_letters GROUP BY email) as temp'));
            $query->select('id');
        })
        ->delete();

        // 2. Remove invalid/garbage emails
        \DB::table('news_letters')
        ->whereRaw("email NOT REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$'")
        ->delete();

         // 3. Remove disposable/fake domains
        $fakeDomains = [
            'mailinator.com', '10minutemail.com', 'tempmail.com',
            'fakeemail.com', 'data-backup-store.com',  'maildrop.cc',
            'trashmail.com','yopmail.com','dispostable.com','serviseantilogin.com', 'monochord.xyz','testform.xyz',
        ];
        \DB::table('news_letters')
            ->whereIn(\DB::raw('LOWER(SUBSTRING_INDEX(email,"@",-1))'), $fakeDomains)
            ->delete();

        // 4. Remove emails with extremely long or suspicious usernames
        \DB::table('news_letters')
            ->whereRaw('CHAR_LENGTH(SUBSTRING_INDEX(email,"@",1)) > 30')
            ->delete();

        $lists=NewsLetter::orderBy('id','desc')->get();
        return view('admin.newsLetter.list',get_defined_vars());
    }
    public function inPersonContact()
    {

        $lists=Contact::orderBy('id','desc')->get();
        return view('admin.inperson.list',get_defined_vars());
    }
 public function inPersonContactReply(Request $request)
{
    $request->validate([
        'subject' => 'required|string',
        'content' => 'required|string',
        'email' => 'required|email',
        'id' => 'required|integer'
    ]);

    ContactReply::create([
        'subject' => $request->subject,
        'content' => $request->content,
        'contact_id' => $request->id,
    ]);

    try {
        Mail::to($request->email)->send(
            new InPersonContactReplyMail($request->subject, $request->content, $request->email)
        );
    } catch (\Exception $e) {
        \Log::error('Mail sending failed: ' . $e->getMessage());
    }

    return redirect()->back()->with('message', 'Reply Email Sent Successfully');
}


    public function newsLetterExport(Request $request)
    {
        return (new FastExcel(newsLetter::all()))->download('newsletter.csv', function ($user) {
            return [
                'Email' => $user->email,
            ];
        });

    }

}
