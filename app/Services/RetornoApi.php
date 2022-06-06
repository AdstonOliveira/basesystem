<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class RetornoApi
{

    public static function paginate(Request $request, $items, $options=[])
    {
        $urlData = $request->except("per_page", "page");
        $path = $request->url()."?";

        if(count($urlData) > 0){
            $i = 1;
            foreach($urlData as $key => $input){

                $path.= $key."=".$input;
                if($i < count($urlData)){
                    $path.="&";
                }

                $i++;
            }
        }
        if($request->has("per_page")){
            $perPage = $request->input("per_page");
            $path .= "&per_page=".$request->input("per_page");
        }else{
            $perPage = 5;
            $path .= "&per_page=$perPage";
        }

        $page = $request->input("page") ?? 1;


        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, compact('path'), $options);
    }
}
