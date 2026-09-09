<!doctype html>
<html lang="ar" dir="rtl">
<head>
<meta charset="utf-8">
<style>
@page { margin: 14mm 16mm; size: A4-L; }
body { font-family: dejavusans; color: #0a2236; font-size: 10pt; line-height: 1.45; }
h1,h2,h3,p { margin-top: 0; }
.cover { text-align: center; padding-top: 22mm; }
.cover-logo { width: 100mm; max-height: 38mm; }
.cover h1 { color: #082436; font-size: 34pt; line-height: 1.15; margin: 20mm 0 5mm; }
.cover-lead { color: #3d6474; font-size: 15pt; }
.accent-line { width: 30mm; height: 3px; background: #09bdb7; margin: 12mm auto 8mm; }
.capabilities { color: #078f8b; font-size: 10pt; letter-spacing: 1px; }
.kicker { color: #078f8b; font-size: 8pt; letter-spacing: 1.3px; margin-bottom: 3mm; }
.title { color: #082436; font-size: 25pt; line-height: 1.2; margin-bottom: 8mm; }
.lead { color: #3e5f71; font-size: 14pt; line-height: 1.65; }
.two { width: 100%; border-collapse: separate; border-spacing: 7mm 0; table-layout: fixed; }
.two td { width: 50%; vertical-align: top; }
.card { border: 1px solid #d8e7e9; border-top: 3px solid #09bdb7; background: #f7fbfc; padding: 6mm; }
.card h3 { font-size: 14pt; margin-bottom: 2mm; }
.card p { color: #4e6878; }
.service-table { width: 100%; border-collapse: separate; border-spacing: 5mm 3mm; table-layout: fixed; }
.service-table td { width: 50%; vertical-align: top; border-bottom: 1px solid #d7e5e7; padding: 2mm 1mm 3mm; }
.service-table b { display: block; font-size: 11.5pt; color: #102f40; }
.service-table small { color: #078f8b; }
.microsoft { background: #0b3446; color: #fff; padding: 5mm; margin-top: 4mm; }
.microsoft table { width: 100%; table-layout: fixed; }
.microsoft td { width: 33%; vertical-align: top; padding-left: 5mm; }
.microsoft b { color: #5ce0da; display: block; font-size: 11.5pt; }
.microsoft span { color: #c5dbde; font-size: 8.5pt; }
.team-table { width: 100%; border-collapse: separate; border-spacing: 5mm 4mm; table-layout: fixed; }
.team-table td { width: 33%; vertical-align: top; background: #f7fbfc; border-top: 3px solid #09bdb7; padding: 4mm; }
.team-table h3 { font-size: 12pt; margin-bottom: 1mm; }
.team-table b { color: #078f8b; font-size: 8.5pt; }
.team-table p { color: #526c7b; font-size: 8pt; margin: 2mm 0 0; }
.process { width: 100%; margin-top: 5mm; table-layout: fixed; }
.process td { width: 25%; border-top: 1px solid #8fcac7; padding: 3mm; }
.process b { color: #078f8b; }
.project-table { width: 100%; border-collapse: separate; border-spacing: 4mm 3mm; table-layout: fixed; }
.project-table td { width: 33%; vertical-align: top; background: #f7fbfc; border: 1px solid #dae7e9; padding: 3.5mm; }
.project-table small { color: #078f8b; }
.project-table h3 { font-size: 11pt; margin: 1mm 0; }
.project-table p { color: #526c7b; font-size: 8pt; margin: 0; }
.contact { background: #082f40; color: #fff; margin-top: 6mm; padding: 5mm; }
.contact table { width: 100%; table-layout: fixed; }
.contact td { width: 25%; vertical-align: middle; }
.contact b { color: #5ce0da; }
.footer { border-top: 1px solid #d7e5e7; color: #718794; font-size: 7.5pt; margin-top: 7mm; padding-top: 2mm; }
.page-number { float: left; }
.ltr { direction: ltr; text-align: left; }
</style>
</head>
<body>

<div class="cover">
@if(!empty($settings['logo']) && file_exists(storage_path('app/public/'.$settings['logo'])))
<img class="cover-logo" src="{{ storage_path('app/public/'.$settings['logo']) }}">
@elseif(file_exists(public_path('images/impact-logo.png')))
<img class="cover-logo" src="{{ public_path('images/impact-logo.png') }}">
@endif
<h1>حلول رقمية تصنع أثرًا.</h1>
<p class="cover-lead">نبني التجارب الرقمية التي تساعد الأعمال على التطور والنمو.</p>
<div class="accent-line"></div>
<p class="capabilities" dir="ltr">WEB DEVELOPMENT · MOBILE APPLICATIONS · MICROSOFT POWER PLATFORM · DATA &amp; BI</p>
<div class="footer">IMPACT TECH · COMPANY PROFILE <span class="page-number">01 / 05</span></div>
</div>

<pagebreak />

<div>
<div class="kicker">01 / ABOUT IMPACT TECH</div>
<table class="two"><tr>
<td><h1 class="title">نفهم عملك.<br>ثم نبني له.</h1><p class="lead">{{ $settings['about'] }}</p></td>
<td>
<div class="card" style="margin-bottom:7mm"><div class="kicker">OUR VISION</div><h3>رؤيتنا</h3><p>{{ $settings['vision'] ?? '' }}</p></div>
<div class="card"><div class="kicker">OUR MISSION</div><h3>رسالتنا</h3><p>{{ $settings['mission'] ?? '' }}</p></div>
</td>
</tr></table>
<div class="footer">IMPACT TECH · ABOUT <span class="page-number">02 / 05</span></div>
</div>

<pagebreak />

<div>
<div class="kicker">02 / WHAT WE DO</div>
<h1 class="title">خبرة تقنية تخدم نمو أعمالك.</h1>
<table class="service-table">
@foreach($services->take(8)->chunk(2) as $row)
<tr>@foreach($row as $service)<td><small>{{ $service->label }}</small><b>{{ $service->title }}</b><span>{{ $service->description }}</span></td>@endforeach @if($row->count()===1)<td></td>@endif</tr>
@endforeach
</table>
<div class="microsoft"><table><tr>
<td><b>Microsoft Dynamics 365</b><span>CRM · Operations · Customer journeys</span></td>
<td><b>Microsoft Power Apps</b><span>Business apps · Workflows · Microsoft 365</span></td>
<td><b>Microsoft Power BI</b><span>Dashboards · Data models · Insights</span></td>
</tr></table></div>
<div class="footer">IMPACT TECH · SERVICES <span class="page-number">03 / 05</span></div>
</div>

<pagebreak />

<div>
<div class="kicker">03 / OUR TEAM</div>
<h1 class="title">فريق يجمع التقنية وفهم الأعمال.</h1>
@if($team->isNotEmpty())
<table class="team-table">
@foreach($team->take(5)->chunk(3) as $row)
<tr>@foreach($row as $member)<td><h3>{{ $member->name }}</h3><b>{{ $member->role }}</b><p>{{ $member->bio }}</p></td>@endforeach @for($i=$row->count();$i<3;$i++)<td></td>@endfor</tr>
@endforeach
</table>
@else
<div class="card"><h3>Impact Tech Team</h3><p>فريق متعدد المهارات في هندسة البرمجيات وتطبيقات الموبايل وحلول Microsoft وتحليل البيانات والدعم التقني.</p></div>
@endif
<table class="process"><tr><td><b>01 · نفهم</b><br>الأهداف والأولويات</td><td><b>02 · نصمم</b><br>التجربة والحل</td><td><b>03 · نطوّر</b><br>البناء والاختبار</td><td><b>04 · نطلق</b><br>التسليم والدعم</td></tr></table>
<div class="footer">IMPACT TECH · TEAM &amp; PROCESS <span class="page-number">04 / 05</span></div>
</div>

<pagebreak />

<div>
<div class="kicker">04 / SELECTED WORK</div>
<h1 class="title">حلول بنيناها لتحديات حقيقية.</h1>
<table class="project-table">
@foreach($projects->take(6)->chunk(3) as $row)
<tr>@foreach($row as $project)<td><small>{{ $project->category }}</small><h3>{{ $project->title }}</h3><p>{{ $project->summary }}</p></td>@endforeach @for($i=$row->count();$i<3;$i++)<td></td>@endfor</tr>
@endforeach
</table>
<div class="contact"><table><tr>
<td><b>LET'S BUILD WHAT'S NEXT</b><br>ابدأ مشروعك معنا</td>
<td class="ltr">{{ $settings['email'] ?? 'info@impacttech.digital' }}</td>
<td class="ltr">{{ $settings['phone'] ?? '+962 7 7915 2624' }}</td>
<td class="ltr">impacttech.site</td>
</tr></table></div>
<div class="footer">IMPACT TECH · SELECTED WORK &amp; CONTACT <span class="page-number">05 / 05</span></div>
</div>

</body>
</html>
