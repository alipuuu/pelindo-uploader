<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserrModel extends Model
{
    public function allData()
    {
       return DB::table('users')->get();
    }

    public function editData($id , $data)
    {
        DB::table('users')
            ->where('id',$id)
            ->update($data);
    }

    public function addData($data)
    {
        DB::table('users')->insert($data);
    }
        protected $table = 'users';
        protected $guarded = [];
        protected $fillable = [
        'name','email','password','password_confirmation'];
        protected $primaryKey = 'id';
}
