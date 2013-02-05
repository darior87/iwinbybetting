@layout('layouts.main')

@section('title')
Partite - {{$campionato->nome}}
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
        <tr><td colspan="3">{{var_dump($error)}}</td></tr>
        <?php foreach ($partite as $p) { ?>
                <tr> 
                    <td>
                        {{DB::table('squadre')->where('id','=',$p->casa)->first()->nome}}
                         VS 
                        {{DB::table('squadre')->where('id','=',$p->trasferta)->first()->nome}}                       
                    </td>
                    <td>
                        {{$p->data}}
                    </td>
                    <td>
                        <a href="{{URL::base()."/pronostici/index/_/".$p->id }}" class="btn"><i class="icon-arrow-right"></i></a>
                    </td>
                </tr> 
        <?php } ?> 
    </table>
</div>
@endsection