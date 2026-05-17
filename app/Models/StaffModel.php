<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class StaffModel extends Model
{
    protected $table = 'tbl_staff';

    protected $primaryKey = 'staff_id';

    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'prefix',
        'first_name',
        'last_name',
        'email_id',
        'active_status',
        'login_status',
        'user_name',
        'password',
        'access_location',
        'sales_commission',
        'sales_discount',
        'allow_contact',
        'dob',
        'gender',
        'contact_number',
        'alt_contact_number',
        'facebook_link',
        'twitter_link',
        'permanent_address',
        'current_address',
        'acc_holder_name',
        'acc_number',
        'bank_name',
        'bank_code',
        'bank_branch',
        'tax_payer_id',
        'language',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'dob' => 'date',
        'active_status' => 'boolean',
        'login_status'  => 'boolean',
        'allow_contact' => 'boolean',
        'sales_commission' => 'decimal:2',
        'sales_discount'   => 'decimal:2',
    ];


    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($staff) {

            if (empty($staff->user_name)) {

                $baseUsername = Str::slug($staff->first_name, '');
                $username = $baseUsername;
                $count = 1;

                while (self::where('user_name', $username)->exists()) {
                    $username = $baseUsername . $count;
                    $count++;
                }

                $staff->user_name = $username;
            }
        });
    }
}
