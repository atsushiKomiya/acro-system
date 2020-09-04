@section('header')
    <appheader 
      :appname="'{{ Config::get('app.name_ja') }}'"
      :authinfo='@json(session('auth_info'))'>
    </appheader>
@endsection