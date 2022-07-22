<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization_Member extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Organization_Members';

    protected $fillable = [
            'organization_id', 'member_id', 'role', 'invitation_status'
    ];

    /**
     * Cesar: This function establishes the relationship that
     * each organization_member is one user 
     */
    public function user(){
        return $this->hasOne(User::class, 'id', 'member_id');
    }

    /**
     * Cesar: This function establishes the relationship that
     * each organization_member invitation belongs to one Organization
     */
    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'organization_id');
    }

}
