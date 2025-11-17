<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserStreamSession;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class LiveStreamReview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date("Y-m-d");
        $stream = UserStreamSession::where('start_date', $date)
            ->where('email_status',  0)
            ->where('created_at','<=',  Carbon::now()->addMinutes(35));
        $stream->update([
            'email_status'=>  1
        ]);
        $userIds= $stream ->pluck('user_id')->toArray();
        $stream_id=$stream->pluck('stream_id')->first();

        if(!empty($userIds)){

            $users = User::select('email')->whereNotNull('email')->whereIn('id', $userIds)->get();


            foreach($users as $user) {
                Mail::send('mail.review_mail', get_defined_vars(), function ($send) use ($user) {
                    $send->to($user['email'])->subject("Meeting Review");

                });
            }
        }

        return Command::SUCCESS;
    }
}
