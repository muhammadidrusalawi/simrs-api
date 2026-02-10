<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'doctors';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'user_id',
        'name',
        'sip_number',
        'specialization',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($doctor) {
            if (empty($doctor->id)) {
                $doctor->id = (string)Str::uuid();
            }

            if (empty($doctor->sip_number)) {
                do {
                    $sip = 'SIP' . strtoupper(Str::random(6));
                } while (self::where('sip_number', $sip)->exists());

                $doctor->sip_number = $sip;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doctorSchedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
