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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\AdminFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
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
 * @property string $user_id
 * @property \BenSampo\Enum\Enum|null $bookable_type
 * @property string $bookable_id
 * @property \BenSampo\Enum\Enum|null $payment_type
 * @property float $net_price
 * @property float $total_price
 * @property int $commission
 * @property int $has_caution
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $bookable
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BookingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereHasCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereNetPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUserId($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Core
 *
 * @property string $id
 * @property int $commission
 * @property string $commission_updated_by
 * @property int $KM
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Core newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Core newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Core query()
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereCommissionUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereKM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Core whereUpdatedAt($value)
 */
	class Core extends \Eloquent {}
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
 * @property-read string|null $photo
 * @property-read string|null $photo_thumb
 * @property-read array $photos
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
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
 * App\Models\Seller
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $phone
 * @property string|null $phone_verified_at
 * @property string|null $otp
 * @property string $password
 * @property string $firebase_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereFirebaseToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePhoneVerifiedAt($value)
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
 * @property string|null $otp
 * @property bool $can_rent_house
 * @property bool $can_rent_vehicle
 * @property string|null $coordinates
 * @property \Illuminate\Support\Carbon|null $validated_at
 * @property string|null $validated_by
 * @property string $firebase_token
 * @property string $password
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirebaseToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleDocument> $documents
 * @property-read int|null $documents_count
 * @property-read string|null $photo
 * @property-read string|null $photo_thumb
 * @property-read array $photos
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
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

