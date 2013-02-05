<?php

class Squadre_Controller extends Controller {
    /*
     * id campionato
     */

    private function iscrizione($id) {
        $iscrizione = array();
        $campionato = DB::table('campionati')->where('id', "=", $id)->first();
        if ($campionato == null) {
            return array();
        }
        //squadre di quel campionato
        $squadre = DB::query('select * from squadre where id in (select squadra from iscrizioni where campionato = ?)', array($id));
        foreach ($squadre as $s) {
            //iscrizioni di quella squadra in altri campionati
            $campionati = DB::query('select * from campionati where id in (select campionato from iscrizioni where squadra = ?)', array($s->id));
            foreach ($campionati as $c)
                array_push($iscrizione, array("\"" . $s->id . "\"" => $c->nome));
        }
        return $iscrizione;
    }

    public function action_index($id = "") {
        $campionati = DB::table('campionati')->get();
        if ($id == "") {
            $squadre_unassigned = DB::query('select * from squadre where id not in (select squadra from iscrizioni)');

            return View::make('squadre.index', array(
                        "campionati" => $campionati,
                        "error" => "scegli campionato dal menu",
                        "squadreu" => $squadre_unassigned,
                        "squadre" => DB::query('select * from squadre where id in (select squadra from squadre join iscrizioni on iscrizioni.squadra = squadre.id where iscrizioni.campionato = ?)', array($id)),
                    ));
        }
        if (Session::has('error'))
            $e = Session::get('error');
        else
            $e = "";
        return View::make('squadre.selected_champ', array(
                    "campionati" => $campionati,
                    "squadre" => DB::query('select * from squadre where id in (select squadra from squadre join iscrizioni on iscrizioni.squadra = squadre.id where iscrizioni.campionato = ?)', array($id)),
                    "iscrizione" => $this->iscrizione($id),
                    "campionato" => DB::table('campionati')->where('id', "=", $id)->first(),
                    "error" => $e
                ));
    }

    /*
     * @params
     * $id squadra
     */

    public function action_update($id = "", $campionato = "") {
        //check image, nome, assegnamento. controlla id se esiste
        $squadra = DB::table('squadre')->where('id', "=", $id)->first();
        $image = Input::file('image');
        if ($squadra == null) {
            return Redirect::to_action("squadre@index");
        }
        $inputs = Input::all();
        $rules = array(
            "nome" => "required|alpha",
            "image" => "image|max:1000"
        );

        $validation = Validator::make($inputs, $rules);

        if ($validation->fails()) {
            return Redirect::to(URL::base() . '/squadre/index/' . $campionato)->with("error", $validation->errors);
        }

        $old_image = DB::table('squadre')->where('id', "=", $id)->first();

        if (Input::get('campionati') != -1) {
            //iscrivi squadra nel nuovo campionato
            $iscriz = DB::table('iscrizioni')->where('squadra', "=", $id)->where('campionato', "=", Input::get('campionati'))->first();
            $campionato = DB::table('campionati')->where('id', "=", Input::get('campionati'))->first();
            if ($iscriz == null && Input::get('campionati') != null) {
                DB::table('iscrizioni')->insert(array(
                    "squadra" => $id,
                    "campionato" => Input::get('campionati')
                ));
            }
        }


        if ($squadra->nome != Input::get('nome')) {
            $nome_exists = DB::table('squadre')->where('nome', "=", Input::get('nome'))->get();
            if ($nome_exists != null) {
                return Redirect::to(URL::base() . '/squadre/index/' . $campionato);
            }



            if ($image['name'] == "") {

                rename(path('public') . 'squadre/' . $old_image->nome . "." . $old_image->image, path('public') . 'squadre/' . Input::get('nome') . "." . $old_image->image)
                        or die("Unable to rename image.");

                DB::table('squadre')->where('id', "=", $id)->update(array(
                    "nome" => Input::get('nome')
                ));
            } else {

                $ext = "";
                $filename_chunks = explode('.', Input::file('image.name'));
                foreach ($filename_chunks as $c) {
                    $ext = $c;
                }
                
                if(file_exists(path('public').'squadre/' . $old_image->nome . "." . $old_image->image))
                    if(unlink(path('public').'squadre/' . $old_image->nome . "." . $old_image->image)==0)
                        return "delete failed";
                
                if (Input::upload('image', path('public') . 'squadre/', Input::get('nome') . "." . $ext)) {
                    DB::table('squadre')->where("id", "=", $id)
                            ->update(array(
                                "nome" => Input::get('nome'),
                                "image" => $ext
                            ));
                } else {
                    return Redirect::to(URL::base() . '/squadre/index/' . $campionato)
                                    ->with("error", "immagine non salvata");
                }
            }
        } else if ($image['name'] != "") {
                $ext = "";
                $filename_chunks = explode('.', Input::file('image.name'));
                foreach ($filename_chunks as $c) {
                    $ext = $c;
                }
                            
                if(file_exists(path('public').'squadre/' . $old_image->nome . "." . $old_image->image))
                    if(unlink(path('public').'squadre/' . $old_image->nome . "." . $old_image->image)==0)
                        return "delete failed";

                Input::upload('image', path('public') . 'squadre/', Input::get('nome') . "." . $ext);

        }
        return Redirect::to_action('squadre@index');
    }

