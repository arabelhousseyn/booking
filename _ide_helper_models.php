<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Ad
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $photos
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUpdatedAt($value)
 */
	class Ad extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property string $id
 * @property string $full_name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Core|null $commission
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\AdminFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUsername($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Booking
 *
 * @property string $id
 * @property string $reference
 * @property string $user_id
 * @property string $seller_id
 * @property string|null $satim_order_id
 * @property string|null $payment_intent_id
 * @property \BenSampo\Enum\Enum|null $bookable_type
 * @property string $bookable_id
 * @property \BenSampo\Enum\Enum|null $payment_type
 * @property float $original_price
 * @property float $calculated_price
 * @property int $commission
 * @property float $caution
 * @property float|null $refund
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string|null $coupon_code
 * @property string|null $note
 * @property \BenSampo\Enum\Enum|null $status
 * @property \BenSampo\Enum\Enum|null $payment_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $bookable
 * @property-read mixed $end_photos
 * @property-read mixed $feedback_photos
 * @property-read mixed $start_photos
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Seller $seller
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCalculatedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentIntentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSatimOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUserId($value)
 */
	class Booking extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Core
 *
 * @property string $id
 * @property int $commission
 * @property string|null $commission_updated_by
 * @property int $KM
 * @property string $vehicle_dahabia_caution
 * @property string $vehicle_debit_card_caution
 * @property string $house_dahabia_caution
 * @property string $house_debit_card_caution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Core newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Core newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Core query()
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereCommissionUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereHouseDahabiaCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereHouseDebitCardCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereKM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereVehicleDahabiaCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereVehicleDebitCardCaution($value)
 */
	class Core extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coupon
 *
 * @property string $id
 * @property string $code
 * @property array $description
 * @property \BenSampo\Enum\Enum|null $value_type
 * @property string $value
 * @property \BenSampo\Enum\Enum|null $type
 * @property \BenSampo\Enum\Enum|null $system_type
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $usage_limit
 * @property \BenSampo\Enum\Enum|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CouponUsage> $usages
 * @property-read int|null $usages_count
 * @method static \Database\Factories\CouponFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereSystemType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereValueType($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CouponUsage
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $coupon_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponUsage whereUserId($value)
 */
	class CouponUsage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Favorite
 *
 * @property string $id
 * @property string $user_id
 * @property \BenSampo\Enum\Enum|null $favorable_type
 * @property string $favorable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favorable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\FavoriteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavorableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUserId($value)
 */
	class Favorite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\House
 *
 * @property string $id
 * @property string $seller_id
 * @property string $title
 * @property string $description
 * @property string $coordinates
 * @property float $price
 * @property int $rooms
 * @property bool $has_wifi
 * @property bool $parking_station
 * @property \BenSampo\Enum\Enum|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read string|null $photo
 * @property-read string|null $photo_thumb
 * @property-read array $photos
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Seller $seller
 * @method static \Database\Factories\HouseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House query()
 * @method static \Illuminate\Database\Eloquent\Builder|House whereCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereHasWifi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereParkingStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereUpdatedAt($value)
 */
	class House extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Reason
 *
 * @property string $id
 * @property string $description
 * @property \BenSampo\Enum\Enum|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ReasonFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reason whereUpdatedAt($value)
 */
	class Reason extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property string $id
 * @property string $user_id
 * @property \BenSampo\Enum\Enum|null $reviewable_type
 * @property string $reviewable_id
 * @property string $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reviewable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ReviewFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Seller
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $phone
 * @property string|null $phone_verified_at
 * @property string $country_code
 * @property string|null $otp
 * @property string $password
 * @property string|null $firebase_registration_token
 * @property string|null $rib_bank_account
 * @property string|null $dahabia_account
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read string|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\House> $houses
 * @property-read int|null $houses_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vehicle> $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Database\Factories\SellerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereDahabiaAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereFirebaseRegistrationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereRibBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereUpdatedAt($value)
 */
	class Seller extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property string $country_code
 * @property string|null $otp
 * @property bool $can_rent_house
 * @property bool $can_rent_vehicle
 * @property string|null $coordinates
 * @property \Illuminate\Support\Carbon|null $validated_at
 * @property string|null $validated_by
 * @property string|null $firebase_registration_token
 * @property string|null $rib_bank_account
 * @property string|null $dahabia_account
 * @property string $password
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserDocument> $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read string|null $avatar
 * @property-read string|null $avatar_thumb
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Admin|null $validatedBy
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCanRentHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCanRentVehicle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDahabiaAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirebaseRegistrationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRibBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereValidatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereValidatedBy($value)
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\UserDocument
 *
 * @property string $id
 * @property string $user_id
 * @property \BenSampo\Enum\Enum|null $document_type
 * @property string $document_url
 * @property \BenSampo\Enum\Enum|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\UserDocumentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDocument whereUserId($value)
 */
	class UserDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vehicle
 *
 * @property string $id
 * @property string $seller_id
 * @property string $title
 * @property string $description
 * @property string $coordinates
 * @property float $price
 * @property int $places
 * @property \BenSampo\Enum\Enum|null $motorisation
 * @property \BenSampo\Enum\Enum|null $gearbox
 * @property int $is_full
 * @property array $payments_accepted
 * @property \BenSampo\Enum\Enum|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleDocument> $documents
 * @property-read int|null $documents_count
 * @property-read string|null $photo
 * @property-read string|null $photo_thumb
 * @property-read array $photos
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Seller $seller
 * @method static \Database\Factories\VehicleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereCoordinates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereGearbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereIsFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereMotorisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle wherePaymentsAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle wherePlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereUpdatedAt($value)
 */
	class Vehicle extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\VehicleDocument
 *
 * @property string $id
 * @property string $vehicle_id
 * @property \BenSampo\Enum\Enum|null $document_type
 * @property string $document_url
 * @property \Illuminate\Support\Carbon $expiry_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Vehicle $vehicle
 * @method static \Database\Factories\VehicleDocumentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument whereDocumentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleDocument whereVehicleId($value)
 */
	class VehicleDocument extends \Eloquent {}
}

