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
        <form action="{{URL::base()."/partite/new/".$campionato->id}}" method="post">
                <tr>   
                    
                    <td>
                        <div style="margin-top: 20px;">
                            Casa : <select class="span3" name="casa">
                                <option value="-1">---</option>
                                <?php foreach ($squadre as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div style="margin-top: 20px;">
                            Trasferta : <select class="span3" name="trasferta">
                                <option value="-1">---</option>
                                <?php foreach ($squadre as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </td>
                    <td><div style="margin-top: 20px;"><input type="text" name="data" placeholder="Data Partita [AAAA-MM-GG]" /></div></td>
                    <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>
                </tr>
        </form>
        <tr><td colspan="3">{{var_dump($error)}}</td></tr>
        <?php foreach ($partite as $p) { ?>
                <tr>   
                    <form action="<?php echo URL::base()."/partite/alter/".$p->id ?>" method="post">
                        <td>
                            <div style="margin-top: 20px;">
                                Casa : 
                                <select class="span3" name="casa">
                                    <?php foreach ($squadre as $c): ?>
                                    
                                        <?php if($c->id == $p->casa) :?>
                                        <option value="<?php echo $c->id ?>" selected="selected"><?php echo $c->nome ?></option>
                                        <?php else:?>
                                        <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                        <?php endif; ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div style="margin-top: 20px;">
                                Trasferta : 
                                <select class="span3" name="trasferta">
                                    <?php foreach ($squadre as $c): ?>
                                        <?php if($c->id == $p->trasferta) :?>
                                        <option value="<?php echo $c->id ?>" selected="selected"><?php echo $c->nome ?></option>
                                        <?php else:?>
                                        <option value="<?php echo $c->id ?>"><?php echo $c->nome ?></option>
                                        <?php endif;?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </td>
                    <td><div style="margin-top: 20px;"><input type="text" name="data" placeholder="Data Partita [AAAA-MM-GG]" value="{{$p->data}}" /></div></td>
                    <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>                    
                    <td><div style="margin-top: 20px;"><a href="{{URL::base()."/partite/delete/".$p->id}}" class="btn" ><i class="icon-remove"></i></a></div></td>                    
                    </form>
                </tr> 
        <?php } ?> 
    </table>
</div>
@endsection