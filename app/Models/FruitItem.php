<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\ItemUnit;

class FruitItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'category_id',
        'unit',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'unit' => ItemUnit::class,
        ];
    }

    public function fruitCategory(): BelongsTo
    {
        return $this->belongsTo(FruitCategory::class, 'category_id');
    }
}
