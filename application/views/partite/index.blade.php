@layout('layouts.main')

@section('title')
Partite
@endsection


@section('menu')
<?php echo render("layouts.menu",array(
    "active_squadre"    =>  "",
    "active_pronostici" =>  "",
    "active_campionati" =>  "",
    "active_partite"    =>  "active ",
    "campionati"        =>  $campionati
)) ?>
@endsection

@section('content')
<div class="container-fluid">
    <table class="table table-hover">
        <th>Partite in errore...</th>
        <?php if (count($partiteu) == 0) echo "<tr><td>nessuna</td></tr>"; ?>
        <?php foreach ($partiteu as $p) { ?>
                <tr>                    
                    <td><div style="margin-top: 20px;">Casa: {{$s->casa}}</div></td>
                    <td><div style="margin-top: 20px;">Trasferta: {{$s->trasferta}}</div></td>
                    <td><div style="margin-top: 20px;">Campionato: {{$s->campionato}}</div></td>
                    <td><div style="margin-top: 20px;"><a href="{{URL::base()."/partite/delete/".$p->id}}" class="btn" ><i class="icon-remove"></i></a></div></td>                    
                </tr> 
        <?php } ?> 
        <tr>
            <td>
                {{$error}}
            </td>
        </tr>
    </table>
</div>
@endsection