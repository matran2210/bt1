<?php

namespace App\Modules\User\Schedule\Commands;

use App\Modules\User\Cms\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Hash;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

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
     * @return mixed
     */
    public function handle()
    {
        $form_data = array(
            'name'         =>  'test',
            'email'        =>  'test@gmail.com',
            'password'         => Hash::make(123),
            'phone'       => '0123',
            'address'       => 'HN',
            'admin_group'       => 1,
            'is_delete'       => 0,
            'status'       => 'offline',
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        );
        User::create($form_data);

    }
}
