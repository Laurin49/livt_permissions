<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): Response
  {
    return Inertia::render('Admin/Roles/RoleIndex', [
      'roles' => RoleResource::collection(Role::all())
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): Response
  {
    return Inertia::render('Admin/Roles/Create', [
      'permissions' => PermissionResource::collection(Permission::all())
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreRoleRequest $request)
  {
    $role = Role::create(['name' => $request->name]);
    if ($request->has('permissions')) {
      $role->syncPermissions($request->input('permissions.*.name'));
    }
    return to_route('roles.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Role $role)
  {
    $role->load('permissions');

    return Inertia::render('Admin/Roles/Edit', [
      'role' => new RoleResource($role),
      'permissions' => PermissionResource::collection(Permission::all())
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StoreRoleRequest $request, Role $role): RedirectResponse
  {
    $role->update([
      'name' => $request->name
    ]);
    $role->syncPermissions($request->input('permissions.*.name'));
    return back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Role $role)
  {
    $role->delete();
    return to_route('roles.index');
  }
}
