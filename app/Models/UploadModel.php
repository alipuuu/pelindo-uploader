<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UploadModel extends Model
{
    public function allData()
    {
       return DB::table('upload')->get();
    }

    public function addData($data)
    {
        DB::table('upload')->insert($data);
    }

    public function editData($id , $data)
    {
        DB::table('upload')
            ->where('id',$id)
            ->update($data);
    }

    public function deleteData($id)
    {
        DB::table('upload')
            ->where('id',$id)
            ->delete();
    }
        protected $table = 'upload';
        protected $guarded = [];
        protected $fillable = [
        'ticket_number','server_name','zipfile','tanggal_input','tgl','bulan','tahun'
    ];
}
