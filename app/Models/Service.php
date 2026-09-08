<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Service extends Model { protected $fillable=['title', 'description', 'label', 'sort_order', 'published']; protected function casts(): array { return ['published'=>'boolean']; } }
