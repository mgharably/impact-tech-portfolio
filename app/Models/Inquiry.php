<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Inquiry extends Model { protected $fillable=['name', 'email', 'service', 'message', 'status']; protected function casts(): array { return []; } }
