@layout('layouts.main')

@section('title')
Campionati
@endsection


@section('menu')
<?php echo render("layouts.menu",array(
    "active_squadre"    =>  "",
    "active_pronostici" =>  "",
    "active_campionati" =>  "active ",
    "active_partite"    =>  "",
    "campionati"        =>  $campionati
)) ?>
@endsection


@section('content')
<div class="container-fluid">
    <table class="table table-hover">
        <tr>
        <form action="<?php echo URL::to_action("campionati@new") ?>" method="post" enctype='multipart/form-data'>
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
            <td><div style="margin-top: 20px;"><input type="text" name="nome" placeholder="Nome Campionato" /></div></td>
            <td><div style="margin-top: 20px;"><button type="submit" class="btn" ><i class="icon-ok"></i></button></div></td>
        </form>
        </tr>
        <tr><td colspan="3"><?php if(isset($error) && $error != null)var_dump($error)?></td></tr>
        <?php foreach ($campionati as $campionato): ?>
            <tr>
            <form action="<?php echo URL::base()."/campionati/alter/".$campionato->nome ?>" method="post" enctype='multipart/form-data'>
                <td>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 50px; height: 50px;"><img src="<?php echo URL::base()."/campionati/".$campionato->nome.".".$campionato->image?>" /></div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
                        <span class="btn btn-file">
                            <span class="fileupload-new">Select image</span>
                            <span class="fileupload-exists">Change</span><input type="file" name="image" />
                        </span>
                    </div>
                </td>
                <td><div style="margin-top: 20px;"><input type="text" name="nome" value="<?php echo $campionato->nome ?>" class="fileupload" /></div></td>
                <td><div style="margin-top: 20px;"><button type="submit" class="btn"><i class="icon-ok"></i></button></div></td>
                <td><div style="margin-top: 20px;"><a href="<?php echo URL::base()."/campionati/delete/".$campionato->nome ?>" class="btn"><i class="icon-remove"></a></div></td>
            </form>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
@endsection