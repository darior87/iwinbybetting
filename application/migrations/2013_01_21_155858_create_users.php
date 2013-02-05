<?php

class Create_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
            
            Schema::create('users',function($table){
                $table->increments('id');
                $table->string('username', 50);
                $table->string('password', 64);
            });
	    DB::table('users')->insert(array(
                'username' => 'matteo',
                'password' => Hash::make('Skoda_123'),
            ));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('users');
	}

}