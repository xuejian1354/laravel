<div class="modal fade" role="dialog" id="loginOptModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="login-box">
          <div class="login-logo">
            <b>Logining</b>
          </div>

          <form action="{{ url('/login') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
              <input type="email" class="form-control" placeholder="Email" name="email"/>
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              @if ($errors->has('email'))
              <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Password" name="password"/>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              @if ($errors->has('password'))
              <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
            <div class="row">
              <div class="col-xs-8">
                <div class="checkbox icheck">
                  <label>
                    <input type="checkbox" name="remember">Remember Me
                  </label>
                </div>
              </div><!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
              </div><!-- /.col -->
            </div>
          </form>
          <a role="button" data-dismiss="modal" data-target="#registerOptModal" data-toggle="modal">Register a new membership</a>

        </div>
      </div>
    </div>
  </div>
</div>