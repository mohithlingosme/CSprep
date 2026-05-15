<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class UserModel extends Model
{
    protected string $table = 'users';

    protected array $fillable = [
        'name',
        'email',
        'password_hash',
        'role',
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->db->selectOne(
            'SELECT * FROM users WHERE email = :email LIMIT 1',
            ['email' => $email]
        );
    }
}
