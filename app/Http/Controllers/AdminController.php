<?php
namespace App\Http\Controllers;
use App\Models\{Setting,Service,Project,Inquiry};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class AdminController {
private function model(string $type): string {return match($type){'services'=>Service::class,'projects'=>Project::class,default=>abort(404)};}
public function dashboard(){return view('admin.dashboard',['projects'=>Project::count(),'services'=>Service::count(),'inquiries'=>Inquiry::where('status','new')->count()]);}
public function index(string $type){$model=$this->model($type);return view('admin.index',['type'=>$type,'items'=>$model::orderBy('sort_order')->get()]);}
public function edit(string $type,?int $id=null){$model=$this->model($type);return view('admin.edit',['type'=>$type,'item'=>$id?$model::findOrFail($id):new $model]);}
public function save(Request $r,string $type,?int $id=null){
$model=$this->model($type);$item=$id?$model::findOrFail($id):new $model;
$rules=['title'=>'required|string|max:180','sort_order'=>'required|integer|min:0|max:9999','published'=>'nullable|boolean'];
$rules+=$type==='services'?['description'=>'required|string|max:2000','label'=>'nullable|string|max:100']:['category'=>'required|string|max:100','summary'=>'required|string|max:2000','problem'=>'nullable|string|max:5000','solution'=>'nullable|string|max:5000','services'=>'nullable|string|max:2000','technologies'=>'nullable|string|max:2000','result'=>'nullable|string|max:5000','url'=>'nullable|url:http,https|max:2048','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096','remove_image'=>'nullable|boolean'];
$data=$r->validate($rules);$data['published']=$r->boolean('published');
$old=$item->image;$remove=$r->boolean('remove_image');unset($data['image'],$data['remove_image']);
if($type==='projects'){if($r->hasFile('image'))$data['image']=$r->file('image')->store('projects','public');elseif($remove)$data['image']=null;}
$item->fill($data)->save();
if($old&&array_key_exists('image',$data)&&$old!==$data['image'])Storage::disk('public')->delete($old);
return redirect('/admin/'.$type)->with('success','تم حفظ التغييرات.');
}
public function delete(string $type,int $id){$model=$this->model($type);$item=$model::findOrFail($id);$image=$item->image;$item->delete();if($image)Storage::disk('public')->delete($image);return back()->with('success','تم الحذف.');}
public function settings(){return view('admin.settings',['settings'=>Setting::pluck('value','key')]);}
public function saveSettings(Request $r){$data=$r->validate(['hero_title'=>'required|string|max:150','hero_text'=>'required|string|max:600','about'=>'required|string|max:3000','email'=>'nullable|email|max:254','phone'=>'nullable|string|max:40','whatsapp'=>'nullable|regex:/^[0-9]{8,15}$/','seo_description'=>'required|string|max:300','brand_color'=>'required|regex:/^#[0-9a-fA-F]{6}$/','logo'=>'nullable|image|mimes:png,jpg,jpeg,webp|max:2048']);unset($data['logo']);if($r->hasFile('logo')){$old=Setting::where('key','logo')->value('value');$data['logo']=$r->file('logo')->store('brand','public');}foreach($data as $key=>$value)Setting::updateOrCreate(['key'=>$key],['value'=>$value]);if(!empty($old))Storage::disk('public')->delete($old);return back()->with('success','تم تحديث الموقع.');}
public function inquiries(){return view('admin.inquiries',['items'=>Inquiry::latest()->paginate(20)]);}
public function status(Request $r,Inquiry $inquiry){$inquiry->update($r->validate(['status'=>['required',Rule::in(['new','contacted','closed'])]]));return back()->with('success','تم تحديث حالة الطلب.');}
}
