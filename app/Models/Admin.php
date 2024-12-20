<?php

namespace App\Models;

use App\Exceptions\PaymentException;
use App\Traits\UUID;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, UUID, HasRoles;


    protected static function booted()
    {
        static::creating(function (self $model) {
            $model->username = "{$model->full_name}.".rand(1, 100);
        });

        static::deleting(function (self $model) {
            $model->commission()->update((['commission_updated_by' => null]));
            $model->users()->update(['validated_by' => null]);
        });
    }


    /**
     * fillable attributes
     */
    protected $fillable = [
        'id',
        'full_name',
        'username',
        'email',
        'password',
    ];


    /**
     * hidden attributes
     */
    protected $hidden = [
        'password',
    ];


    /**
     * cast attributes
     */
    protected $casts = [];

    /**
     * relationships
     */

    public function commission(): HasOne
    {
        return $this->hasOne(Core::class, 'commission_updated_by', 'id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'validated_by', 'id');
    }


    /**
     * functions
     */

    public function satimRefund(Booking $booking, float $amount): void
    {
        $satimApi = config('app.satim_api');
        $response = Http::get("${satimApi}/refund.do", [
            'userName' => config('app.satim_username'),
            'password' => config('app.satim_password'),
            'orderId' => $booking->satim_order_id,
            'amount' => $amount,
        ]);

        if ($response->json()['errorCode'] != '0') {
            throw new PaymentException($response->json()['errorMessage']);
        }
    }
}
