<?php

class Create_Squadre {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
	
            Schema::create('squadre',function($table){
                $table->increments('id');
                $table->string('nome',50);
                $table->string('image',255);
            });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('squadre');
	}

}