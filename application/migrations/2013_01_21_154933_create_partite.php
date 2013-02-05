<?php

class Create_Partite {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
            
            Schema::create('partite',function($table){
                $table->increments('id');
                $table->timestamp('data');
                $table->integer('casa',false);
                $table->integer('trasferta',false);
                $table->integer('campionato',false);
            });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('partite');
	}

}