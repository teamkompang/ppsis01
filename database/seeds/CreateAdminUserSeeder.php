<?php
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
    public function run()
    {
        $user = User::create([
            'username' => 'Admin',
            'fullname' => 'Muhamad Hanis Firdaus',
            'email' => 'jigsnoob@gmail.com',
            'password' => bcrypt('asd123456'), 
            'company' =>  'PUNB',
            'contact' =>  '01133426207',
            'role' =>  '1',
            'status' =>   '1',
            'user_lastmaintain' =>  'Muhamad Hanis Firdaus',

        ]);

        $role = Role::create(['name' => 'Admin']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
       
    }
}