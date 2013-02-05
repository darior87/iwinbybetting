<?php

class Login_Controller extends Controller{
    public function action_index(){

        
        return View::make("login.index",array(
            "error" =>  Session::get('error')
        ));
    }
    public function action_logout(){
        Session::flush();
        return Redirect::to_action('login@index');
    }
    public function action_validate(){
        //validation process
        $inputs = Input::all();
        $rules = array(
            'username'  =>  'required|exists:users',
            'password'  =>  'required'
        );
        $validation = Validator::make($inputs,$rules);
    
        if($validation->fails()){
            return Redirect::to_action("login@index")->with("error", $validation->errors);   
        }
        
        $user = DB::table('users')->where('username', '=', Input::get('username'))->get();
        if(Hash::check(Input::get('password'),$user[0]->password)){
            Session::put('logged','yes');
            return Redirect::to_action("partite@index");
        }
        return Redirect::to_action("login@index")->with("error","login failed ");
    }
}