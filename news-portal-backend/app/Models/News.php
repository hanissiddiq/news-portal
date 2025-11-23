<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model {
    protected $fillable = ['user_id','category_id','title','slug','excerpt','body','image','published'];

    public function author(){ return $this->belongsTo(User::class,'user_id'); }
    public function category(){ return $this->belongsTo(Category::class); }

    // auto set slug on creating
    protected static function booted(){
        static::creating(function($news){
            if (!$news->slug) $news->slug = Str::slug($news->title).'-'.uniqid();
        });
    }
}
