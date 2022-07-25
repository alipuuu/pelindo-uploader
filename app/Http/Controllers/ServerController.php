<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerModel;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;



class ServerController extends Controller
{
     public function __construct()
    {
        $this->ServerModel = new ServerModel();
        $this->middleware('auth');
    }

    public function index()
    {
        $userRole = ServerModel::get()->count();
        $server = ServerModel::all();
        return view('v_server', compact('server'));
    }

    public function add_server()
    {
        $server = ServerModel::all();
        return view('v_server', compact('server'));
    }

    public function insert(Request $request)
    {
        $server = ServerModel::find($request->id);
        Request()->validate([
            'server_name' => 'required',
            'ftp_uname' => 'required',
            'ftp_password' => 'min:5|required_with:ftp_password_confirm|same:ftp_password_confirm',
            'ftp_password_confirm' => 'min:5',
            'ip_address' => 'required',
            'url_domain' => 'required',
            'note' => 'required',
            'status' => 'required',
        ],[
            'server_name.required'=>' server name wajib diisi !!',
            'ftp_uname.required'=>' ftp uname aplikasi wajib diisi !!',
            'ftp_password.required' => 'ftp password wajib diisi !!',
            'ftp_password_confirm.required' => 'ftp password confirm wajib diisi !!',
            'ip_address.required' => 'ip address wajib diisi !!',
            'url_domain.required' => 'url domain wajib diisi !!',
            'note.required' => 'note wajib diisi !!',
            'status.required' => 'status wajib diisi !!',
        ]);

        $server = [
            'server_name' => Request()->server_name,
            'ftp_uname' => Request()->ftp_uname,
            'ftp_password' => Request()->ftp_password,
            'ftp_password_confirm' => Request()->ftp_password_confirm,
            'ip_address' => Request()->ip_address,
            'url_domain' => Request()->url_domain,
            'note' => Request()->note,
            'status' => Request()->status,
        ];
        $this->ServerModel->addData($server);
        return redirect()->route('server')->with('pesan', 'Data berhasil ditambahkan!');
    }
    function status_update($id)
    {
        //get product status with the help of product ID
        $server = ServerModel::select('status')->where('id','=',$id)->first();

        //Check user status
        if($server->status == '1'){
            $status = '0';
        }else{
            $status = '1';
        }

        //update product status
        $values = array('status' => $status );
        ServerModel::where('id',$id)->update($values);

        return redirect()->route('server')->with('pesan', 'Data berhasil ditambahkan!');
    }

    public function update_serverr(Request $request)
    {
        $server = ServerModel::find($request->id);
        $server->update($request->all());
        // dd($server);
        return redirect()->route('server')->with('pesan','data berhasil di update!!!');
    }

    public function delete_server($id)
    {
        $server = ServerModel::find($id);
        $server->delete();
        return redirect()->route('server');
    }
}



