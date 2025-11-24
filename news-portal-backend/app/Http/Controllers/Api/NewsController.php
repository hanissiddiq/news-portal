<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class NewsController extends Controller {
    // public listing (with filters: category, author)
    public function index(Request $req){
        $q = News::with(['author','category'])->where('published', true);

        if ($req->filled('category')) {
            $q->whereHas('category', fn($q2)=> $q2->where('slug', $req->category));
        }
        if ($req->filled('author')) {
            $q->whereHas('author', fn($q2)=> $q2->where('id', $req->author));
        }
        if ($req->filled('search')) {
            $search = $req->search;
            $q->where(function($s) use ($search){
                $s->where('title','like',"%$search%")->orWhere('body','like',"%$search%");
            });
        }
        $perPage = $req->get('per_page', 10);
        return response()->json($q->latest()->paginate($perPage));
    }

    public function show($id){
        $news = News::with(['author','category'])->findOrFail($id);
        return response()->json($news);
    }

    // store - only admin or author
    public function store(Request $req){
        $this->authorizeAction($req->user());
        $data = $req->validate([
            'title'=>'required|string',
            'category_id'=>'required|exists:categories,id',
            'excerpt'=>'nullable|string',
            'body'=>'required|string',
            'published'=>'boolean',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($req->hasFile('image')) {
        $imagePath = $req->file('image')->store('news', 'public');
    }

        $data['user_id'] = $req->user()->id;
        $data['slug'] = Str::slug($data['title']).'-'.uniqid();
        if ($imagePath) {
            $data['image'] = $imagePath;
        }

        $news = News::create($data);
        return response()->json($news,201);
    }

    // update
    public function update(Request $req, News $news){
        // only admin or author(owner) can update
        $user = $req->user();
        if ($user->isAdmin() === false && !($user->isAuthor() && $news->user_id === $user->id)) {
            return response()->json(['message'=>'Forbidden'],403);
        }
        $data = $req->validate([
            'title'=>'sometimes|required|string',
            'category_id'=>'sometimes|required|exists:categories,id',
            'excerpt'=>'nullable|string',
            'body'=>'sometimes|required|string',
            'published'=>'boolean',
        ]);
        if(isset($data['title'])) $data['slug'] = Str::slug($data['title']).'-'.uniqid();
        $news->update($data);
        return response()->json($news);
    }

    public function destroy(Request $req, News $news){
        $user = $req->user();
        if ($user->isAdmin() === false && !($user->isAuthor() && $news->user_id === $user->id)) {
            return response()->json(['message'=>'Forbidden'],403);
        }
        $news->delete();
        return response()->json(['message'=>'deleted']);
    }

    private function authorizeAction($user){
        if(!$user) abort(401);
        if(!($user->isAdmin() || $user->isAuthor())){
            abort(403, 'Only admin or author can perform this action');
        }
    }
}
