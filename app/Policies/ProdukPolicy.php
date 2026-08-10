<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Produk;

class ProdukPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role->name, ['admin', 'kasir'], true);
    }

    public function view(User $user, Produk $produk): bool
    {
        return in_array($user->role->name, ['admin', 'kasir'], true);
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, Produk $produk): bool
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, Produk $produk): bool
    {
        return $user->role->name === 'admin';
    }
}