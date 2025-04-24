<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'aadhar_number',
        'annual_income',
        'message',
        'status',
        'rejection_reason',
        'tracking_id',
        'document_type',
        'document_path',
        'document_original_name',
    ];

    /**
     * Get the user that owns the form submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
