<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $nit
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property string|null $mailchimp_id
 * @property int $type
 * @property int|null $user_id
 * @property int|null $crm_font_id
 * @property int|null $crm_mean_id
 * @property int|null $location_city_id
 * @property int|null $crm_status_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClientAction> $actions
 * @property-read int|null $actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nnjeim\World\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClientContact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deal> $deals
 * @property-read int|null $deals_count
 * @property-read \App\Models\CrmFont|null $font
 * @property-read string $status_name
 * @property-read \App\Models\CrmMean|null $mean
 * @property-read \App\Models\CrmPipelineStage|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCrmFontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCrmMeanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCrmPipelineStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLocationCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereMailchimpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Client withoutTrashed()
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property int $crm_action_id
 * @property int $crm_pipeline_stage_id
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CrmAction $action
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\CrmPipelineStage $state
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ClientActionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereCrmActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereCrmPipelineStageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientAction withoutTrashed()
 */
	class ClientAction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $mailchimp_id
 * @property string|null $charge
 * @property string|null $phone
 * @property int|null $client_id
 * @property int|null $crm_font_id
 * @property int|null $crm_mean_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\CrmFont|null $font
 * @property-read \App\Models\CrmMean|null $mean
 * @method static \Database\Factories\ClientContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereCrmFontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereCrmMeanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereMailchimpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientContact withoutTrashed()
 */
	class ClientContact extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $client_id
 * @property int|null $tag_id
 * @property int $registered_on_mailchimp
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Tag|null $tag
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTag whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTag whereRegisteredOnMailchimp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTag whereTagId($value)
 */
	class ClientTag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrmAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmAction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmAction whereUpdatedAt($value)
 */
	class CrmAction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereUpdatedAt($value)
 */
	class CrmPipelineStage extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrmFont newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmFont newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmFont query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmFont whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmFont whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmFont whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmFont whereUpdatedAt($value)
 */
	class CrmFont extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrmMean newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmMean newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmMean query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmMean whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmMean whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmMean whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmMean whereUpdatedAt($value)
 */
	class CrmMean extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrmPipelineStage whereUpdatedAt($value)
 */
	class CrmPipelineStage extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $client_name
 * @property \Illuminate\Support\Carbon|null $date
 * @property string|null $total
 * @property int|null $client_id
 * @property int|null $client_contact_id
 * @property int|null $owner_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\ClientContact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DealDetail> $details
 * @property-read int|null $details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\DealFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Deal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereClientContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal withoutTrashed()
 */
	class Deal extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $deal_id
 * @property int $client_id
 * @property int|null $product_id
 * @property int $quantity
 * @property string $price
 * @property string $total
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Deal $deal
 * @property-read \App\Models\Product|null $product
 * @method static \Database\Factories\DealDetailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereDealId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DealDetail withoutTrashed()
 */
	class DealDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $mailchimp_id
 * @property string $name
 * @property string $subject
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign whereMailchimpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MailchimpCampaign withoutTrashed()
 */
	class MailchimpCampaign extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $mailchimp_name
 * @property string|null $mailchimp_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereMailchimpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereMailchimpName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property int $is_admin
 * @property int $show_on_charts
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deal> $deals
 * @property-read int|null $deals_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereShowOnCharts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

