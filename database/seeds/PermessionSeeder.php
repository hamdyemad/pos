<?php

use App\Models\Permession;
use Illuminate\Database\Seeder;

class PermessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permessions = [
            // Settings
            [
                'name' => 'الأعدادات العامة',
                'key' => 'settings.edit',
                'group_by' => 'الأعدادات العامة'
            ],
            // Bussinses
            [
                'name' => 'كل المعاملات المالية',
                'key' => 'business.index',
                'group_by' => 'المعاملات المالية'
            ],
            [
                'name' => 'الأيرادات والمصروفات',
                'key' => 'business.all',
                'group_by' => 'المعاملات المالية'
            ],
            [
                'name' => 'تعديل المعاملات المالية',
                'key' => 'business.edit',
                'group_by' => 'المعاملات المالية'
            ],
            [
                'name' => 'انشاء المعاملات المالية',
                'key' => 'business.create',
                'group_by' => 'المعاملات المالية'
            ],
            [
                'name' => 'ازالة المعاملات المالية',
                'key' => 'business.destroy',
                'group_by' => 'المعاملات المالية'
            ],
            [
                'name' => 'العملات',
                'key' => 'currencies.index',
                'group_by' => 'المعاملات المالية'
            ],

            // Expenses
            [
                'name' => 'كل الأيرادات والمصروفات',
                'key' => 'expenses.index',
                'group_by' => 'الأيرادات والمصروفات'
            ],
            [
                'name' => 'انشاء الأيرادات والمصروفات',
                'key' => 'expenses.create',
                'group_by' => 'الأيرادات والمصروفات'
            ],
            [
                'name' => 'تعديل الأيرادات والمصروفات',
                'key' => 'expenses.edit',
                'group_by' => 'الأيرادات والمصروفات'
            ],
            [
                'name' => 'ازالة الأيرادات والمصروفات',
                'key' => 'expenses.destroy',
                'group_by' => 'الأيرادات والمصروفات'
            ],

            // Branches
            [
                'name' => 'كل الفروع',
                'key' => 'branches.index',
                'group_by' => 'الفروع'
            ],
            [
                'name' => 'انشاء فرع',
                'key' => 'branches.create',
                'group_by' => 'الفروع'
            ],
            [
                'name' => 'تعديل الفرع',
                'key' => 'branches.edit',
                'group_by' => 'الفروع'
            ],
            [
                'name' => 'ازالة الفرع',
                'key' => 'branches.destroy',
                'group_by' => 'الفروع'
            ],

            // Categories
            [
                'name' => 'كل الاصناف',
                'key' => 'categories.index',
                'group_by' => 'الأصناف'
            ],
            [
                'name' => 'انشاء الاصناف',
                'key' => 'categories.create',
                'group_by' => 'الأصناف'
            ],
            [
                'name' => 'اظهار الاصناف',
                'key' => 'categories.show',
                'group_by' => 'الأصناف'
            ],
            [
                'name' => 'تعديل الاصناف',
                'key' => 'categories.edit',
                'group_by' => 'الأصناف'
            ],
            [
                'name' => 'ازالة الاصناف',
                'key' => 'categories.destroy',
                'group_by' => 'الأصناف'
            ],


            // Products
            [
                'name' => 'كل الأكلات',
                'key' => 'products.index',
                'group_by' => 'الأكلات'
            ],
            [
                'name' => 'انشاء الأكلات',
                'key' => 'products.create',
                'group_by' => 'الأكلات'
            ],
            [
                'name' => 'اظهار الأكلات',
                'key' => 'products.show',
                'group_by' => 'الأكلات'
            ],
            [
                'name' => 'تعديل الأكلات',
                'key' => 'products.edit',
                'group_by' => 'الأكلات'
            ],
            [
                'name' => 'ازالة الأكلات',
                'key' => 'products.destroy',
                'group_by' => 'الأكلات'
            ],


            // Countries And Shippings
            [
                'name' => 'كل الشحن والدول',
                'key' => 'countries.index',
                'group_by' => 'الشحن والدول'
            ],
            [
                'name' => 'انشاء الشحن والدول',
                'key' => 'countries.create',
                'group_by' => 'الشحن والدول'
            ],
            [
                'name' => 'تعديل الشحن والدول',
                'key' => 'countries.edit',
                'group_by' => 'الشحن والدول'
            ],
            [
                'name' => 'ازالة الشحن والدول',
                'key' => 'countries.destroy',
                'group_by' => 'الشحن والدول'
            ],


            // Users
            [
                'name' => 'كل المستخدمين',
                'key' => 'users.index',
                'group_by' => 'المستخدمين'
            ],
            [
                'name' => 'انشاء المستخدمين',
                'key' => 'users.create',
                'group_by' => 'المستخدمين'
            ],
            [
                'name' => 'تعديل المستخدمين',
                'key' => 'users.edit',
                'group_by' => 'المستخدمين'
            ],
            [
                'name' => 'ازالة المستخدمين',
                'key' => 'users.destroy',
                'group_by' => 'المستخدمين'
            ],

            // Roles
            [
                'name' => 'كل الصلاحيات',
                'key' => 'roles.index',
                'group_by' => 'الصلاحيات'
            ],
            [
                'name' => 'انشاء الصلاحيات',
                'key' => 'roles.create',
                'group_by' => 'الصلاحيات'
            ],
            [
                'name' => 'تعديل الصلاحيات',
                'key' => 'roles.edit',
                'group_by' => 'الصلاحيات'
            ],
            [
                'name' => 'ازالة الصلاحيات',
                'key' => 'roles.destroy',
                'group_by' => 'الصلاحيات'
            ],

            // Orders
            [
                'name' => 'كل الطلبات',
                'key' => 'orders.index',
                'group_by' => 'الطلبات'
            ],
            [
                'name' => 'ظهور الطلب',
                'key' => 'orders.show',
                'group_by' => 'الطلبات'
            ],
            [
                'name' => 'انشاء الطلبات',
                'key' => 'orders.create',
                'group_by' => 'الطلبات'
            ],
            [
                'name' => 'تعديل الطلبات',
                'key' => 'orders.edit',
                'group_by' => 'الطلبات'
            ],
            [
                'name' => 'ازالة الطلبات',
                'key' => 'orders.destroy',
                'group_by' => 'الطلبات'
            ],

            // Statuses
            [
                'name' => 'كل الحالات',
                'key' => 'statuses.index',
                'group_by' => 'حالات الطلبات'
            ],
            [
                'name' => 'انشاء حالة الطلبات',
                'key' => 'statuses.create',
                'group_by' => 'حالات الطلبات'
            ],
            [
                'name' => 'تعديل حالة الطلبات',
                'key' => 'statuses.edit',
                'group_by' => 'حالات الطلبات'
            ],
            [
                'name' => 'ازالة حالة الطلبات',
                'key' => 'statuses.destroy',
                'group_by' => 'حالات الطلبات'
            ],

            // Languages
            [
                'name' => 'كل اللغات',
                'key' => 'languages.index',
                'group_by' => 'اللغات'
            ],
            [
                'name' => 'انشاء لغة',
                'key' => 'languages.create',
                'group_by' => 'اللغات'
            ],
            [
                'name' => 'ازالة لغة',
                'key' => 'languages.destroy',
                'group_by' => 'اللغات'
            ],
        ];
        Permession::insert($permessions);
    }
}
