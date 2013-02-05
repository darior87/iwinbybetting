<?php

class Create_Iscrizioni {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('iscrizioni',function($table){
                $table->increments('id');
                $table->integer('squadra',false);
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
            Schema::drop('iscrizioni');
	}

}