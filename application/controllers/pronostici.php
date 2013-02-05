<?php

class Pronostici_Controller extends Controller {

	public function action_index($campionato = "",$id = "")
	{
            
            //manca campionato
            if($campionato == ""){
		return View::make('pronostici.index',array(
                    "campionati"    =>  DB::table('campionati')->get(),
                    "error"         =>  "seleziona campionato dal menu"
                ));
            }
                        
            //manca partita
            if($id == ""){
		return View::make('pronostici.partite',array(
                    "campionati"    =>  DB::table('campionati')->get(),
                    "campionato"    =>  DB::table('campionati')->where('id',"=",$campionato)->first(),
                    "error"         =>  "seleziona partita...",
                    "partite"       =>  DB::table('partite')->where('campionato',"=",$campionato)->where('data',">",date('Y-m-d'))->get()
                ));                
            }
            
            if($campionato != "_" && DB::table('campionati')->where('id',"=",$campionato)->first() == null){
                return View::make('pronostici.index',array(
                    "campionati"    =>  DB::table('campionati')->get(),
                    "error"         =>  "campionato inesistente"
                ));
            }
            
            //autorizzo operazioni
            return View::make('pronostici.pronostici',array(
                "campionati"    =>  DB::table('campionati')->get(),
                "error"         =>  "",
                "partita"       =>  DB::table('partite')->where('id','=',$id)->first(),
                "campionato"    =>  DB::first('select * from campionati where id in (select campionato from partite where id = ?)',array($id)),
                "pronostici"    =>  DB::table('pronostici')->where('partita','=',$id)->get(),
                "casa"          =>  DB::first('select * from squadre where id = (select casa from partite where id = ?)',array($id)),
                "trasferta"     =>  DB::first('select * from squadre where id = (select trasferta from partite where id = ?)',array($id)),
                "data"          =>  DB::table('partite')->where('id','=',$id)->first()
            ));
	}
        
        public function action_alter($id = ""){
            
            $inputs = Input::all();
            $rules = array(
                "rischio"   =>  "required|numeric|in:1,2,3,4,5",
                "testo"     =>  "required"
            );
            $campionato = DB::first('select * from campionati where id = (select campionato from partite where id = (select partita from pronostici where id = ?))',array($id));
            $validator = Validator::make($inputs,$rules);
            $partita = DB::first('select * from partite where id = (select partita from pronostici where id = ?)',array($id));
            
            if(DB::table('pronostici')->where('id','=',$id)->first() == null || $partita->id == null){
                return Redirect::to(URL::base()."/pronostici/index/_/".$partita->id)->with("error","partita non esiste...");
            }
            
            if($validator->fails()){
                return Redirect::to(URL::base()."/pronostici/index/_/".$partita->id)->with("error",$validator->errors);
            }else{
                DB::table('pronostici')->where('id','=',$id)->update(array(
                    "testo"     =>  Input::get('testo'),
                    "rischio"   =>  Input::get('rischio')
                ));
                return Redirect::to(URL::base()."/pronostici/index/_/".$partita->id);
            }
        }
        
        public function action_delete($id = ""){
            $pronostico = DB::table('pronostici')->where('id','=',$id)->first();
            
            if($pronostico == null)
                return Redirect::to(URL::base()."/pronostici/index/")->with('error','non esiste il pronostico');
            
            DB::table('pronostici')->where('id','=',$id)->delete();
            
            return Redirect::to(URL::base()."/pronostici/index/")->with('error','pronostico eliminato');
            
        }
        
        public function action_new($id = ""){
            $inputs = Input::all();
            $rules = array(
                "rischio"   =>  "required|numeric|in:1,2,3,4,5",
                "testo"     =>  "required"
            );
            $campionato = DB::first('select * from campionati where id = (select campionato from partite where id = ?)',array($id));
            $validator = Validator::make($inputs,$rules);
            
            if(DB::table('partite')->where('id','=',$id)->first() == null){
                return Redirect::to(URL::base()."/pronostici/index/_/".$id)->with("error","partita non esiste...");
            }
            
            if($validator->fails()){
                return Redirect::to(URL::base()."/pronostici/index/_/".$id)->with("error",$validator->errors);
            }else{
                DB::table('pronostici')->insert(array(
                    "testo"     =>  Input::get('testo'),
                    "rischio"   =>  Input::get('rischio'),
                    "partita"   =>  $id
                ));
                return Redirect::to(URL::base()."/pronostici/index/_/".$id);
            }
            
        }

}