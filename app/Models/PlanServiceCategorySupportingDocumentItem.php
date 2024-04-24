<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanServiceCategorySupportingDocumentItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function supportingDocumentCategory()
    {
        return $this->belongsTo(SupportingDocumentCategory::class);
    }
}
