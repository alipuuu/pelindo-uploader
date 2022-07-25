<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServerModel extends Model
{
    use HasFactory;

    // Model cukup di definisikan table tujuan, primary key, dan column yang bisa diisi ..
    // untuk query bisa langsung memakai query builder
    protected $table = "server";
    protected $primaryKey = "id"; // -> primary keynya apa ?
    protected $fillable =['server_name','ftp_uname','ftp_password','ftp_password_confirm','ip_address','url_domain','note','status'];

    public function allData()
    {
       return DB::table('server')->get();
    }

    public function addData($data)
    {
        DB::table('server')->insert($data);
    }

    public function editData($id , $data)
    {
        DB::table('server')
            ->where('id',$id)
            ->update($data);
    }

    public function deleteData($id)
    {
        DB::table('server')
            ->where('id',$id)
            ->delete();
    }
}
