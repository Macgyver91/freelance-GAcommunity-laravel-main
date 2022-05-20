<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleUserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create_events']);
        Permission::create(['name' => 'edit_events']);
        Permission::create(['name' => 'delete_events']);

        Permission::create(['name' => 'create_users']);
        Permission::create(['name' => 'edit_users']);
        Permission::create(['name' => 'delete_users']);

        Permission::create(['name' => 'create_membres']);
        Permission::create(['name' => 'edit_membres']);
        Permission::create(['name' => 'delete_membres']);

        Permission::create(['name' => 'create_staffs']);
        Permission::create(['name' => 'edit_staffs']);
        Permission::create(['name' => 'delete_staffs']);

        Permission::create(['name' => 'create_roles']);
        Permission::create(['name' => 'edit_roles']);
        Permission::create(['name' => 'delete_roles']);

        Permission::create(['name' => 'create_ggs']);
        Permission::create(['name' => 'edit_ggs']);
        Permission::create(['name' => 'delete_ggs']);

        Permission::create(['name' => 'create_pgs']);
        Permission::create(['name' => 'edit_pgs']);
        Permission::create(['name' => 'delete_pgs']);

        Permission::create(['name' => 'create_abandons']);
        Permission::create(['name' => 'edit_abandons']);
        Permission::create(['name' => 'delete_abandons']);

        Permission::create(['name' => 'event_management']); // attach or remove grand groupe, staff from event
        Permission::create(['name' => 'participant_event']); // add or remove membre to event
        Permission::create(['name' => 'membre_staff']); // add or remove membre to staff
        Permission::create(['name' => 'membre_petit_groupe']); // add or remove membre to petit groupe


        // create roles and assign created permissions

        // this can be done as separate statements
        // $role1 = Role::create(['name' => 'SUPER_ADMIN']);
        Role::create(['name' => 'SUPER_ADMIN']);

        // Define role and permission for Admin
        $role2 = Role::create(['name' => 'ADMIN']);
        $role2->givePermissionTo('create_users');
        $role2->givePermissionTo('create_membres');
        $role2->givePermissionTo('edit_membres');
        $role2->givePermissionTo('delete_membres');
        $role2->givePermissionTo('create_staffs');
        $role2->givePermissionTo('edit_staffs');
        $role2->givePermissionTo('delete_staffs');

        $role2->givePermissionTo('create_ggs');
        $role2->givePermissionTo('edit_ggs');
        $role2->givePermissionTo('delete_ggs');
        $role2->givePermissionTo('create_pgs');
        $role2->givePermissionTo('edit_pgs');
        $role2->givePermissionTo('delete_pgs');
        $role2->givePermissionTo('create_abandons');
        $role2->givePermissionTo('edit_abandons');
        $role2->givePermissionTo('delete_abandons');

        $role2->givePermissionTo('create_events');
        $role2->givePermissionTo('edit_events');
        $role2->givePermissionTo('delete_events');

        $role2->givePermissionTo('event_management');
        $role2->givePermissionTo('participant_event');
        $role2->givePermissionTo('membre_staff');
        $role2->givePermissionTo('membre_petit_groupe');

        // Define role and permission for directeur de centre
        $role3 = Role::create(['name' => 'DIRECTEUR_DE_CENTRE']);
        $role3->givePermissionTo('create_membres');
        $role3->givePermissionTo('edit_membres');
        $role3->givePermissionTo('delete_membres');
        $role3->givePermissionTo('create_staffs');
        $role3->givePermissionTo('edit_staffs');
        $role3->givePermissionTo('delete_staffs');

        $role3->givePermissionTo('create_ggs');
        $role3->givePermissionTo('edit_ggs');
        $role3->givePermissionTo('delete_ggs');
        $role3->givePermissionTo('create_pgs');
        $role3->givePermissionTo('edit_pgs');
        $role3->givePermissionTo('delete_pgs');
        $role3->givePermissionTo('create_abandons');
        $role3->givePermissionTo('edit_abandons');
        $role3->givePermissionTo('delete_abandons');
        $role3->givePermissionTo('create_events');
        $role3->givePermissionTo('edit_events');
        $role3->givePermissionTo('delete_events');
        $role3->givePermissionTo('event_management');
        $role3->givePermissionTo('participant_event');
        $role3->givePermissionTo('membre_staff');
        $role3->givePermissionTo('membre_petit_groupe');

        // Define role and permission for coordinateur
        // $role4 = Role::create(['name' => 'COORDINATEUR']);
        Role::create(['name' => 'COORDINATEUR']);

        // Define role and permission for coach
        // $role5 = Role::create(['name' => 'COACH']);
        Role::create(['name' => 'COACH']);


        // Assign roles to demo users
        $superadmin = User::find(1);

        $superadmin->assignRole('SUPER_ADMIN');
    }
}