    /*
     * @params
     * $id squadra
     */

    public function action_delete($id = "") {
        //delete immagine, squadra
    }

    public function action_new($idc = "") {

        $inputs = Input::all();
        $image = Input::file('image');
        $rules = array(
            "nome" => "required|unique:squadre|alpha",
            "image" => "required|image|max:1000"
        );
        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return View::make("squadre.selected_champ", array(
                        "campionati" => DB::table('campionati')->get(),
                        "error" => $validation->errors,
                        "campionato" => DB::table('campionati')->where('id', '=', $idc)->first(),
                        "squadre" => DB::query('select * from squadre where id in (select squadra from squadre join iscrizioni on iscrizioni.squadra = squadre.id where iscrizioni.campionato = ?)', array($idc)),
                    ));
        }
        $ext = "";
        $filename_chunks = explode('.', Input::file('image.name'));
        foreach ($filename_chunks as $c) {
            $ext = $c;
        }

        if (Input::upload('image', 'public/squadre/', Input::get('nome') . "." . $ext)) {
            $id = DB::table('squadre')->insert_get_id(array(
                "nome" => Input::get('nome'),
                "image" => $ext
                    ));
            DB::table('iscrizioni')->insert(array(
                "campionato" => $idc,
                "squadra" => $id
            ));
        } else {
            //change the created file name to id.ext
            return View::make("squadre.index", array(
                        "campionati" => DB::table('campionati')->get(),
                        "campionato" => DB::table('campionati')->where('id', '=', $idc)->first(),
                        "error" => "problems uploading the image " . Input::file('image.name')
                    ));
        }
        return Redirect::to(URL::base() . '/squadre/index/' . $idc);
    }

    /*
     * @params
     * $nome campionato
     * $id squadra
     */

    public function action_removeassigment($nome = "", $id = "") {

        $idc = DB::table('campionati')->where("nome", "=", $nome)->first();
        if ($idc == NULL) {
            return Redirect::to_action('squadre@index')->with("error", "errore rimozione assegnamento campionato. non esiste campionato");
        }
        $iscrizione = DB::table('iscrizioni')->where('squadra', "=", $id)
                ->where('campionato', "=", $idc->id)
                ->first();
        if ($iscrizione == null) {
            return Redirect::to_action('squadre@index')
                            ->with("error", "errore rimozione assegnamento campionato. non esiste iscrizione squadra");
        }

        DB::table('iscrizioni')->where('squadra', "=", $id)
                ->where('campionato', "=", $idc->id)
                ->delete();


        return Redirect::to(URL::base() . '/squadre/index/' . $idc->id)
                        ->with("error", "errore rimozione assegnamento campionato. non esiste iscrizione squadra");
    }

    public function action_assignchamp($id = "") {
        $inputs = Input::all();
        $rules = array(
            "id" => "required|exists:campionati"
        );
        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return Redirect::to_action('squadre@index')
                            ->with('error', $validation->errors);
        }
        $campionato = DB::table('campionati')->where("id", "=", Input::get('id'))->first();
        $squadra = DB::table('squadre')->where('id', "=", $id)->first();

        if ($campionato == NULL) {
            return Redirect::to_action('squadre@index')
                            ->with("error", "errore assegnamento campionato. non esiste campionato");
        }
        $iscrizione = DB::table('iscrizioni')->where('squadra', "=", $squadra->id)
                ->where('campionato', "=", $campionato->id)
                ->first();
        if ($iscrizione == null) {

            DB::table('iscrizioni')->insert(array(
                "campionato" => $campionato->id,
                "squadra" => $squadra->id
            ));
            return Redirect::to_action('squadre@index');
        }
        return Redirect::to_action('squadre@index')
                        ->with("error", "errore rimozione assegnamento campionato. non esiste squadra");
    }

}