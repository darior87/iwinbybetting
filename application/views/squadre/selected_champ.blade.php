@layout('layouts.main')

@section('title')
Squadre - {{$campionato->nome}}
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
        <form action="<?php echo URL::base()."/squadre/new/".$campionato->id ?>" method="post" enctype='multipart/form-data'>
                <tr>
                    <td>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 50px; height: 50px;"><img src="http://www.placehold.it/50x50/EFEFEF/AAAAAA" /></div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
                            <span class="btn btn-file">
                                <span class="fileupload-new">Select image</span>
                                <span class="fileupload-exists">Change</span><input type="file" name="image" />
                            </span>
                        </div>
                    </td>
                    <td><div style="margin-top: 20px;"><input type="text" name="nome" placeholder="Nome Squadra" /></div></td>
                    <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>
                </tr>
        </form>
        <?php 
        if(isset($error) && $error != null) echo var_dump($error);
        ?>
    <?php foreach ($squadre as $s) { ?>
        <form action="<?php echo URL::base() . "/squadre/update/" . $s->id ."/".$campionato->id?>" method="post" enctype='multipart/form-data'>

                <tr>
                    <td>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 50px; height: 50px;"><img src="{{URL::base()."/squadre/".$s->nome.".".$s->image}}" /></div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
                            <span class="btn btn-file">
                                <span class="fileupload-new">Select image</span>
                                <span class="fileupload-exists">Change</span><input type="file" name="image" />
                            </span>
                        </div>
                    </td>
                    <td>
                        <div style="margin-top: 20px;">
                            <select class="span3" name="campionati">
                                <option value="-1">---</option>
                                <?php foreach ($campionati as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                <?php endforeach ?>
                            </select>
                            <br />
                            <p>
                                Iscritto a: <br/>
                                <?php 
                                for($i = 0; $i< count($iscrizione);$i++){
                                    if(array_key_exists("\"".$s->id."\"", $iscrizione[$i]))
                                       echo $iscrizione[$i]["\"".$s->id."\""] . " <a class=\"btn\" href=\"".URL::base()."/squadre/removeassigment/".$iscrizione[$i]["\"".$s->id."\""]."/".$s->id."\"><i class=\"icon-remove\"></i></a><br />";

                                }
                                ?>
                            </p>
                        </div>
                    </td>
                    <td><div style="margin-top: 20px;"><input type="text" name="nome" placeholder="Nome Squadra" value="{{$s->nome}}" /></div></td>
                    <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>
                </tr>
        </form>
    <?php } ?>            
    </table>

</div>
@endsection