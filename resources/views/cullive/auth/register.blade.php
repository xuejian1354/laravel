<div class="modal fade" role="dialog" id="registerOptModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="register-box">
          <div class="register-logo">
            <b>Register</b>
          </div>
          <div class="register-box-body">
            <form action="{{ url('/register') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name') }}"/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
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
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation"/>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
              </div>
              <div class="row">
                <div class="col-xs-1">
                  <label>
                    <div class="checkbox_register icheck">
                      <label>
                        <input type="checkbox" name="terms">
                      </label>
                    </div>
                  </label>
                </div><!-- /.col -->
                <div class="col-xs-6">
                  <div class="form-group">
                    <button type="button" class="btn btn-block btn-flat" data-toggle="modal" data-target="#termsModal">I agree to the terms</button>
                  </div>
                </div><!-- /.col -->
                <div class="col-xs-4 col-xs-push-1">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div><!-- /.col -->
              </div>
            </form>
            <a role="button" data-dismiss="modal" data-target="#loginOptModal" data-toggle="modal">I already have a membership</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>