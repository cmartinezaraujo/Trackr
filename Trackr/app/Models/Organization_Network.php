<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization_Network extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Organization_Networks';

    protected $fillable = [
        'organization_id', 'creator_id', 'network_name'
];

public function organization(){
    return $this->hasOne(Organization::class, 'organization_id', 'organization_id');
}

public function admin(){
    return $this->hasOne(User::class, 'id', 'creator_id');
}


public function members(){
    return $this->hasMany(Network_Member::class, 'network_id', 'network_id');
}

protected $primaryKey = 'network_id';
}
