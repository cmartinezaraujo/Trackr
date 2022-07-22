<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'middle_name',
        'email',
        'password', 'status', 'vaccinated', 'last_login', 'account_type'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** 
     * Cesar: This function is used to create the pivot relationship to contacts requested 
     * by the current user
    */
    public function contactsOfMine(){

        return $this->belongsToMany(User::class, 'contacts','requester_id', 'addressee_id')->where('contact_status', 'accepted');
    }

    /** 
     * Cesar: This function is used to create the pivot relationship to contacts addressed 
     * by the current user
    */
    public function contactsOf(){
        return $this->belongsToMany(User::class, 'contacts', 'addressee_id', 'requester_id')->where('contact_status', 'accepted');
    }

    /** 
     * Cesar: This function is used to create the pivot relationship to contacts requested 
     * by the current user that are PENDING
    */
    public function pendingContactsOfMine(){

        return $this->belongsToMany(User::class, 'contacts','requester_id', 'addressee_id')->where('contact_status', 'pending');
    }

    /** 
     * Cesar: This function is used to create the pivot relationship to contacts addressed 
     * by the current user that are PENDING
    */
    public function pendingContactsOf(){
        return $this->belongsToMany(User::class, 'contacts', 'addressee_id', 'requester_id')->where('contact_status', 'pending');
    }


    /** 
     * Cesar: This function merges the two seperate queries 
     * NOTE: Once the user login is set up we can potentially merge the functions into one
    */
    public function contacts(){
        return $this->contactsOfMine()->wherePivot('status', 'pending')->get()->merge($this->contactsOf()->wherePivot('status', 'pending')->get());
    }
    
    /** 
     * Cesar: This function is used to retrieve all the cases associated with the user
    */
    public function cases(){
        return $this->hasMany(Report::class, 'user_id', 'id');
    }

    /**
     * Cesar: This establishes the relationship between the user and
     * the many organizations they may be a part of.
     */
    public function organizations(){
        return $this->hasManyThrough(Organization::class, Organization_Member::class, 'member_id', 'organization_id', 'id','organization_id')->where('invitation_status', 'accepted');
    }

    public function networksMemberships(){
        return $this->hasMany(Network_Member::class, 'member_id', 'id');
    }

    public function networks(){
        return $this->hasManyThrough(Organization_Network::class, Network_Member::class, 'member_id', 'network_id', 'id','network_id');
    }

    public function pendingOrganizations(){
        return $this->hasMany(Organization_Member::class, 'member_id', 'id')->where('invitation_status', 'pending');
    }


    /**
     * Cesar: This establishes the relationship to the one organization
     * that can be owned by a user if they are an orgnaizaiton account
     */
    public function organizationOwner(){

        return $this->belongsTo(Organization::class, 'id', 'leader_id');
    }

   
}
