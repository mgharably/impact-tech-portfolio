<?php
namespace Tests\Feature;
use App\Models\{User,Project,Inquiry};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
class PortfolioTest extends TestCase {
use RefreshDatabase;
public function test_public_home_and_draft_visibility(): void {
$this->seed();$p=Project::create(['title'=>'Private draft','category'=>'Web','summary'=>'Private project','published'=>false]);
$this->get('/')->assertOk()->assertDontSee('Private draft');$this->get('/projects/'.$p->id)->assertNotFound();
$p->update(['published'=>true]);$this->get('/')->assertSee('Private draft');$this->get('/projects/'.$p->id)->assertOk();
}
public function test_admin_requires_authorized_account(): void {
$this->get('/admin')->assertRedirect('/login');
$u=User::create(['name'=>'User','email'=>'user@example.test','password'=>'example-password','is_admin'=>false]);
$this->actingAs($u)->get('/admin')->assertForbidden();
}
public function test_admin_can_save_project_and_upload_image(): void {
Storage::fake('public');$u=User::create(['name'=>'Admin','email'=>'admin@example.test','password'=>'example-password','is_admin'=>true]);
$this->actingAs($u)->post('/admin/projects',['title'=>'Verified project','category'=>'Web','summary'=>'A real supplied summary','sort_order'=>0,'published'=>1,'image'=>UploadedFile::fake()->image('cover.png')])->assertRedirect('/admin/projects');
$p=Project::firstOrFail();$this->assertTrue($p->published);Storage::disk('public')->assertExists($p->image);
$this->get('/admin/projects/'.$p->id.'/edit')->assertOk();
$this->delete('/admin/projects/'.$p->id)->assertRedirect();Storage::disk('public')->assertMissing($p->image);
}
public function test_contact_is_validated_and_stored(): void {
$this->post('/contact',['name'=>'Client','email'=>'invalid'])->assertSessionHasErrors();
$this->post('/contact',['name'=>'Client','email'=>'client@example.test','service'=>'Web','message'=>'We need a company website.'])->assertRedirect('/#contact');
$this->assertDatabaseHas('inquiries',['email'=>'client@example.test','status'=>'new']);
}
public function test_admin_login_and_logout(): void {
User::create(['name'=>'Admin','email'=>'admin@example.test','password'=>'example-password','is_admin'=>true]);
$this->post('/login',['email'=>'admin@example.test','password'=>'wrong'])->assertSessionHasErrors();
$this->post('/login',['email'=>'admin@example.test','password'=>'example-password'])->assertRedirect('/admin');
$this->assertAuthenticated();$this->get('/admin')->assertOk();$this->post('/logout')->assertRedirect('/');$this->assertGuest();
}
public function test_invalid_project_url_is_rejected(): void {
$u=User::create(['name'=>'Admin','email'=>'admin@example.test','password'=>'example-password','is_admin'=>true]);
$this->actingAs($u)->post('/admin/projects',['title'=>'Project','category'=>'Web','summary'=>'Description','sort_order'=>0,'url'=>'javascript:alert(1)'])->assertSessionHasErrors('url');
}
}
