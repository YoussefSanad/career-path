<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Every application belongs to an applicant (user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Every application belongs to a job post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
}
