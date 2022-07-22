<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id', 'addressee_id', 'contact_status'
    ];

    protected $primaryKey = 'contact_id';

    //public function getUserRelation(){
    //    return $this->belongsTo(User::class, 'requester_id', 'id');
    //}
}
