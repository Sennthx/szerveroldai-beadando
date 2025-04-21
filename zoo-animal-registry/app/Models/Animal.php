<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'species',
        'is_predator',
        'born_at',
        'deleted_at',
        'enclosure_id',
        'image_name',
        'image_hash',
    ];

    protected $hidden = [
        'image_hash',
    ];

    protected function casts(): array
    {
        return [
            'is_predator' => 'boolean',
            'password' => 'hashed',
            'born_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function archive(): void {
        $afterlifeId = config('zoo.afterlife_enclosure_id');
        $this->update([
            'enclosure_id' => $afterlifeId,
        ]);
        $this->delete(); // soft delete
    }

    // Get the enclosure that belong to this animal.
    public function enclosure(): BelongsTo {
        return $this->belongsTo(Enclosure::class);
    }
}
