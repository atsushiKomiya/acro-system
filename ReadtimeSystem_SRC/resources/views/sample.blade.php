<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Title</title>
</head>

<body>
  <form method="POST" action="/logi_improve/login">
    @csrf
    <div>
      <label for="login_cd" class="col-md-4 col-form-label text-md-right">{{ __('login_cd Address') }}</label>

      <div class="col-md-6">
        <input id="login_cd" type="login_cd" class="form-control @error('login_cd') is-invalid @enderror"
          name="login_cd" value="{{ old('login_cd') }}" required autocomplete="login_cd" autofocus>

        @error('login_cd')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>

    <div>
      <label for="pass" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

      <div class="col-md-6">
        <input id="pass" type="pass" class="form-control @error('pass') is-invalid @enderror" name="pass" required
          autocomplete="current-password">

        @error('pass')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>

    <div>
      <label for="auth_cls" class="col-md-4 col-form-label text-md-right">{{ __('auth_cls Address') }}</label>

      <div class="col-md-6">
        <input id="auth_cls" type="auth_cls" class="form-control @error('auth_cls') is-invalid @enderror"
          name="auth_cls" value="{{ old('auth_cls') }}" autocomplete="auth_cls" autofocus>

        @error('auth_cls')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
    </div>

    <div>
      <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
          {{ __('Login') }}
        </button>
      </div>
    </div>
  </form>

  <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>