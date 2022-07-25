<?php

namespace App\Http\Controllers;

use App\Models\UploadModel;
use App\Models\ServerModel ;
use Illuminate\Http\Request;
use ZanySoft\Zip\Zip;
use Dompdf\Dompdf;
use Illuminate\Support\Carbon;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->UploadModel = new UploadModel();
        $this->middleware('auth');
    }

    public function index()
    {
        $upload = UploadModel::all();
        $server = ServerModel::all();
        $userRole = UploadModel::count();
        $getserver = ServerModel::where('status','1')->get();
        return view('v_upload', compact('server','getserver','upload'));
    }

    public function add()
    {
        $upload = UploadModel::all();
        return view('v_upload', compact('upload'));
    }

    public function insert(Request $request)
    {
        // $upload = UploadModel::find($request->id);
        // $server = ServerModel::all();
        $request->validate([
            'server_id' => 'required',
            'ticket_number' => 'required',
            'zipfile' => 'required',
            'tanggal_input' => 'required',
        ],[
            'ticket_number.required'=>' ticket number wajib diisi !!',
            'server_name.required'=>' server name wajib diisi !!',
            'zipfile.required' => 'zip file wajib diisi !!',
            'tanggal_input.required' => 'tanggal input wajib diisi !!',
        ]);

        $file = $request->file('zipfile');
        // $file->move('myfile',$file->getClientOriginalName());
        $server = ServerModel::where('id', $request->server_id)->first();
        $upload = [
            'server_id' => $request->server_id,
            'ticket_number' => $request->ticket_number,
            'server_name' => $server->server_name,
            'zipfile' => $file->getClientOriginalName(),
        ];
        if($request->hasFile('zipfile')) {
            //get filename with extension
            $filenamewithextension = $request->file('zipfile')->getClientOriginalName();
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //get file extension
            $extension = $request->file('zipfile')->getClientOriginalExtension();
            //filename to store
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;
            $namae = $filenametostore;
            //$filenametostore = $filename.'.'.$extension;
            //UploadModel File to external server
            //Storage::disk('ftp')->put($filenametostore, fopen($request->file('myfile'), 'r+'));
            //Store $filenametostore in the database
            $file->move(''.$namae.'',$file->getClientOriginalName());
            $zip = Zip::open(''.$namae.'/'.$filenamewithextension.'');
            //dump($zip);
            $zip->extract(''.$namae.'/extract/');
            error_reporting(E_ERROR | E_PARSE);
            echo 'Connecting to FTP...<br>';
            //Define vars
            //select server_name, ftp_uname, ftp_password, ip_address from server where server_name = "PEO(berdasarkan server yg dipilih ketika upload)"
            // $ftp_server = DB::table('server')->get(); // it will get the entire table
            // $ftp_user_name = DB::table('server')->get();
            // $ftp_password = DB::table('server')->get();
            // $server = DB::table('server')->where('id', $request->server_id)->first();
            $ip_server = $server->ip_address;
            $username = $server->ftp_uname;
            $password = $server->ftp_password;
            // dd($ip_server);
            // $server = DB::table('server')->where('ftp_server', 'ftp_user_name','ftp_password')->get(); // it will get the entire table
            // $ftp_server= '10.1.237.191';
            // $ftp_user_name = 'alipoe';
            // $ftp_password = 'pelindo';
            $conn_id = ftp_connect($ip_server);
            $login_result = ftp_login($conn_id, $username, $password);
            $remoteDir = "/"; // As /home/user/ftp/ WITH the last slash!!
            $dir = ''.$namae.'/extract'; // As folder/download WITHOUT the last slash!!
            if ((!$conn_id) || (!$login_result)) {
                echo 'FTP connection has failed! Attempted to connect to '. $ip_server. ' for user '.$username.'.<br>';
            } else{
                echo 'FTP connection was a success.<br>';
            }
            // check connection
            // if ((!$conn_id) || (!$login_result)) {
                // echo 'FTP connection has failed! Attempted to connect to '. $ip_server. ' for user '.$username.'.<br>';
            // } else{
                // echo 'FTP connection was a success.<br>';
            // }

            function make_directory($ftp_stream, $dir){ //Create FTP directory if not exists
                // if directory already exists or can be immediately created return true
                if (ftp_chdir ($ftp_stream, $dir) || @ftp_mkdir($ftp_stream, $dir)) return true;
                // otherwise recursively try to make the directory
                if (!make_directory($ftp_stream, dirname($dir))) return false;
                // final step to create the directory
                return ftp_mkdir($ftp_stream, $dir);
            }

            ftp_pasv($conn_id, true); // Set Passive mode
            //$recursiveFileResearch = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)); // Get all files in folder and subfolder in the selected directory
            $files = array();
                foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir)) as $file) {
                //echo $filename."<br>";
                    if ($file->isDir()){
                        continue;
                    }
                    $files[] = str_replace($dir . "/", "", str_replace('\\', '/', $file->getPathname())); // Store the file without backslashes (Windows..) and without the root directory
                }

            if (count($files) > 0) {
                foreach ($files as $file) {
                    make_directory($conn_id, $remoteDir . dirname($file)); // Create directory if not exists
                    ftp_chdir ($conn_id, $remoteDir . dirname($file)); // Go to that FTP directory
                    echo "Current directory : " . ftp_pwd($conn_id) . " for file : " . basename($file)
                        . " that could be found locally : " . $dir . "/" . $file . "<br>\n"; // Some logs to chekc the process
                    ftp_put($conn_id, basename($file), $dir . "/"  . $file, FTP_BINARY); //UploadModel the file to current FTP directory
                    echo "Uploaded " . basename($file) . "<br>\n"; // Some logs to chekc the process
                }
            } else {
                echo "Didn't found any folder/files to send in directory : " . $dir . "<br>\n";
            }

            ftp_close($conn_id); // Close FTP Connection
        }
        $this->UploadModel->addData($upload);
        return redirect()->route('upload',compact('server'));
        return view('v_upload', compact('upload'));
    }

    public function update_upload(Request $request)
    {
        $upload= UploadModel::find($request->id);
        $upload->update($request->all());
        return redirect()->route('upload')->with('pesan','data berhasil di update!!!');
    }

    public function delete_upload($id)
    {
        $upload = UploadModel::find($id);
        $upload->delete();
        return redirect()->route('upload');
    }

        public function cetakForm()
    {
        return view('v_upload');
    }

    public function cetak_tanggal_upload()
    {
        if (request()->start_date || request()->end_date) {
        $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
        $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
        $upload = UploadModel::whereBetween('tanggal_input',[$start_date,$end_date])->get();
    } else {
        $upload = UploadModel::latest()->get();
    }
    $getserver = ServerModel::where('status','1')->get();
    // dd($getserver);
    return view('v_upload', compact('upload','getserver'));
    }

}
