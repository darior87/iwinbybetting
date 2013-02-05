<?php

class Partite_Controller extends Controller {
    /*
     * @params
     * campionato id
     */

    public function action_index($id = "") {
            $error = "";
            if (Session::has('error')) {
                $error = Session::get('error');
            }
        if ($id == "") {
            return View::make('partite.index', array(
                        "campionati" => DB::table('campionati')->get(),
                        "partiteu" => array(),
                        "partite" => array(),
                        "error" => $error
                    ));
        }
        
        if(DB::table('campionati')->where('id',"=",$id)->first() == null){
            return View::make('partite.index', array(
                        "campionati" => DB::table('campionati')->get(),
                        "partiteu" => array(),
                        "partite" => array(),
                        "error" => ""
                    ));
        }
        return View::make('partite.champ_selected', array(
                    "campionati"    => DB::table('campionati')->get(),
                    "campionato"    => DB::table('campionati')->where('id', "=", $id)->first(),
                    "error"         => $error,
                    "partite"       => DB::table('partite')->where('campionato', "=", $id)->where('data','>',date('Y-m-d'))->get(),
                    "squadre"       => DB::query('select * from squadre where id in (select squadra from iscrizioni where campionato = ?)', array($id)),
                ));
    }

    /*
     * @params
     * partita id
     */

    public function action_delete($id = "") {
        $partita = DB::table('partite')->where('id', "=", $id)->first();
        if ($partita != null) {
            DB::table('partite')->where('id', "=", $id)->delete();
            DB::table('pronostici')->where('partita', "=", $id)->delete();
        }
        return Redirect::to(URL::base() . "/partite/index/" . $id);
    }

    /*
     * @params
     * partita id
     */

    public function action_alter($id = "") {
        $partita = DB::table('partite')->where('id', "=", $id)->first();
        $campionato = DB::table('campionati')->where('id','=',$partita->campionato)->first();
        if($campionato == null){
            return Redirect::to(URL::base()."/partite/index/")->with("error","campionato inesistente");
        }
        if ($partita != null) {
            $inputs = Input::all();
            $rules = array(
                "casa"      => "required|exists:squadre,id",
                "trasferta" => "required|exists:squadre,id",
                "data"      => "required|after:" . ($partita->data +1) 
            );
            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return Redirect::to(URL::base() . "/partite/index/" . $campionato->id)->with("error", $validator->errors);
            }

            if (Input::get('casa') == Input::get('trasferta')) {
                return Redirect::to(URL::base() . "/partite/index/" . $campionato->id)->with("error", "stesse squadre");
            }

            $casa = DB::query('select * from campionati where id in (select campionato from iscrizioni where squadra = ?)', array(Input::get('casa')));
            $trasferta = DB::query('select * from campionati where id in (select campionato from iscrizioni where squadra = ?)', array(Input::get('trasferta')));

            $iscrizione_stesso_campionato = false;
            foreach ($casa as $c) {
                foreach ($trasferta as $t) {
                    if ($c->id == $t->id) {
                        $iscrizione_stesso_campionato = true;
                    }
                }
            }
            if ($iscrizione_stesso_campionato) {
                DB::table('partite')->where('id',"=",$partita->id)->update(array(
                    "data"      => Input::get('data'),
                    "trasferta" => Input::get('trasferta'),
                    "casa"      => Input::get('casa')
                ));
                return Redirect::to(URL::base() . "/partite/index/" . $campionato->id)->with("error","modifica effettuata");
            }else
                return Redirect::to(URL::base() . "/partite/index/" . $campionato->id)->with("error","modifica non effettuata");

        }
        
                return Redirect::to(URL::base() . "/partite/index/" . $campionato->id)->with("error","errore sconosciuto");
    }

    /*
     * @params
     * campionato id
     */

    public function action_new($id = "") {
        $inputs = Input::all();
        $rules = array(
            "casa" => "required|exists:squadre,id",
            "trasferta" => "required|exists:squadre,id",
            "data" => "required|after:" . date('Y-m-d')
        );

        $validation = Validator::make($inputs, $rules);

        if ($validation->fails()) {
            return Redirect::to(URL::base() . "/partite/index/" . $id)->with("error", $validation->errors);
        }

        if (Input::get('casa') == Input::get('trasferta')) {
            return Redirect::to(URL::base() . "/partite/index/" . $id)->with("error", "casa dev'essere diverso da trasferta");
        }

        $duplicato = DB::table('partite')->where('casa', "=", Input::get('casa'))->where('trasferta', "=", Input::get('trasferta'))->where('data', "=", Input::get('data'))->first();
        $casa = DB::query('select * from campionati where id in (select campionato from iscrizioni where squadra = ?)', array(Input::get('casa')));
        $trasferta = DB::query('select * from campionati where id in (select campionato from iscrizioni where squadra = ?)', array(Input::get('trasferta')));
        $iscrizione_stesso_campionato = false;
        foreach ($casa as $c) {
            foreach ($trasferta as $t) {
                if ($c->id == $t->id) {
                    $iscrizione_stesso_campionato = true;
                }
            }
        }
        $esiste_campionato = DB::table('campionati')->where('id', "=", $id)->first();

        if ($duplicato == null && $iscrizione_stesso_campionato && $esiste_campionato != null) {
            DB::table('partite')->insert(array(
                "data" => Input::get('data'),
                "trasferta" => Input::get('trasferta'),
                "casa" => Input::get('casa'),
                "campionato" => $id
            ));
            return Redirect::to(URL::base() . "/partite/index/" . $id);
        }

        return Redirect::to(URL::base() . "/partite/index/" . $id)->with("error", "la partita esiste già");
    }

}