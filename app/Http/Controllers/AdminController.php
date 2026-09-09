<?php
namespace App\Http\Controllers;
use App\Models\{Setting,Service,Project,Inquiry,TeamMember};
use App\Services\PortfolioPdfBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class AdminController {
private function refreshPortfolioAfterResponse(): void {app()->terminating(fn()=>app(PortfolioPdfBuilder::class)->build());}
private function model(string $type): string {return match($type){'services'=>Service::class,'projects'=>Project::class,'team'=>TeamMember::class,default=>abort(404)};}
public function dashboard(){return view('admin.dashboard',['projects'=>Project::count(),'services'=>Service::count(),'team'=>TeamMember::count(),'inquiries'=>Inquiry::where('status','new')->count()]);}
public function index(string $type){$model=$this->model($type);return view('admin.index',['type'=>$type,'items'=>$model::orderBy('sort_order')->get()]);}
public function edit(string $type,?int $id=null){$model=$this->model($type);return view('admin.edit',['type'=>$type,'item'=>$id?$model::findOrFail($id):new $model]);}
public function save(Request $r,string $type,?int $id=null){
$model=$this->model($type);$item=$id?$model::findOrFail($id):new $model;
$rules=['title'=>'required|string|max:180','sort_order'=>'required|integer|min:0|max:9999','published'=>'nullable|boolean'];
$rules+=match($type){
'services'=>['description'=>'required|string|max:2000','label'=>'nullable|string|max:100'],
'team'=>['role'=>'required|string|max:150','bio'=>'nullable|string|max:3000','skills'=>'nullable|string|max:1000','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096','remove_image'=>'nullable|boolean'],
default=>['category'=>'required|string|max:100','summary'=>'required|string|max:2000','problem'=>'nullable|string|max:5000','solution'=>'nullable|string|max:5000','services'=>'nullable|string|max:2000','technologies'=>'nullable|string|max:2000','result'=>'nullable|string|max:5000','url'=>'nullable|url:http,https|max:2048','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096','remove_image'=>'nullable|boolean']};
$data=$r->validate($rules);$data['published']=$r->boolean('published');
if($type==='team'){$data['name']=$data['title'];unset($data['title']);}
$old=$item->image;$remove=$r->boolean('remove_image');unset($data['image'],$data['remove_image']);
if(in_array($type,['projects','team'],true)){if($r->hasFile('image'))$data['image']=$r->file('image')->store($type,'public');elseif($remove)$data['image']=null;}
$item->fill($data)->save();
if($old&&array_key_exists('image',$data)&&$old!==$data['image'])Storage::disk('public')->delete($old);
$this->refreshPortfolioAfterResponse();
return redirect('/admin/'.$type)->with('success','تم حفظ التغييرات.');
}
public function delete(string $type,int $id){$model=$this->model($type);$item=$model::findOrFail($id);$image=$item->image;$item->delete();if($image)Storage::disk('public')->delete($image);$this->refreshPortfolioAfterResponse();return back()->with('success','تم الحذف.');}
public function settings(){return view('admin.settings',['settings'=>Setting::pluck('value','key')]);}
public function saveSettings(Request $r){$data=$r->validate(['hero_title'=>'required|string|max:150','hero_text'=>'required|string|max:600','about'=>'required|string|max:3000','vision'=>'required|string|max:2000','mission'=>'required|string|max:2000','email'=>'nullable|email|max:254','phone'=>'nullable|string|max:40','whatsapp'=>'nullable|regex:/^[0-9]{8,15}$/','seo_description'=>'required|string|max:300','brand_color'=>'required|regex:/^#[0-9a-fA-F]{6}$/','logo'=>'nullable|image|mimes:png,jpg,jpeg,webp|max:2048']);unset($data['logo']);if($r->hasFile('logo')){$old=Setting::where('key','logo')->value('value');$data['logo']=$r->file('logo')->store('brand','public');}foreach($data as $key=>$value)Setting::updateOrCreate(['key'=>$key],['value'=>$value]);if(!empty($old))Storage::disk('public')->delete($old);$this->refreshPortfolioAfterResponse();return back()->with('success','تم تحديث الموقع وسيتم تجهيز PDF جديد خلال لحظات.');}
public function generatePortfolio(){ $this->refreshPortfolioAfterResponse(); return back()->with('success','بدأ تجهيز Company Profile جديد. انتظر نحو دقيقة ثم نزّل الملف.'); }
public function inquiries(){return view('admin.inquiries',['items'=>Inquiry::latest()->paginate(20)]);}
public function status(Request $r,Inquiry $inquiry){$inquiry->update($r->validate(['status'=>['required',Rule::in(['new','contacted','closed'])]]));return back()->with('success','تم تحديث حالة الطلب.');}
}
