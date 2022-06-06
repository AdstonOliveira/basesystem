<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;
    // protected $table;
    protected $fillable;

    protected static function GetAll($rel = []){
        return self::with(
            $rel
        )->get();
    }

}
