<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            // إدارة الفواتير
            'manage invoices',
            'manage sales invoices',
            'manage purchase invoices',

            // إدارة المنتجات
            'manage products',

            // إدارة الأصناف
            'manage categories',

            // إدارة الشركات
            'manage companies',

            // إدارة المستخدمين
            'manage users',

            // الإعدادات
            'manage settings',

            // صلاحيات الزبون
            'view products',     // استعراض المنتجات
            'view catalog',      // استعراض الكتالوج
            'add to cart',       // إضافة للسلة
            'manage cart',       // إدارة السلة
            'place order',       // تقديم الطلب
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 2) إنشاء الأدوار
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $customerRole = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // 3) إعطاء كل الصلاحيات للـ admin (سوبر أدمن)
        $adminRole->givePermissionTo(Permission::all());

        // 4) إعطاء صلاحيات الزبون
        $customerPermissions = [
            'view products',
            'view catalog',
            'add to cart',
            'manage cart',
            'place order',
        ];
        $customerRole->givePermissionTo($customerPermissions);

        // 5) إنشاء مستخدم أدمن وربطه بالرول (اختياري بس مفيد)
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
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
