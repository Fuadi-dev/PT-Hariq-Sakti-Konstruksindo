<?php

namespace App\Policies;

use App\Models\User;

class ProjectImagePolicy
{
    public function viewAny(User $user) { return in_array($user->role, ['superadmin', 'admin']); }
    public function view(User $user, $model) { return in_array($user->role, ['superadmin', 'admin']); }
    public function create(User $user) { return in_array($user->role, ['superadmin', 'admin']); }
    public function update(User $user, $model) { return in_array($user->role, ['superadmin', 'admin']); }
    public function delete(User $user, $model) { return in_array($user->role, ['superadmin', 'admin']); }
    public function deleteAny(User $user) { return in_array($user->role, ['superadmin', 'admin']); }
    public function restore(User $user, $model) { return in_array($user->role, ['superadmin', 'admin']); }
    public function forceDelete(User $user, $model) { return in_array($user->role, ['superadmin', 'admin']); }
}