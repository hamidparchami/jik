<?php

use App\Role;
use App\Url;
use App\User;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * create administrator role
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $url_ids = [];
            $urls = Url::all(['id'])->toArray();
            foreach ($urls as $url) {
                $url_ids[] = $url['id'];
            }

            $role = Role::create(['name' => 'Administrator']);
            $role->urls()->sync($url_ids);

            $user = User::first();
            $user->update(['role_id' => $role->id, 'is_active' => 1]);
        });
    }
}
