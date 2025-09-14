<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    /** @use HasFactory<\Database\Factories\DraftFactory> */
    use HasFactory;

    public function picks()
    {
        return $this->hasMany(DraftPicks::class);
    }

    public function start(): void
    {
        $this->status = 'active';
        $this->started_at = now();

        $this->save();
    }

    public function complete(): void
    {
        $this->status = 'complete';
        $this->completed_at = now();

        $this->save();
    }
}
