<?php

namespace App\Models\Customer;

use App\Models\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends BaseModel
{

    public function __construct(){
    }

    use SoftDeletes;
    protected $table="customer";
    protected $fillable = ["id", "first_name", "last_name"];

    const RelationToReturn = ["contacts", "documents"];


    public function contacts(){
        return $this->hasMany(Contact::class, "customer_id");
    }

    public function documents(){
        return $this->hasMany(Document::class, "customer_id");
    }


    public function RetornoCriacao(){

        return self::with(["contacts", "documents"])->get();
    }

    public static function GetAllWithRelations(){

        return self::GetAll(self::RelationToReturn);
    }

    public static function GetAllWithOutRelations(){

        return self::GetAll();
    }



}
