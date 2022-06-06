<?php

namespace App\Models\Customer;

use App\Models\Base\BaseModel;
use App\Services\RetornoApi;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{

    public function __construct(){

    }

    protected $table = "customer";
    protected $fillable = ["id", "first_name", "last_name"];
    const RelationToReturn = ["contacts", "documents"];
    protected $hidden = ["deleted_at", "updated_at"];

    public static function Store(Request $request){
        $data = $request->all();
        DB::beginTransaction();

        try{
            $customer = new Customer();
                $customer->first_name = $request->get("first_name");
                $customer->last_name = $request->get("last_name");

            $customer->save();

            $documents = $data["documents"];

            foreach($documents as $key => $document){
                try{
                    $doc = new Document($document);
                    $doc->customer_id = $customer->id;
                    $doc->save();

                }catch(Exception $e){
                    DB::rollBack();
                    return RetornoApi::RetonaErroCriacao($e->getMessage());
                }

            }

            $contacts = $data["contacts"];

            foreach($contacts as $key => $contact){
                try{
                    $contact = new Contact($contact);
                    $contact->customer_id = $customer->id;
                    $contact->save();
                }catch(Exception $e){
                    DB::rollBack();

                    return RetornoApi::RetonaErroCriacao($e->getMessage());
                }
            }

            DB::commit();
            return RetornoApi::RetonaSucessoCriacao($customer->RetornoCriacao());

        }catch(Exception $e){
            DB::rollBack();
            return RetornoApi::RetonaErroCriacao($e->getMessage());
        }
    }

    public function contacts(){
        return $this->hasMany(Contact::class, "customer_id");
    }

    public function documents(){
        return $this->hasMany(Document::class, "customer_id");
    }


    public function RetornoCriacao(){

        return $this->with(["contacts", "documents"])->get();
    }

    public static function GetAllWithRelations(){
        return self::with(
            self::RelationToReturn
        )->get();
    }

    public static function GetAllWithOutRelations(){

        return self::get();
    }

    protected function GetAll($rel = []){
        return self::with(
            $rel
        )->get();
    }

}
