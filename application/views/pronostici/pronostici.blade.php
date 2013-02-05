@layout('layouts.main')

@section('title')
Partite {{$campionato->nome}} - {{$casa->nome}} VS {{$trasferta->nome}} <br/><h4>{{$data->data}}</h4>
@endsection


@section('menu')
<?php echo render("layouts.menu",array(
    "active_squadre"    =>  "",
    "active_pronostici" =>  "active ",
    "active_campionati" =>  "",
    "active_partite"    =>  "",
    "campionati"        =>  $campionati
)) ?>
@endsection

@section('content')
<div class="container-fluid">
    <table class="table table-hover">
        <form action="{{URL::base()."/pronostici/new/".$partita->id}}" method="post">
              <tr>   
                    <td> Inserisci nuovo pronostico<br/>
                        <div style="margin-top: 20px;">
                            <input type="text" placeholder="Rischio 1,2,3,4,5" name="rischio" />
                        </div>
                    </td>
                    <td><div style="margin-top: 20px;"><textarea rows="" name="testo" placeholder="Testo Pronostico"></textarea></div></td>
                    <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>
                </tr>
        </form>
        <tr><td colspan="3">{{var_dump($error)}}</td></tr>
        <?php foreach ($pronostici as $p) { ?>
                <tr>   
                    <form action="<?php echo URL::base()."/pronostici/alter/".$p->id ?>" method="post">
                        <td>
                            <div style="margin-top: 20px;">
                                Rischio:<br /><input type="text" placeholder="1,2,3,4,5" name="rischio" value="{{$p->rischio}}" />
                            </div>
                        </td>
                        <td> <div style="margin-top: 20px;">Testo:<br /><textarea name="testo" rows="8" placeholder="Testo Pronostico">{{$p->testo}}</textarea></div></td>
                    <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>                    
                    <td><div style="margin-top: 20px;"><a href="{{URL::base()."/pronostici/delete/".$p->id}}" class="btn"><i class="icon-remove"></i></a></div></td>    
                    <input type="hidden" name="partita" value="{{$p->partita}}" />
                    </form>
                </tr> 
        <?php } ?> 
    </table>
</div>
@endsection