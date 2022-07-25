@extends('layout.v_template')
@section('title', 'Data User')
@section('content')
<!-- This is what you need -->
    <script src="dist/sweetalert.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="dist/sweetalert.css">
    <!--.......................-->
<section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">

            <h3 class="box-title">Data User</h3>
            <div class="container">
                @if (count($errors) > 0)
            <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
            </ul>
            </div>
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-success">
                <p>{{\Session::get('success')}}</p>
                </div>
            @endif
            </div>
            </div>
                <div class="text-center">
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah">Tambah Data</a>
                </div>
            <div class="box-body">
            <table id="table-datatables" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Created At</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($userr as $data)
                    <tr>
                        <td class="text-center">{{$data->name}}</td>
                        <td class="text-center">{{$data->email}}</td>
                        <td class="text-center">{{$data->created_at}}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $data->id}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                <div class="modal modal-primary fade" id="tambah">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">TAMBAH DATA</h5>
                        </div>
                        <form action="/insert_userr/" method="POST">
                            @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" id="name" class="form-control">
                                <div class="text-danger">
                                    @error('name')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" id="email" class="form-control">
                                <div class="text-danger">
                                    @error('email')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <div class="text-danger">
                                    @error('password')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>Password Confirmation</label>
                                <input type="password" name="password_confirmation" id="password" class="form-control">
                                <div class="text-danger">
                                    @error('password_confirmation')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success sweet-3" onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-3']);" type="submit">Save Data</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                @foreach ($userr as $data)
                  <div class="modal modal-danger fade" id="delete{{ $data->id}}">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">{{ $data->id}}</h4>
                        </div>
                          <div class="modal-body">
                           <p>Apakah anda yakin ingin menghapus data ini???</p>
                          </div>
                        <div class="modal-footer">
                          <a href="/delete_userr/{{ $data->id}}" class="btn btn-success pull-left">Yes</a>
                          <a class="btn btn-warning" data-dismiss="modal">No</a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
<script>
      document.querySelector('.sweet-3').onclick = function(){
        swal("Adding User Complete!", "You clicked the button!", "success");
      };
    </script>
    <script>
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
    </script>
@endsection
