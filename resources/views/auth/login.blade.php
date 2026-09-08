@extends('layout')
@section('title','دخول الإدارة | Impact Tech')
@section('body')<main class="login-card form-panel"><span class="eyebrow">IMPACT TECH / ADMIN</span><h1>أهلًا بعودتك.</h1><p>سجّل الدخول لإدارة محتوى الموقع.</p><form method="post" action="/login">@csrf<label>البريد الإلكتروني<input type="email" name="email" required value="{{ old('email') }}" dir="ltr" autocomplete="username"></label><label>كلمة المرور<input type="password" name="password" required autocomplete="current-password" dir="ltr"></label><button class="button">دخول لوحة التحكم ↗</button></form></main>@endsection
