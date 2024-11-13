<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'payment_method',  // Payment method is also part of the fillable attributes
        'payment_status',  // Add payment status
    ];

    public function service()
    {
        return $this->belongsTo(Service::class); // Defines a many-to-one relationship
    }

    // You may also want to define a method to easily access if the appointment is paid
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }
}
