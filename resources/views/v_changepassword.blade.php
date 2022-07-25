@extends('layout.v_template')
@section('title', 'Change Password')
    <!-- This is what you need -->
    <script src="dist/sweetalert.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="dist/sweetalert.css">
    <!--.......................-->
@section('content')
    <div class="login-box">
        <div class="login-box-body">
            <div class="card-body">
                <div>
                    <form method="POST" action="{{ route('change.password') }}">
                        @csrf

                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-right">Current Password</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-right">New Password</label>

                            <div class="col-md-12">
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-right">New Confirm Password</label>

                            <div class="col-md-12">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-12">
                                <button class="btn btn-primary sweet-3" onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-3']);">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <script>
      document.querySelector('.sweet-3').onclick = function(){
        swal("Password Changed!", "You clicked the button!", "success");
      };
    </script>
    <script>
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
    </script>
@endsection
