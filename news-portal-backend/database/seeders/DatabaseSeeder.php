<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\News;


class DatabaseSeeder extends Seeder {
    public function run() {
        User::factory()->create([
            'name'=>'Admin User','email'=>'admin@gmail.com','password'=>bcrypt('password'),'role'=>'admin'
        ]);
        User::factory()->create([
            'name'=>'Author User','email'=>'author@gmail.com','password'=>bcrypt('password'),'role'=>'author'
        ]);
        User::factory()->create([
            'name'=>'Regular User','email'=>'user@gmail.com','password'=>bcrypt('password'),'role'=>'user'
        ]);

        $c1 = Category::create(['name'=>'Teknologi','slug'=>'teknologi']);
        $c2 = Category::create(['name'=>'Ekonomi','slug'=>'ekonomi']);
        $c3 = Category::create(['name'=>'Olahraga','slug'=>'olahraga']);

        News::create([
            'user_id'=>1,'category_id'=>$c1->id,'title'=>'Berita Teknologi 1','slug'=>'berita-teknologi-1','excerpt'=>'Ringkasan berita teknologi 1','body'=>'Isi lengkap berita teknologi 1','published'=>true
        ]);
        News::create([
            'user_id'=>2,'category_id'=>$c2->id,'title'=>'Update Ekonomi Hari Ini','slug'=>'update-ekonomi-hari-ini','excerpt'=>'Ringkasan ekonomi','body'=>'Isi lengkap ekonomi','published'=>true
        ]);
    }
}
