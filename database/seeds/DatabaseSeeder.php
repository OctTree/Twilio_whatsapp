<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('users_phone_number')->insert([
            'phone_number' => '+14122264199'
        ]);
        DB::table('users_phone_number')->insert([
            'phone_number' => '+212660910874'
        ]);

        /*    
        DB::table('contents')->insert([
            'from_number' => '+12512559796',
            'to_number'   => '+14122264199',
            'content'     => 'demo msg tested by ayoub',
            'status'      => 'Q',
            'sid'         => 'SMa28811f6442d4de291e202c4d40b3ed7',
            'created_at'  => '2019-08-15 21:20:31'
        ]);

        DB::table('contents')->insert([
            'from_number' => '+12512559796',
            'to_number'   => '+14122264199',
            'content'     => 'messge 2 by ayoub',
            'status'      => 'Q',
            'sid'         => 'SMe563d847ca1f44ddb7fb61640f7bdde6',
            'created_at'  => '2019-08-15 21:23:32'
        ]);
        */

        
    }
}
