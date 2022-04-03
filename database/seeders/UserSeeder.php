<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create(['name' => "User One", 'email' => 'userone@crankd.nz', 'password' => bcrypt('password')]);
        $user2 = User::create(['name' => "User One", 'email' => 'usertwo@crankd.nz', 'password' => bcrypt('password')]);

        $user->roles()->sync($roles);
        $user->companies()->attach($companies);

        foreach ($permissions as $permission) {
            $user->permissions()->attach($permission);
        }

        return true;
        // Insert Permissions
        $permissions = [
            'create_post',
            'delete_post',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Inset Roles
        $permissions = Permission::pluck('id')->all();

        $roles = ['Admin', 'Employee'];
        foreach ($roles as $role) {
            $role = Role::create(['name' => $role]);
            $role->permissions()->attach($permissions);
        }

        $companies = [
            "Crank'd Media",
            "Company One",
            'Company Two',
        ];
        foreach ($companies as $companyData) {
            $company = Company::create(['name' => $companyData]);
        }

        foreach ($demo_users as $key => $demo_user) {

            $roles = $demo_user['roles'];
            unset($demo_user['roles']);

            $companies = $demo_user['companies'];
            unset($demo_user['companies']);

            $permissions = $demo_user['permissions'];
            unset($demo_user['permissions']);

            $user = User::create($demo_user);
            $user->roles()->sync($roles);
            $user->companies()->attach($companies);

            foreach ($permissions as $permission) {
                $user->permissions()->attach($permission);
            }
        }

    }
}