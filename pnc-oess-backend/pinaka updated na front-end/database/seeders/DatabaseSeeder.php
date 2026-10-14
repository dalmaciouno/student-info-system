<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seedData = json_decode(file_get_contents(database_path('seeders/data/seed.json')), true);

        foreach (($seedData['users'] ?? []) as $user) {
            $password = $user['password'] ?? 'password';
            $password = in_array($password, ['password', 'password123'], true) ? 'password' : $password;

            User::firstOrCreate(
                ['username' => strtolower(trim($user['username']))],
                [
                    'id' => $user['id'],
                    'username' => strtolower(trim($user['username'])),
                    'password' => Hash::make($password),
                    'role' => $user['role'],
                    'name' => $user['name'],
                    'email' => $user['email'] ?? '',
                    'studentNumber' => $user['studentNumber'] ?? '',
                    'program' => $user['program'] ?? '',
                    'yearLevel' => $user['yearLevel'] ?? '',
                    'department' => $user['department'] ?? '',
                    'status' => $user['status'] ?? 'Active',
                    'avatar' => $user['avatar'] ?? '',
                ]
            );
        }
    }
}
