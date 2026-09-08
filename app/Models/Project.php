<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model { protected $fillable=['title', 'category', 'summary', 'problem', 'solution', 'services', 'technologies', 'result', 'url', 'image', 'published', 'sort_order']; protected function casts(): array { return ['published'=>'boolean']; } }
