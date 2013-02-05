<?php

class Home_Controller extends Controller {

	public function action_index()
	{
		return Redirect::to_action("login@index");
	}

}