<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitialiseDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate refresh and seed the database';

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
        $this->call('migrate:fresh');
        // $this->call('migrate', ['--path' => 'database/migrations/admin']);
        $this->call('migrate', ['--path' => 'database/migrations/courrier']);
        $this->call('migrate', ['--path' => 'database/migrations/document']);
        $this->call('db:seed');
    }
}
