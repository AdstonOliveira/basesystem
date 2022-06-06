<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{

    use SoftDeletes;
    protected $table="customer";
    protected $fillable = ["id", "first_name", "last_name"];



    public function contacts(){
        return $this->hasMany(Contact::class, "customer_id");
    }

    public function documents(){
        return $this->hasMany(Document::class, "customer_id");
    }


    public function RetornoCriacao(){

        return self::with(["contacts", "documents"])->get();
    }

    public static function GetAll(){

        return self::with(["contacts", "documents"])->get();
    }



}
