<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanServiceOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function planServiceCategory()
    {
        return $this->belongsTo(PlanServiceCategory::class);
    }

    public function planServiceOrder()
    {
        return $this->belongsTo(PlanServiceOrder::class,'existing_plan_service_order_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function planServiceOrderSupportingDocuments()
    {
        return $this->hasMany(PlanServiceOrderSupportingDocument::class)
            ->with('supportingDocumentCategory');
    }
}
