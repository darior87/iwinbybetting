@layout('layouts.main')

@section('title')
Pronostici
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
    <div class="row-fluid">
        <table class="table table-hover">
        <tr>
            <td>
                Seleziona Campionato dal menu...
            </td>
        </tr>
    </table>
    </div>
</div>
@endsection