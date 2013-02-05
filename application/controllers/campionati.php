<?php

class Campionati_Controller extends Controller {

    public function action_index() {
        return View::make('campionati.index', array(
                    "campionati" => DB::table('campionati')->get(),
                    "error" => Session::get('error')
                ));
    }

    public function action_new() {

        $inputs = Input::all();
        $image = Input::file('image');
        $rules = array(
            "nome" => "required|unique:campionati|alpha",
            "image" => "required|image|max:1000"
        );
        
        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return View::make("campionati.index", array(
                        "campionati" => DB::table('campionati')->get(),
                        "error" => $validation->errors
                    ));
        }
        
        $ext = "";
        $filename_chunks = explode('.', Input::file('image.name'));
        foreach ($filename_chunks as $c) {
            $ext = $c;
        }
        
        if (Input::upload('image', 'public/campionati/', Input::get('nome') . "." . $ext)) {
            DB::table('campionati')->insert(array(
                "nome" => Input::get('nome'),
                "image" => $ext
            ));
        } else {
            //change the created file name to id.ext
            return View::make("campionati.index", array(
                        "campionati" => DB::table('campionati')->get(),
                        "error" => "problems uploading the image " . Input::file('image.name')
                    ));
        }
        return Redirect::to_action('campionati@index');
    }

    /*
     * @params
     * $id è nome squadra
     */
    public function action_alter($id = "") {
        $inputs = Input::all();
        $image = Input::file('image');
        $rules = array(
            "nome" => "required|unique:campionati|alpha",
            "image" => "image|max:1000"
        );
        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            if ($image['name'] == "" && $id == Input::get('nome'))
                return View::make("campionati.index", array(
                            "campionati" => DB::table('campionati')->get(),
                            "error" => $validation->errors
                        ));
        }

        $old_image = DB::table('campionati')->where('nome', "=", $id)->first();

        if ($image['name'] == "") {

            DB::table('campionati')->where("nome", "=", $id)
                    ->update(array("nome" => Input::get('nome')));

            if ($id != Input::get('name'))
                rename(path('public') . '/campionati/' . $id . "." . $old_image->image, path('public') . '/campionati/' . Input::get('nome') . "." . $old_image->image) or die("Unable to rename image.");

            return View::make("campionati.index", array(
                        "campionati" => DB::table('campionati')->get(),
                        "error" => $id . " updated to " . Input::get('nome')
                    ));
        }else {

            $ext = "";
            $filename_chunks = explode('.', Input::file('image.name'));
            foreach ($filename_chunks as $c) {
                $ext = $c;
            }
            if (Input::upload('image', 'public/campionati/', Input::get('nome') . "." . $ext)) {
                DB::table('campionati')->where("nome", "=", $id)
                        ->update(array(
                            "nome" => Input::get('nome'),
                            "image" => $ext
                        ));
            } else {
                //change the created file name to id.ext
                return View::make("campionati.index", array(
                            "campionati" => DB::table('campionati')->get(),
                            "error" => "problems uploading the image " . Input::file('image.name')
                        ));
            }
        }
        return Redirect::to_action('campionati@index');
    }

    public function action_delete($id = "") {
        $inputs = array('nome' => $id);

        $rules = array(
            "nome" => "required|exists:campionati"
        );
        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return View::make("campionati.index", array(
                        "campionati" => DB::table('campionati')->get(),
                        "error" => $validation->errors
                    ));
        }
        DB::table('campionati')->where("nome", "=", $id)->delete();
        return Redirect::to_action('campionati@index');
    }

}