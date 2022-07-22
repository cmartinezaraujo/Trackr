<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'reported',
        'notes', 'has_attachment', 
        'is_anonymous', 'created_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * This proprty is needed to use the find() query 
     * with just an integer.
     */
    protected $primaryKey = 'report_id';
}
