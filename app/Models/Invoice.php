<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'invoice_no',
        'customer_name',
        'total_quantity',
        'total_amount',
        'status',
    ];

    public function invoiceDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class, '');
    }
}
