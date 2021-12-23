<?php

use App\Models\Messagerie\Discussion;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Discussion::class, 10)->create();
    }
}
