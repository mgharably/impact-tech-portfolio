<?php
namespace App\Http\Controllers;
use App\Models\{Setting,Service,Project,Inquiry,TeamMember};
use Illuminate\Http\Request;
class PortfolioController {
 public function home(){return view('home',['settings'=>Setting::pluck('value','key'),'services'=>Service::where('published',true)->orderBy('sort_order')->get(),'projects'=>Project::where('published',true)->orderBy('sort_order')->get(),'team'=>TeamMember::where('published',true)->orderBy('sort_order')->get()]);}
 public function project(Project $project){abort_unless($project->published,404);return view('project',compact('project'));}
 public function contact(Request $r){$data=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|max:254','service'=>'required|string|max:150','message'=>'required|string|min:10|max:5000','website'=>'nullable|max:0']);unset($data['website']);Inquiry::create($data);return redirect('/#contact')->with('success','وصل طلبك إلى فريق Impact Tech. شكرًا لتواصلك معنا.');}
 public function pdf(){
  $data=['settings'=>Setting::pluck('value','key'),'services'=>Service::where('published',true)->orderBy('sort_order')->get(),'projects'=>Project::where('published',true)->orderBy('sort_order')->get(),'team'=>TeamMember::where('published',true)->orderBy('sort_order')->get()];
  if(!is_dir(storage_path('app/mpdf')))mkdir(storage_path('app/mpdf'),0775,true);
  $mpdf=new \Mpdf\Mpdf(['mode'=>'utf-8','format'=>'A4-L','margin_left'=>0,'margin_right'=>0,'margin_top'=>0,'margin_bottom'=>0,'default_font'=>'dejavusans','tempDir'=>storage_path('app/mpdf')]);
  $mpdf->SetDirectionality('rtl');
  $mpdf->SetTitle('Impact Tech Portfolio');
  $mpdf->SetAuthor('Impact Tech');
  $mpdf->WriteHTML(view('portfolio-slides',$data)->render());
  return response($mpdf->Output('',\Mpdf\Output\Destination::STRING_RETURN),200,['Content-Type'=>'application/pdf','Content-Disposition'=>'attachment; filename="Impact-Tech-Portfolio-'.date('Y-m-d').'.pdf"']);
 }
}
