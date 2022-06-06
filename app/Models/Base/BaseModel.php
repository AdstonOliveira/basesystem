<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $table;
    protected $fillable;


    protected static function GetAll($rel = []){
        return self::with(
            $rel
        )->get();
    }




}
