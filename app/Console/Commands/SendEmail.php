<?php

namespace App\Console\Commands;

use App\Models\LiveStream;
use App\Models\User;
use App\Models\UserStreamSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-zoom-invitation-link';

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
        $time = date("H:i:s", time()+(3600*2));


        $liveStreamIds = LiveStream::where('streaming_date', $date)
            ->where('streaming_time', '>=', $time)
            ->pluck('id')->toArray();
        if(!empty($liveStreamIds)){
            $userIds = UserStreamSession::whereNotNull('stream_id')->whereIn('stream_id', $liveStreamIds)->pluck('user_id')->toArray();

            $users = User::select('email')->whereNotNull('email')->whereIn('id', $userIds)->get();

            foreach($users as $user) {
                Mail::to($user->email);
            }
        }




        return Command::SUCCESS;
    }
}
