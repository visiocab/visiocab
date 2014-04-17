<div class="container">
  <div id="login-register">
  <?php
    if ($message = $this->session->flashdata('message')) {
      print "<div class=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>".$message."</div>";
    } ?>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

          <div class="col-sm-12">
            <fieldset>
              <form role="form" id="register-form" action='/index.php/auth/register' method="POST">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="first_name">Your First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="First" class="form-control">
                  </div>
                  <div class="col-sm-6">
                    <label for="last_name">Your Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Last" class="form-control">
                  </div>
                  <div class="col-sm-12">
                    <label for="email">Your Email Address</label>
                    <input type="text" id="email" name="email" placeholder="me@domain.com" class="form-control">
                  </div>
                  <div class="col-sm-6">
                    <label for="password2">Your Password</label>
                    <input type="password" id="password2" name="password" placeholder="Password" class="form-control">
                  </div>
                  <div class="col-sm-6">
                  <label for="password2">Confirm</label>
                    <input type="password" id="password2" name="confirm_password" placeholder="Password" class="form-control">
                  </div>
                  <div class="col-sm-6">
                    <button class="btn btn-warning btn-block">Create Account</button>
                  </div>
                  <div class="col-sm-6">
                    <a class="btn btn-default btn-block" href="/login">Go to Login</a>
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