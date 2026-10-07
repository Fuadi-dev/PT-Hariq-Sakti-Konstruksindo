<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user) { return $user->role === 'superadmin'; }
    public function view(User $user, $model) { return $user->role === 'superadmin'; }
    public function create(User $user) { return $user->role === 'superadmin'; }
    public function update(User $user, $model) { return $user->role === 'superadmin'; }
    public function delete(User $user, $model) { return $user->role === 'superadmin'; }
    public function deleteAny(User $user) { return $user->role === 'superadmin'; }
    public function restore(User $user, $model) { return $user->role === 'superadmin'; }
    public function forceDelete(User $user, $model) { return $user->role === 'superadmin'; }
}