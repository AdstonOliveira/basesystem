<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $table = "document";
    protected $fillable = ["id", "type_id", "customer_id", "number"];
    protected $hidden = ["deleted_at", "updated_at"];
}
