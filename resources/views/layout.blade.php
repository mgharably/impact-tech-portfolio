<!doctype html>
<html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>@yield('title','Impact Tech | حلول رقمية تصنع أثرًا')</title><meta name="description" content="{{ $settings['seo_description'] ?? 'Impact Tech — تطوير الويب والموبايل وحلول البيانات' }}">@if(request()->is('admin*') || request()->is('login'))<meta name="robots" content="noindex,nofollow">@endif<link rel="stylesheet" href="{{ asset('css/site.css') }}"></head>
<body style="--accent:{{ preg_match('/^#[0-9a-fA-F]{6}$/', $settings['brand_color'] ?? '') ? $settings['brand_color'] : '#8875ff' }}">
<header class="header"><a href="/" class="brand" dir="ltr">@if(!empty($settings['logo']))<img src="{{ asset('storage/'.$settings['logo']) }}" alt="Impact Tech" class="logo">@else<span class="brand-mark">/i.</span><span>impact<span class="brand-light">tech</span><small>DIGITAL SOLUTIONS</small></span>@endif</a><nav aria-label="التنقل الرئيسي"><a href="/#services">خدماتنا</a><a href="/#work">أعمالنا</a><a href="/#about">عن الشركة</a></nav><a class="button small" href="/#contact">لنبدأ مشروعك ↗</a></header>
@if(session('success'))<div class="notice" role="status">{{ session('success') }}</div>@endif
@if($errors->any())<div class="notice error" role="alert"><strong>يرجى مراجعة البيانات:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('body')
<footer><a href="/" class="brand" dir="ltr">impact<span class="brand-light">tech</span></a><p>حلول رقمية. أثر مستمر.</p><span>© {{ date('Y') }} Impact Tech</span><a href="https://impacttech.digital">الموقع الرئيسي ↗</a></footer>
<script src="{{ asset('js/site.js') }}" defer></script></body></html>
