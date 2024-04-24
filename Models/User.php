<?php


namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'mobile',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function user_role()
    {
        return $this->hasOne(UserRole::class);
    }

    public function canRead(Request $request)
    {
        $menuId = $request->input('menu_id'); // Assuming menu_id is available in the request

        // Get the user's role ID from the pivot table
        $roleId = $this->userRole->role_id;

        // Check if any permission associated with the user's role has read permission for the specified menu
        return Permission::where('role_id', $roleId)
            ->where('menu_id', $menuId)
            ->where('read', 'yes')
            ->exists();
    }
}
