<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //create default user
    	DB::table('users')->insert([
    		'name' => 'Christian Rosandhy',
    		'email' => 'tianrosandhy@gmail.com',
    		'password' => bcrypt('123456'), //Hash default laravel
    		'created_at' => date('Y-m-d H:i:s'),
    		'updated_at' => date('Y-m-d H:i:s'),
    	]);

    	//create example dummy post
    	DB::table('post')->insert([
    		'title' => 'Post Example Title',
    		'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, dignissimos magnam eum voluptate saepe quis iste. Dolor aliquid, et beatae.',
    		'created_at' => date('Y-m-d H:i:s'),
    		'updated_at' => date('Y-m-d H:i:s'),
    	]);
    	DB::table('post')->insert([
    		'title' => 'Another Title',
    		'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil, odit ab ea labore distinctio aut quam commodi deserunt expedita repudiandae nostrum. Illo aliquid, nemo quos maiores eos nostrum accusamus odit.',
    		'created_at' => date('Y-m-d H:i:s'),
    		'updated_at' => date('Y-m-d H:i:s'),
    	]);
    }
}
