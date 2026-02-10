<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'patients';

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
        'mrn',
        'name',
        'phone',
        'identity_number',
        'address',
        'user_id',
        'birth_date',
        'gender',
        'blood_type',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($patient) {
            if (empty($patient->id)) {
                $patient->id = (string) Str::uuid();
            }

            if (empty($patient->mrn)) {
                do {
                    $mrn = 'MRN' . strtoupper(Str::random(8));
                } while (self::where('mrn', $mrn)->exists());

                $patient->mrn = $mrn;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
