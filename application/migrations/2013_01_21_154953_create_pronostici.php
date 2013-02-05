<?php

class Create_Pronostici {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('pronostici',function($table){
                $table->increments('id');
                $table->text('testo');
                $table->integer('partita',false);
                $table->integer('rischio',false);
            });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('pronostici');
	}

}