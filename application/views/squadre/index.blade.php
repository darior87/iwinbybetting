@layout('layouts.main')

@section('title')
Squadre
@endsection

@section('menu')
<?php echo render("layouts.menu",array(
    "active_squadre"    =>  "active ",
    "active_pronostici" =>  "",
    "active_campionati" =>  "",
    "active_partite"    =>  "",
    "campionati"        =>  $campionati
)) ?>
@endsection

@section('content')
<div class="container-fluid">
    <table class="table table-hover">
        <th>Squadre prive di assegnamento...</th>
        <?php if (count($squadreu) == 0) echo "<tr><td>nessuna</td></tr>"; ?>
        <?php foreach ($squadreu as $s) { ?>
                <tr>
                    <form action="<?php echo URL::base() . "/squadre/assignchamp/" . $s->id ?>" method="post">
                    <td>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 50px; height: 50px;"><img src="{{URL::base()."/squadre/".$s->nome.".".$s->image}}" /></div>

                        </div>
                    </td>
                    <td>
                        <div style="margin-top: 20px;">
                            <select class="span3" name="id">
                                <?php foreach ($campionati as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </td>
                    <td><div style="margin-top: 20px;">{{$s->nome}}</div></td>
                    <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>
                    <td><div style="margin-top: 20px;"><a href="{{URL::base()."/squadre/delete/".$s->id}}" class="btn" ><i class="icon-remove"></i></a></div></td>                    
            </form>
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