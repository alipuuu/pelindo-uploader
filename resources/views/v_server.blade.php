@extends('layout.v_template')
@section('title', 'Data Server')
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
            <h3 class="box-title">Data Server</h3>
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
                <th class="text-center">Server Name</th>
                <th class="text-center">FTP Username</th>
                <th class="text-center">IP Address</th>
                <th class="text-center">URL Domain</th>
                <th class="text-center">FTP Password
                    <button class="btn btn-default reveal" type="button"><i class="glyphicon glyphicon-eye-open"></i></button>
                </th>
                <th class="text-center">FTP Password Confirmation</th>
                <th class="text-center">Note</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($server as $data)
                    <tr>
                        <td class="text-center">{{ $data->server_name}}</td>
                        <td class="text-center">{{ $data->ftp_uname}}</td>
                        <td class="text-center">{{ $data->ip_address}}</td>
                        <td class="text-center">{{ $data->url_domain}}</td>
                        {{-- <td class="text-center"><a href="{{ $data->url_domain}}">{{ $data->url_domain}}</a></td> --}}
                        <td class="text-center"> <input type="password" class="form-control pwd" value="{{ $data->ftp_password}}" disabled/></td>
                        <td class="text-center"> <input type="password" class="form-control pwd" value="{{ $data->ftp_password_confirm}}"disabled/></td>
                        <td class="text-center">{{ $data->note}}</td>
                        <td class="text-center">
                            <?php if($data->status == '1'){ ?>
                            <a href="{{url('/update_server',$data->id)}}" class="btn btn-success">Active</a>
                            <?php }else{ ?>
                            <a href="{{url('/update_server',$data->id)}}" class="btn btn-danger">Inactive</a>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $data->id}}">Update</a>
                            <a class="btn btn-danger" data-toggle="modal" data-target="#delete{{ $data->id}}">Delete</a>
                        </td>
                    </tr>
                </div>
                @endforeach
                <div class="modal modal-primary fade" id="tambah">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">TAMBAH DATA</h5>
                        </div>
                        <form action="/insert_server/" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Server Name</label>
                                <input name="server_name" id="server_name" class="form-control" value="{{old('server_name')}}" required>
                                <div class="text-danger">
                                    @error('server_name')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>FTP Username</label>
                                <input name="ftp_uname" id="ftp_uname" class="form-control" value="{{old('ftp_uname')}}" required>
                                <div class="text-danger">
                                    @error('ftp_uname')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>FTP Password</label>
                                <input name="ftp_password" type="password" id="ftp_password" class="form-control" value="{{old('ftp_password')}}" required>
                                <div class="text-danger">
                                    @error('date')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>FTP Password Confirmation</label>
                                <input name="ftp_password_confirm" type="password" id="ftp_password" class="form-control" value="{{old('ftp_password_confirm')}}" required>
                                <div class="text-danger">
                                    @error('ftp_password_confirm')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>IP Address</label>
                                <input name="ip_address" placeholder="xxx.xxx.xxx.xxx" id="ip_address" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" class="form-control" value="{{old('ip_address')}}" required>
                                <div class="text-danger">
                                    @error('ip_address')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>URL Domain</label>
                                <input name="url_domain" id="url_domain" class="form-control" value="{{old('url_domain')}}" required>
                                <div class="text-danger">
                                    @error('url_domain')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>Note</label>
                                <input name="note" id="ip_address" class="form-control" value="{{old('note')}}" required>
                                <div class="text-danger">
                                    @error('note')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <input name="status" id="status" class="form-control" value="1" type="hidden">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success sweet-3" type="submit" onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-3']);">Save Data</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                @foreach ($server as $data)
                  <div class="modal modal-warning fade" id="update{{ $data->id}}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h5 class="modal-title">UPDATE DATA {{ $data->id}}</h5>
                        </div>
                        <form action="/update_serverr" method="GET" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                            <div class="form-group">
                                <label>Server Name</label>
                                <input name="server_name" class="form-control" value="{{$data->server_name}}">
                                {{-- id kapal --}}
                                <input type="hidden" name="id" class="form-control" value="{{$data->id}}">
                                {{-- id kapal --}}
                                <div class="text-danger">
                                    @error('server_name')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>FTP Username</label>
                                <input name="ftp_uname" class="form-control" value="{{$data->ftp_uname}}" readonly>
                                <div class="text-danger">
                                    @error('ftp_uname')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>FTP Password</label>
                                <input type= "password" name="ftp_password" class="form-control" value="{{$data->ftp_password}}"readonly>
                                <div class="text-danger">
                                    @error('ftp_password')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>FTP Password Confirmation</label>
                                <input type= "password" name="ftp_password_confirm" class="form-control" value="{{$data->ftp_password_confirm}}"readonly>
                                <div class="text-danger">
                                    @error('ftp_password_confirm')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>IP Address</label>
                                <input name="ip_address" placeholder="xxx.xxx.xxx.xxx" id="ip_address" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$" class="form-control" value="{{$data->ip_address}}">
                                <div class="text-danger">
                                    @error('ip_address')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>URL Domain</label>
                                <input name="url_domain" name="url_domain" class="form-control" value="{{$data->url_domain}}">
                                <div class="text-danger">
                                    @error('url_domain')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Note</label>
                                <input name="note" name="note" class="form-control" value="{{$data->note}}">
                                <div class="text-danger">
                                    @error('note')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Update Data</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @endforeach
                @foreach ($server as $data)
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
                          <a href="/delete_server/{{ $data->id}}" class="btn btn-success pull-left">Yes</a>
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
    <script>
      document.querySelector('.sweet-3').onclick = function(){
        swal("Adding User Complete!", "You clicked the button!", "success");
      };
    </script>
    <script>
        $(".reveal").on('click',function() {
            var $pwd = $(".pwd");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });
    </script>
@endsection
