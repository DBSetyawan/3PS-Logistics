<?php
namespace warehouse;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

/**
 * Class User interactive interface
 *
 * @package 3 permata system
 * @property string $name
 * @property string $email
 * @property string $company_branch_id [ verifikasi kode cabang ]
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;
    use HasRoles, SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'name', 
        'email',
        'remember_token', 
        'parent_id', 
        'password',
        'company_id',
        'plan',
        'company_branch_id',
        'token_register',
        'expired_at',
        'active'
     ];
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function items()
    {
        return $this->hasMany('warehouse\Models\Item', 'by_user_permission_allows');
    }
    
    public function modelsgetch()
    {
        return $this->morphMany('warehouse\Models\model_hasRoles', 'model');
    }

    public function customers()
    {
        return $this->hasMany('warehouse\Models\Customer', 'users_permissions');
    }

    public function modeltouserolebranch()
    {
        return $this->hasMany('warehouse\Models\Role_branch', 'user_id');
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'users_permissions');
    }

    public function company_branchs()
    {
    return $this->belongsTo('warehouse\Models\Company_branchs','company_branch_id');
    }

    public function company()
    {
        return $this->belongsTo('warehouse\Models\Companies','company_id');
    }

    public function warehouse_orders_foreignkeys()
    {
        return $this->hasMany('warehouse\Models\Warehouse_order','usersid');
    }

    public function address_book_foreignkeys()
    {
        return $this->hasMany('warehouse\Models\Address_book','usersid');
    }

    public function sub_services_foreignkeys()
    {
        return $this->hasMany('warehouse\Models\Sub_service','usersid');
    }

    public function order_user_history()
    {
        return $this->hasMany('warehouse\Models\Order_history','user_id');
    }

    public function transport_order_user_history()
    {
        return $this->hasMany('warehouse\Models\Order_transport_history','user_id');
    }

    public function job_shipments_order_user_history()
    {
        return $this->hasMany('warehouse\Models\Order_job_transaction_detail_history','user_id');
    }

    public function shipment_category_foreignkeys()
    {
        return $this->hasMany('warehouse\Models\Ship_category','usersid');
    }

    public function modas_foreignkeys()
    {
        return $this->hasMany('warehouse\Models\Moda','usersid');
    }

    public function item_transports_foreignkeys()
    {
        return $this->hasMany('warehouse\Models\Item_transport','usersid');
    }

    public function vendor_item_transports_foreignkeys()
    {
        return $this->hasMany('warehouse\Models\Vendor_item_transports','usersid');
    }

    private function chunk($count)
    {
        User::query()->chunk(
            $count,
            function ($users) {
                foreach ($users as $user) {
                    // return $user;
                }
            }
        );
    }

    public function getDataUser() {
        User::chunk(1000, function ($sr) {
            foreach ($sr as $srs) {
                //code...
            }
        });
    }

    private function cursor()
    {
        foreach (User::query()->cursor() as $user) {
            // return $user;
        }
    }

    public function cursorUsers() {
        foreach (User::cursor() as $s) {
            //code...
        }
    }

    /**
     * https://en.wikipedia.org/wiki/God_object | when adding these kinds of utility classes.
     * https://en.wikipedia.org/wiki/Single_responsibility_principle
     * 
     *  ex: $var = new \directory\folderfiletouse\Method();
     * Design Anti-Pattern
    */
    public static function __callStatic($metode, $vals)
    {
        return (new static)->$metode(...$vals);
    }

}