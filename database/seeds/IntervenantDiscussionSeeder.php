<?php

use App\Models\Messagerie\IntervenantDiscussion;
use Illuminate\Database\Seeder;

class IntervenantDiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(IntervenantDiscussion::class, 10)->create();
    }
}
