<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Contact;
use App\Models\Customer\Customer;
use App\Models\Customer\Document;
use App\Services\RetornoApi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{

    protected $customer;
    public function __construct(Customer $costumer)
    {
        $this->customer = $costumer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $all = Customer::GetAllWithRelations();

        return RetornoApi::paginate($request, $all, []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try{
            $customer = Customer::create([
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
            ]);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
