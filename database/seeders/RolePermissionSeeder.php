<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // مسح الكاش لو حابب يكون كل شيء نضيف (اختياري)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1) إنشاء الصلاحيات
        $permissions = [
            'manage products',   // إدارة المنتجات
            'manage companies',  // إدارة الشركات
            'manage invoices',   // إدارة الفواتير
            'manage customers',  // إدارة الزبائن
            'view products',     // استعراض المنتجات
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 2) إنشاء الأدوار
        $adminRole    = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $customerRole = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // 3) إعطاء كل الصلاحيات للـ admin (سوبر أدمن)
        $adminRole->givePermissionTo(Permission::all());

        // 4) إعطاء صلاحية استعراض المنتجات فقط للزبون
        $customerRole->givePermissionTo('view products');

        // 5) إنشاء مستخدم أدمن وربطه بالرول (اختياري بس مفيد)
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('123456'),
            ]
        );

        if (! $admin->hasRole($adminRole->name)) {
            $admin->assignRole($adminRole);
        }

        // لو حابب كمان تعمل زبون تجريبي
        // $customer = User::firstOrCreate(
        //     ['email' => 'customer@demo.com'],
        //     [
        //         'name'     => 'Customer Demo',
        //         'password' => Hash::make('123456'),
        //     ]
        // );
        //
        // if (! $customer->hasRole($customerRole->name)) {
        //     $customer->assignRole($customerRole);
        // }
    }
}
