<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanServiceOrderSupportingDocument extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function supportingDocumentCategory()
    {
        return $this->belongsTo(SupportingDocumentCategory::class,'supporting_document_category_id','id');
    }
}
