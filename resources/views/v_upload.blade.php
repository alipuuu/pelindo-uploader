@extends('layout.v_template')
@section('title', 'Data Upload')
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

            <h3 class="box-title">Data Upload</h3>
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
                <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#report">Range Tanggal</a>
                </div>
            <div class="box-body">
            <table id="table-datatables" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th class="text-center">Ticket Number</th>
                <th class="text-center">Server Name</th>
                <th class="text-center">Zip File</th>
                <th class="text-center">Created At</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($upload as $data)
                    <tr>
                        <td class="text-center">{{$data->ticket_number}}</td>
                        <td class="text-center">{{$data->server_name}}</td>
                        {{-- <td class="text-center"><a target="_blank" href="http://192.168.10.3/{{$data->server_name}}">{{$data->zipfile}}</a></td> --}}
                        <td class="text-center">{{$data->zipfile}}</td>
                        <td class="text-center">{{$data->created_at}}</td>
                        <td class="text-center"><a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $data->id}}">Delete</a></td>
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
                        <form action="/insert_upload/" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Ticket Number</label>
                                <input name="ticket_number" id="ticket_number" class="form-control" value="{{old('ticket_number')}}">
                                <div class="text-danger">
                                    @error('ticket_number')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Server</label>
                                 <select name="server_id" class="form-control">
                                   @foreach ($getserver as $data )
                                    <option value="{{ $data->id }}">{{ $data->server_name}}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="form-group" >
                                <label>Zip File</label>
                                <input type="file" accept=".zip" name="zipfile" id="myfile" class="form-control" value="{{old('zipfile')}}">
                                <div class="text-danger">
                                    @error('zipfile')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Input</label>
                                <input name="tanggal_input" id="tanggal_input" class="form-control" value="{{date('Y-m-d')}}" readonly>
                                <div class="text-danger">
                                    @error('tanggal_input')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <label>Tanggal</label> --}}
                                <input type="hidden" name="tgl" id="tgl" class="form-control" value="{{date('d')}}" readonly>
                                <div class="text-danger">
                                    @error('tgl')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <label>Bulan</label> --}}
                                <input type="hidden" name="bulan" id="bulan" class="form-control" value="{{date('m')}}" readonly>
                                <div class="text-danger">
                                    @error('bulan')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <label>Tahun</label> --}}
                                <input type="hidden" name="tahun" id="tahun" class="form-control" value="{{date('Y')}}" readonly>
                                <div class="text-danger">
                                    @error('tahun')
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
                 @foreach ($upload as $data)
                  <div class="modal modal-warning fade" id="update{{ $data->id}}">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h5 class="modal-title">UPDATE DATA {{ $data->id}}</h5>
                        </div>
                        <form action="/update_upload" method="GET" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                            <div class="form-group">
                                <label>Ticket Number</label>
                                <input name="ticket_number" class="form-control" value="{{$data->ticket_number}}">
                                {{-- id kapal --}}
                                <input type="hidden" name="id" class="form-control" value="{{$data->id}}">
                                {{-- id kapal --}}
                                <div class="text-danger">
                                    @error('ticket_number')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Server</label>
                                <input name="server_name" class="form-control" value="{{$data->server_name}}" readonly>
                                <div class="text-danger">
                                    @error('server_name')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>Zip File</label>
                                <input type="file" accept=".zip" name="zipfile" id="myfile" class="form-control" value="{{old('zipfile')}}">
                                <div class="text-danger">
                                    @error('zipfile')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Input</label>
                                <input name="tanggal_input" id="tanggal_input" class="form-control" value="{{date('Y-m-d')}}" readonly>
                                <div class="text-danger">
                                    @error('tanggal_input')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <label>Tanggal</label> --}}
                                <input type="hidden" name="tgl" id="tgl" class="form-control" value="{{date('d')}}" readonly>
                                <div class="text-danger">
                                    @error('tgl')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <label>Bulan</label> --}}
                                <input type="hidden" name="bulan" id="bulan" class="form-control" value="{{date('m')}}" readonly>
                                <div class="text-danger">
                                    @error('bulan')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                {{-- <label>Tahun</label> --}}
                                <input type="hidden" name="tahun" id="tahun" class="form-control" value="{{date('Y')}}" readonly>
                                <div class="text-danger">
                                    @error('tahun')
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
                <div class="modal modal-info fade" id="report">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">RANGE DATA UPLOAD</h5>
                        </div>
                        <form action="/cetak_tanggal_upload" method="GET">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" id="start_date" class="form-control" name="start_date">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" id="end_date" class="form-control" name="end_date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">Get Data</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
                 @foreach ($upload as $data)
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
                          <a href="/delete_upload/{{ $data->id}}" class="btn btn-success pull-left">Yes</a>
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
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
    </script>
@endsection
