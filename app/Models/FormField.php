<?php

namespace App\Models;

use App\Enums\FormFieldType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormField extends Model
{
    protected $fillable = [
        'form_id',
        'label',
        'name',
        'type',
        'is_required',
        'options',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'type' => FormFieldType::class,
            'is_required' => 'boolean',
            'options' => 'array',
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(ApprovalRequestValue::class);
    }
}
