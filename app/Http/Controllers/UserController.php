<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): Response
  {
    $users = UserResource::collection(User::all());
    return Inertia::render('Admin/Users/UserIndex', [
      'users' => $users
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): Response
  {
    return Inertia::render('Admin/Users/Create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:' . User::class,
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);
    return to_route('users.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  public function edit(User $user): Response
  {
    return Inertia::render('Admin/Users/Edit', [
      'user' => new UserResource($user),
    ]);
  }

  public function update(Request $request, User $user): RedirectResponse
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|' . Rule::unique('users', 'email')->ignore($user),
    ]);

    $user->update([
      'name' => $request->name,
      'email' => $request->email
    ]);

    return to_route('users.index');
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user): RedirectResponse
  {
    $user->delete();
    return to_route('users.index');
  }
}
