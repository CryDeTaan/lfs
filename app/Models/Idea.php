<?php

namespace App\Models;

use App\Enums\IdeaState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['description', 'state'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'state' => IdeaState::class,
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
