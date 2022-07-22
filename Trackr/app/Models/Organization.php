<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'leader_id', 'organization_name'
    ];

    /**
     * Cesar: This function establishes the relationship that
     * each organization has one owner 
     */
    public function owner(){
        return $this->hasOne(User::class, 'id', 'leader_id');
    }

    /**
     * Cesar: This function establishes the relationship that
     * each organization has many members 
     * NOTE:Not users but organization_member model
     */
    public function members(){
        return $this->hasMany(Organization_Member::class, 'organization_id', 'organization_id');
    }

    public function activeMembers(){
        return $this->hasMany(Organization_Member::class, 
        'organization_id', 'organization_id')->where('invitation_status', 'accepted');
    }

    public function networks(){
        return $this->hasMany(Organization_Network::class, 'organization_id', 'organization_id');
    }

    /**
     * Cesar: 
     * This proprty is needed to use the find() query 
     * with just an integer.
     */
    protected $primaryKey = 'organization_id';
}
