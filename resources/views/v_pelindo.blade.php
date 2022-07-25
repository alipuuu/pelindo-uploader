@extends('layout.v_template')
@section('content')
<section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">PELINDO</h3>
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
                <a href="/printer" target="_blank" class="btn btn-sm bg-maroon">Print To Printer</a>
                <a href="/printpdf" target="_blank" class="btn btn-sm bg-navy">Print To PDF</a>
                </div>
            <div class="box-body">
            <table id="example2" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th class="text-center">No Service Now</th>
                <th class="text-center">Nama Aplikasi</th>
                <th class="text-center">Date</th>
                <th class="text-center">Pilih Server</th>
                <th class="text-center">Upload Zip</th>
                <th class="text-center">Created At</th>
                <th class="text-center">Updated At</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($pelindo as $data)
                    <tr>
                        <td class="text-center">{{ $data->no_servicenow}}</td>
                        <td class="text-center">{{ $data->nama_aplikasi}}</td>
                        <td class="text-center">{{ $data->date}}</td>
                        <td class="text-center">{{ $data->pilih_server}}</td>
                        {{-- <td class="text-center"><a href="{{env('http://10.1.234.95:8000')}}/ " target="_blank">{{ $data->myfile}}</a></td> --}}
                        <td class="text-center">{{ $data->myfile}}</td>
                        <td class="text-center">{{ $data->created_at}}</td>
                        <td class="text-center">{{ $data->updated_at}}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#detail{{ $data->id}}">Non-Aktifkan</a>
                        </td>
                    </tr>
                </div>
                @endforeach
                <div class="modal fade" id="tambah">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">TAMBAH DATA</h5>
                        </div>
                        <form action="/insert/" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>No Service Now</label>
                                <input name="no_servicenow" id="no_servicenow" class="form-control" value="{{old('no_servicenow')}}">
                                <div class="text-danger">
                                    @error('no_servicenow')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama Aplikasi</label>
                                <input name="nama_aplikasi" id="nama_aplikasi" class="form-control" value="{{old('nama_aplikasi')}}">
                                <div class="text-danger">
                                    @error('nama_aplikasi')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input name="date" type="date" id="date" class="form-control" value="{{old('date')}}">
                                <div class="text-danger">
                                    @error('date')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>Pilih Server</label>
                                <input name="pilih_server" id="pilih_server" class="form-control" value="{{old('pilih_server')}}">
                                <div class="text-danger">
                                    @error('pilih_server')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>Upload Zip</label>
                                <input type="file" accept=".zip" name="myfile" id="myfile" class="form-control" value="{{old('myfile')}}">
                                <div class="text-danger">
                                    @error('myfile')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Save Data</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>

                @foreach ($pelindo as $data)
                  <div class="modal modal-success fade" id="detail{{ $data->id}}">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Detail Data {{ $data->id}}</h4>
                        </div>
                          <div class="modal-body">
                           <p>No Service Now : {{ $data->no_servicenow }}</p>
                           <p>Nama Aplikasi : {{ $data->nama_aplikasi }}</p>
                           <p>Tanggal : {{ $data->date}}</p>
                           <p>Pilih Server : {{ $data->pilih_server}}</p>
                           <p>Upload Zip : {{ $data->myfile}}</p>
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

@endsection
