<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
public function up(): void {
Schema::create('users',function(Blueprint $t){$t->id();$t->string('name');$t->string('email')->unique();$t->string('password');$t->boolean('is_admin')->default(false);$t->rememberToken();$t->timestamps();});
Schema::create('settings',function(Blueprint $t){$t->id();$t->string('key')->unique();$t->text('value')->nullable();$t->timestamps();});
Schema::create('services',function(Blueprint $t){$t->id();$t->string('title');$t->text('description');$t->string('label')->nullable();$t->unsignedInteger('sort_order')->default(0);$t->boolean('published')->default(false);$t->timestamps();});
Schema::create('projects',function(Blueprint $t){$t->id();$t->string('title');$t->string('category');$t->text('summary');foreach(['problem','solution','services','technologies','result'] as $f){$t->text($f)->nullable();}$t->string('url',2048)->nullable();$t->string('image')->nullable();$t->boolean('published')->default(false);$t->unsignedInteger('sort_order')->default(0);$t->timestamps();});
Schema::create('inquiries',function(Blueprint $t){$t->id();$t->string('name');$t->string('email');$t->string('service');$t->text('message');$t->string('status')->default('new');$t->timestamps();});
}
public function down(): void {foreach(['inquiries','projects','services','settings','users'] as $table)Schema::dropIfExists($table);}
};
