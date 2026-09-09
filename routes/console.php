<?php
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Services\PortfolioPdfBuilder;
Artisan::command('impact:admin {email}', function () {
$email=$this->argument('email');
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){$this->error('Invalid email');return 1;}
if(User::where('email',$email)->exists()){$this->error('Account already exists; use impact:password.');return 1;}
$password=$this->secret('Password (at least 12 characters)');
if(strlen($password??'')<12){$this->error('Password too short');return 1;}
User::create(['name'=>'Impact Tech Admin','email'=>$email,'password'=>$password,'is_admin'=>true]);$this->info('Administrator created.');
});
Artisan::command('impact:password {email}',function(){
$user=User::where('email',$this->argument('email'))->where('is_admin',true)->firstOrFail();
$password=$this->secret('New password (at least 12 characters)');
if(strlen($password??'')<12){$this->error('Password too short');return 1;}
$user->update(['password'=>$password]);$this->info('Password updated.');
});
Artisan::command('impact:portfolio',function(PortfolioPdfBuilder $builder){
    $path=$builder->build();
    $this->info('Portfolio generated: '.$path);
});
