<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanServiceCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function supportingDocumentItems()
    {
        return $this->hasMany(PlanServiceCategorySupportingDocumentItem::class);
    }
    public function planServiceOrders()
    {
        return $this->hasMany(PlanServiceOrder::class);
    }
}
