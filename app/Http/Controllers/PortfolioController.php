<?php
namespace App\Http\Controllers;
use App\Models\{Setting,Service,Project,Inquiry,TeamMember};
use App\Services\PortfolioPdfBuilder;
use Illuminate\Http\Request;
class PortfolioController {
 public function home(){return view('home',['settings'=>Setting::pluck('value','key'),'services'=>Service::where('published',true)->orderBy('sort_order')->get(),'projects'=>Project::where('published',true)->orderBy('sort_order')->get(),'team'=>TeamMember::where('published',true)->orderBy('sort_order')->get()]);}
 public function project(Project $project){abort_unless($project->published,404);return view('project',compact('project'));}
 public function contact(Request $r){$data=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|max:254','service'=>'required|string|max:150','message'=>'required|string|min:10|max:5000','website'=>'nullable|max:0']);unset($data['website']);Inquiry::create($data);return redirect('/#contact')->with('success','وصل طلبك إلى فريق Impact Tech. شكرًا لتواصلك معنا.');}
 public function pdf(PortfolioPdfBuilder $builder){
  abort_unless(is_file($builder->path()),503,'يتم تجهيز ملف الشركة. يرجى المحاولة بعد دقيقة.');
  return response()->download($builder->path(),'Impact-Tech-Portfolio-'.date('Y-m-d').'.pdf',['Content-Type'=>'application/pdf']);
 }
}
