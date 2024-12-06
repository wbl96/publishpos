<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UsersManagement extends Component
{
    use WithPagination;

    public $editingUserId;
    public $editingUserRole;
    public $search = '';

    public function mount()
    {
        $this->users = User::paginate(10);
    }

    public function refreshUsers()
    {
        $this->users = User::paginate(10);
    }

    public function updateRole($userId)
    {
        $user = User::findOrFail($userId);
        
        \DB::table('users')
            ->where('id', $userId)
            ->update(['role' => $this->editingUserRole]);
        
        $this->editingUserId = null;
        $this->editingUserRole = null;
        
        $this->refreshUsers();
        
        session()->flash('message', 'User role updated successfully.');
    }

    public function startEditing($userId, $role)
    {
        $this->editingUserId = $userId;
        $this->editingUserRole = $role;
    }

    public function render()
    {
        return view('livewire.admin.users-management', [
            'users' => User::where('name', 'like', "%{$this->search}%")
                          ->orWhere('email', 'like', "%{$this->search}%")
                          ->paginate(10)
        ]);
    }
} 