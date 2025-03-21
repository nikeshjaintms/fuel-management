<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Permission = [
        //     'role-list',
        //     'role-create',
        //     'role-edit',
        //     'role-delete',
        //     'permission-list',
        //     'permission-create',
        //     'permission-edit',
        //     'permission-delete',
        //     'user-list',
        //     'user-create',
        //     'user-edit',
        //     'user-delete',
        //     'user-show',
        //     'fuel-filling-list',
        //     'fuel-filling-create',
        //     'fuel-filling-edit',
        //     'fuel-filling-delete',
        //     'fuel-filling-show',
        //     'customer-list',
        //     'customer-create',
        //     'customer-edit',
        //     'customer-delete',
        //     'customer-show',
        //     'driver-list',
        //     'driver-create',
        //     'driver-edit',
        //     'driver-delete',
        //     'driver-show',
        //     'fitness-list',
        //     'fitness-create',
        //     'fitness-edit',
        //     'fitness-delete',
        //     'fitness-show',
        //     'loan-list',
        //     'loan-create',
        //     'loan-edit',
        //     'loan-delete',
        //     'loan-show',
        //     'loan-payment',
        //     'maintenance-list',
        //     'maintenance-create',
        //     'maintenance-edit',
        //     'maintenance-delete',
        //     'maintenance-show',
        //     'vender-list',
        //     'vender-create',
        //     'vender-edit',
        //     'vender-delete',
        //     'vender-show',
        //     'vehicle-list',
        //     'vehicle-create',
        //     'vehicle-edit',
        //     'vehicle-delete',
        //     'vehicle-show',
        //     'policy-list',
        //     'policy-create',
        //     'policy-edit',
        //     'policy-delete',
        //     'policy-show',
        //     'rto-list',
        //     'rto-create',
        //     'rto-edit',
        //     'rto-delete',
        //     'rto-show',
        //     'puc-list',
        //     'puc-create',
        //     'puc-edit',
        //     'puc-delete',
        //     'puc-show',
        //     'owner-list',
        //     'owner-create',
        //     'owner-edit',
        //     'owner-delete',
        //     'owner-show',
        // ];

        $Permission = [
            'import-driver',
            'import-vehicle',
            'import-fuel-filling'
            'import-customer',
            

        ]


        foreach ($Permission as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
    }
}
