<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class PostController extends Controller
{
    // Fetch all posts with their associated user and comments
    public function index()
    {
        $posts = Post::with('user')->withCount('like')->with('comments')->latest()->get();
        return response()->json($posts);
        // $posts = Post::with(['user', 'comments'])->latest()->get();
        // return response()->json($posts);
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post = Post::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return response()->json($post, 201);
    }

    public function toggleLike(Post $post)
    {
        // Check if the user has already liked the post
        $like = Like::where('user_id', auth()->id())->where('post_id', $post->id)->first();

        if ($like) {
            // If already liked, delete the like (unlike)
            $like->delete();
            $post->like_count--;
            $post->save();

            return response()->json(['message' => 'Post unliked', 'liked' => false, 'like_count' => $post->like_count]);
        } else {
            // If not liked yet, add a like
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            $post->like_count++;
            $post->save();

            return response()->json(['message' => 'Post liked', 'liked' => true, 'like_count' => $post->like_count]);
        }
    }
    // Add a comment to a post
    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return response()->json($comment, 201);
    }

     // Update a post
     public function update(Request $request, Post $post)
     {
         // Check if user is authorized to edit this post
         if ($post->user_id !== auth()->id()) {
             return response()->json(['message' => 'Unauthorized'], 403);
         }
 
         $request->validate([
             'content' => 'required',
         ]);
 
         $post->update([
             'content' => $request->content
         ]);
 
         return response()->json($post);
     }
 
     // Delete a post
     public function destroy(Post $post)
     {
         // Check if user is authorized to delete this post
         if ($post->user_id !== auth()->id()) {
             return response()->json(['message' => 'Unauthorized'], 403);
         }
 
         // Delete associated comments and likes first
         $post->comments()->delete();
         $post->likes()->delete();
         $post->delete();
 
         return response()->json(['message' => 'Post deleted successfully']);
     }
 
     // Delete a comment
     public function deleteComment(Post $post, Comment $comment)
     {
         // Check if user is authorized to delete this comment
         if ($comment->user_id !== auth()->id()) {
             return response()->json(['message' => 'Unauthorized'], 403);
         }
 
         $comment->delete();
         return response()->json(['message' => 'Comment deleted successfully']);
     }
}
