<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'quiz_category');
    }

    public function scopePublished(Builder $query): Builder
    {
        $quizAuthor = Auth::guard('sanctum')->user();

        return $query->where('is_published', true)
            ->when($quizAuthor, function($q) use ($quizAuthor) {
                $q->orWhere('user_id', $quizAuthor->id);
            });
    }
}
