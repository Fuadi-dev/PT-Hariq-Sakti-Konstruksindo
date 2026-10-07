<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
    public function view(User $user, $model) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
    public function create(User $user) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
    public function update(User $user, $model) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
    public function delete(User $user, $model) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
    public function deleteAny(User $user) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
    public function restore(User $user, $model) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
    public function forceDelete(User $user, $model) { return in_array($user->role, ['superadmin', 'admin', 'writer']); }
}