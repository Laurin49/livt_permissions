<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): Response
  {
    return Inertia::render('Admin/Posts/PostIndex', [
      'posts' => PostResource::collection(Post::all())
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): Response
  {
    $this->authorize('create', Post::class);
    return Inertia::render('Admin/Posts/Create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StorePostRequest $request): RedirectResponse
  {
    $this->authorize('create', Post::class);
    Post::create($request->validated());

    return to_route('posts.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Post $post)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Post $post): Response
  {
    $this->authorize('update', $post);
    return Inertia::render('Admin/Posts/Edit', [
      'post' => new PostResource($post)
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StorePostRequest $request, Post $post): RedirectResponse
  {
    $this->authorize('update', $post);
    $post->update($request->validated());

    return to_route('posts.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Post $post): RedirectResponse
  {
    $this->authorize('delete', $post);
    $post->delete();
    return to_route('posts.index');
  }
}
