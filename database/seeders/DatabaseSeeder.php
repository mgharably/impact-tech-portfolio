<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Setting,Service};
class DatabaseSeeder extends Seeder { public function run(): void {
Setting::firstOrCreate(['key'=>'hero_title'],['value'=>'نحوّل فكرتك إلى تجربة رقمية تصنع أثرًا.']);
Setting::firstOrCreate(['key'=>'hero_text'],['value'=>'نطوّر مواقع وتطبيقات وحلول بيانات تساعد شركتك على العمل بشكل أفضل. من أداة بسيطة إلى منصة متكاملة، نبدأ بما تحتاجه فعلًا.']);
Setting::firstOrCreate(['key'=>'about'],['value'=>'Impact Tech شركة برمجيات تعمل على مشاريع الويب وتطبيقات الموبايل ولوحات Power BI، إلى جانب الحلول البرمجية الخفيفة والمساعدة التقنية. نفهم احتياج المشروع ونبني حلًا واضحًا يمكن تطويره مع نمو الأعمال.']);
Setting::firstOrCreate(['key'=>'email'],['value'=>'']);
Setting::firstOrCreate(['key'=>'phone'],['value'=>'']);
Setting::firstOrCreate(['key'=>'whatsapp'],['value'=>'']);
Setting::firstOrCreate(['key'=>'seo_description'],['value'=>'Impact Tech — تطوير مواقع وتطبيقات موبايل ولوحات Power BI وحلول برمجية ودعم تقني للشركات والمشاريع.']);
Setting::firstOrCreate(['key'=>'brand_color'],['value'=>'#8875ff']);
Service::firstOrCreate(['title'=>'تطوير مواقع وتطبيقات الويب'],['description'=>'مواقع شركات، منصات أعمال وأنظمة ويب مخصصة، بتجربة سهلة ولوحة تحكم تناسب طريقة عملك.','label'=>'WEB DEVELOPMENT','sort_order'=>0,'published'=>true]);
Service::firstOrCreate(['title'=>'تطبيقات الموبايل'],['description'=>'تطبيقات للهواتف تربط عملاءك بخدماتك وتسهّل الاستخدام اليومي.','label'=>'MOBILE APPLICATIONS','sort_order'=>1,'published'=>true]);
Service::firstOrCreate(['title'=>'لوحات Power BI'],['description'=>'تحويل بيانات العمل إلى تقارير ولوحات تفاعلية تساعدك على متابعة الأداء وفهم النتائج.','label'=>'DATA & ANALYTICS','sort_order'=>2,'published'=>true]);
Service::firstOrCreate(['title'=>'حلول برمجية خفيفة'],['description'=>'أدوات بسيطة لإنجاز مهام محددة: إدارة الطلبات، النماذج، المتابعة وتنظيم البيانات.','label'=>'SMART TOOLS','sort_order'=>3,'published'=>true]);
Service::firstOrCreate(['title'=>'الدعم والمساعدة التقنية'],['description'=>'تشخيص المشاكل التقنية، المساعدة في الإعداد والمتابعة وتحسين استقرار الحلول القائمة.','label'=>'TECH SUPPORT','sort_order'=>4,'published'=>true]);
Service::firstOrCreate(['title'=>'ربط الأنظمة وأتمتة المهام'],['description'=>'ربط الخدمات عبر API وتقليل نقل البيانات يدويًا بين الأدوات.','label'=>'INTEGRATIONS','sort_order'=>5,'published'=>false]);
Service::firstOrCreate(['title'=>'صفحات هبوط ومواقع تعريفية'],['description'=>'صفحات واضحة لعرض خدمتك واستقبال استفسارات العملاء.','label'=>'LANDING PAGES','sort_order'=>6,'published'=>false]);
Service::firstOrCreate(['title'=>'صيانة وتطوير الأنظمة'],['description'=>'تحسين وظائف المواقع القائمة ومعالجة الأعطال وإضافة خصائص جديدة.','label'=>'MAINTENANCE','sort_order'=>7,'published'=>false]);
}}
