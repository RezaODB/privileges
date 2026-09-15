<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
            'video' => 'boolean',
            'important' => 'boolean',
            'shot' => 'boolean',
            'questionnaire' => 'boolean',
            'interviewed' => 'boolean',
            'eject' => 'boolean',
            'nl' => 'boolean',
            'fr' => 'boolean',
            'repro' => 'boolean',
            'doute' => 'boolean',
            'lgtb' => 'boolean',
            'senior' => 'boolean',
            'racises' => 'boolean',
        ];
    }

    public function answers(): HasOne
    {
        return $this->hasOne(Answer::class);
    }

    /**
     * Record the questionnaire, creating the answer row when it is missing and
     * leaving any votes already cast untouched.
     *
     * @param  array<array-key, mixed>  $answers
     */
    public function saveQuestionnaire(array $answers): void
    {
        $this->answers()
            ->firstOrNew([], ['votes' => []])
            ->fill(['answers' => $answers])
            ->save();

        $this->unsetRelation('answers');
    }

    /**
     * Determine whether the user has been ejected and may no longer access the site.
     * Administrators are never ejected, so they can always undo the flag.
     */
    public function isEjected(): bool
    {
        return (bool) $this->eject && (int) $this->role !== 2;
    }
}
