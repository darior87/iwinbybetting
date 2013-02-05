@layout('layouts.main')

@section('title')
Login
@endsection

@section('menu')

@endsection

@section('content')
<div class="container">

      <form class="form-signin" action="<?php echo URL::to_action("login@validate")?>" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="username" class="input-block-level" placeholder="Username">
        <input type="password" name="password" class="input-block-level" placeholder="Password">

        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>
        <?php if($error != null):?>
            <?php var_dump($error); ?>
        <?php endif;?>
    </div> <!-- /container -->
@endsection