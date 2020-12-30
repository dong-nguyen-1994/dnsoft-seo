<?php

namespace Module\Seo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Module\Seo\Models\PreRedirect
 *
 * @property int $id
 * @property string $from_path
 * @property string $to_url
 * @property int|null $status_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect whereFromPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect whereToUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\PreRedirect whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PreRedirect extends Model
{
    protected $table = 'seo__pre_redirects';

    protected $fillable = [
        'from_path',
        'to_url',
        'status_code',
    ];

    protected $casts = [
        'status_code' => 'int',
    ];

    public function getStatusCodeAttribute($value)
    {
        return $value ?: 302;
    }
}
