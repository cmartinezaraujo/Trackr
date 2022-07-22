<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network_Member extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Network_Members';

    protected $fillable = [
        'network_id', 'member_id', 'created_at'
];

public function user(){
    return $this->hasOne(User::class, 'id', 'member_id');
}

}
