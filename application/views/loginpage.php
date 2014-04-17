<div class="container">
  <div id="login-register">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">

        <? if ($message != '') { ?>
          <div class="row">
            <div class="col-sm-12 alert-success">
              <?=$message?>
            </div>
          </div>
        <? } ?>
        <div class="row">
          <div class="col-sm-12">
            <fieldset>
              <form id="login-form" action="/index.php/auth/login" method="POST">
                <label for="username">Username</label>
                <input type="email" id="username" name="login" placeholder="Email Address" class="form-control">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                <div class="row" >
                  <div class="col-sm-6">
                    <button id="login" type="submit" class="btn btn-warning btn-block">Login</button>
                  </div>
                  <div class="col-sm-6">
                    <a class="btn btn-default btn-block" href="/register">Go to Registration</a>
                  </div>
                </div>
              </form>
            </fieldset>
          </div>
        </div>
          
      </div>
    </div>
  </div>
</div>