<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = ['name', 'role', 'bio', 'skills', 'image', 'published', 'sort_order'];

    protected function casts(): array
    {
        return ['published' => 'boolean'];
    }
}
