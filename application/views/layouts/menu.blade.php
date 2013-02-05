    <li class="<?php echo $active_pronostici?>dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" >Pronostici</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a tabindex="-1" href="<?php echo URL::to_action("pronostici@index")?>">Vai Alla Pagina</a></li>
            <li class="divider"></li>
            <?php 
                foreach($campionati as $c){
                    echo "<li><a tabindex=\"-1\" href=\"".URL::base()."/pronostici/index/".$c->id."\">".$c->nome."</a></li>";
                }
            ?>
        </ul> 
    </li> 
    
    <li class="<?php echo $active_partite?>dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" >Partite</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a tabindex="-1" href="<?php echo URL::to_action("partite@index")?>">Vai Alla Pagina</a></li>
            <li class="divider"></li>
            <?php //campionati ?>
            <?php 
                foreach($campionati as $c){
                    echo "<li><a tabindex=\"-1\" href=\"".URL::base()."/partite/index/".$c->id."\">".$c->nome."</a></li>";
                }
            ?>
        </ul> 
    </li>
    
    <li class="<?php echo $active_squadre?>dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" >Squadre</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a tabindex="-1" href="<?php echo URL::to_action("squadre@index")?>">Vai Alla Pagina</a></li>
            <li class="divider"></li>
            <?php //campionati ?>
            <?php 
                foreach($campionati as $c){
                    echo "<li><a tabindex=\"-1\" href=\"".URL::base()."/squadre/index/".$c->id."\">".$c->nome."</a></li>";
                }
            ?>
        </ul> 
    </li>
    <li class="<?php echo $active_campionati?>dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" >Campionati</a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a tabindex="-1" href="<?php echo URL::to_action("campionati@index")?>">Vai Alla Pagina</a></li>
        </ul> 
    </li>
    <li>
        <a href="<?php echo URL::to_action('login@logout')?>">Log out</a>
    </li>