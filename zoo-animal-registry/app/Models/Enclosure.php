<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enclosure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'limit',
        'feeding_at',
        'for_predators',
    ];

    protected function casts(): array
    {
        return [
            'limit' => 'integer',
            'feeding_at' => 'string',
            'for_predators' => 'boolean',
        ];
    }

    // Get the users that belong to this enclosure.
    public function users(): BelongsToMany {
        return $this->BelongsToMany(User::class)->withTimestamps();
    }

    // Get the animals in the enclosure.
    public function animals(): HasMany {
        return $this->hasMany(Animal::class);
    }
}
