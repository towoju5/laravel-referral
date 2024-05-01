<?php

namespace Towoju5\Referral\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

trait UserReferral
{
    public function getReferralLink()
    {
        return url('/').'/?ref='.urlencode($this->affiliate_id);
    }

    public function myReferrals()
    {
        return \App\Models\User::where('referred_by', auth()->id())->get();
    }

    public static function scopeReferralExists(Builder $query, $referral)
    {
        return $query->whereAffiliateId($referral)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $referredBy = Cookie::get('referral');
                if ($referredBy) {
                    $model->referred_by = $referredBy;
                }
            } catch (\Throwable $e) {
                // Handle error, if any
                report($e);
            }

            $model->affiliate_id = self::generateReferral();
        });
    }

    protected static function generateReferral()
    {
        $length = config('referral.referral_length', 5);

        do {
            $referral = Str::random($length);
        } while (static::referralExists($referral));

        return $referral;
    }
}
