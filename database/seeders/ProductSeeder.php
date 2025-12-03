<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'إلكترونيات', 'description' => 'أجهزة إلكترونية ومعدات', 'is_active' => true],
            ['name' => 'أثاث', 'description' => 'أثاث منزلي ومكتبي', 'is_active' => true],
            ['name' => 'ملابس', 'description' => 'ملابس رجالية ونسائية', 'is_active' => true],
            ['name' => 'أدوات منزلية', 'description' => 'أدوات ومستلزمات منزلية', 'is_active' => true],
            ['name' => 'كتب', 'description' => 'كتب ومجلات', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Companies
        $companies = [
            ['name' => 'شركة التقنية المتقدمة', 'contact_name' => 'أحمد محمد', 'phone' => '0501234567', 'email' => 'info@tech.com', 'address' => 'الرياض', 'is_active' => true],
            ['name' => 'مؤسسة الأثاث الحديث', 'contact_name' => 'خالد علي', 'phone' => '0507654321', 'email' => 'sales@furniture.com', 'address' => 'جدة', 'is_active' => true],
            ['name' => 'شركة الموضة العصرية', 'contact_name' => 'سارة أحمد', 'phone' => '0509876543', 'email' => 'contact@fashion.com', 'address' => 'الدمام', 'is_active' => true],
            ['name' => 'مؤسسة المنزل السعيد', 'contact_name' => 'محمد عبدالله', 'phone' => '0503456789', 'email' => 'info@home.com', 'address' => 'مكة', 'is_active' => true],
            ['name' => 'دار المعرفة للنشر', 'contact_name' => 'فاطمة حسن', 'phone' => '0506543210', 'email' => 'books@knowledge.com', 'address' => 'المدينة', 'is_active' => true],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }

        // Create Products
        $products = [
            // Electronics
            ['category_id' => 1, 'company_id' => 1, 'name' => 'لابتوب Dell XPS 15', 'sku' => 'DELL-XPS-001', 'description' => 'لابتوب عالي الأداء للمحترفين', 'purchase_price' => 4500, 'sale_price' => 5500, 'stock' => 15, 'reorder_level' => 5, 'is_active' => true],
            ['category_id' => 1, 'company_id' => 1, 'name' => 'ماوس لاسلكي Logitech', 'sku' => 'LOG-MOUSE-002', 'description' => 'ماوس لاسلكي مريح', 'purchase_price' => 80, 'sale_price' => 120, 'stock' => 50, 'reorder_level' => 10, 'is_active' => true],
            ['category_id' => 1, 'company_id' => 1, 'name' => 'لوحة مفاتيح ميكانيكية', 'sku' => 'KEY-MECH-003', 'description' => 'لوحة مفاتيح ميكانيكية RGB', 'purchase_price' => 250, 'sale_price' => 350, 'stock' => 30, 'reorder_level' => 8, 'is_active' => true],
            ['category_id' => 1, 'company_id' => 1, 'name' => 'شاشة Samsung 27 بوصة', 'sku' => 'SAM-MON-004', 'description' => 'شاشة 4K للألعاب والتصميم', 'purchase_price' => 1200, 'sale_price' => 1600, 'stock' => 20, 'reorder_level' => 5, 'is_active' => true],
            
            // Furniture
            ['category_id' => 2, 'company_id' => 2, 'name' => 'كرسي مكتب جلد', 'sku' => 'CHAIR-OFF-005', 'description' => 'كرسي مكتب مريح من الجلد الطبيعي', 'purchase_price' => 600, 'sale_price' => 850, 'stock' => 25, 'reorder_level' => 5, 'is_active' => true],
            ['category_id' => 2, 'company_id' => 2, 'name' => 'مكتب خشبي كلاسيكي', 'sku' => 'DESK-WOOD-006', 'description' => 'مكتب خشبي فاخر', 'purchase_price' => 1500, 'sale_price' => 2200, 'stock' => 12, 'reorder_level' => 3, 'is_active' => true],
            ['category_id' => 2, 'company_id' => 2, 'name' => 'خزانة ملابس 3 أبواب', 'sku' => 'WARD-3DR-007', 'description' => 'خزانة ملابس واسعة', 'purchase_price' => 2000, 'sale_price' => 2800, 'stock' => 8, 'reorder_level' => 2, 'is_active' => true],
            
            // Clothes
            ['category_id' => 3, 'company_id' => 3, 'name' => 'قميص رجالي قطن', 'sku' => 'SHIRT-MEN-008', 'description' => 'قميص رجالي قطن 100%', 'purchase_price' => 80, 'sale_price' => 150, 'stock' => 100, 'reorder_level' => 20, 'is_active' => true],
            ['category_id' => 3, 'company_id' => 3, 'name' => 'بنطلون جينز', 'sku' => 'JEANS-009', 'description' => 'بنطلون جينز عصري', 'purchase_price' => 120, 'sale_price' => 200, 'stock' => 80, 'reorder_level' => 15, 'is_active' => true],
            ['category_id' => 3, 'company_id' => 3, 'name' => 'فستان نسائي أنيق', 'sku' => 'DRESS-WOM-010', 'description' => 'فستان نسائي للمناسبات', 'purchase_price' => 200, 'sale_price' => 350, 'stock' => 45, 'reorder_level' => 10, 'is_active' => true],
            
            // Home Items
            ['category_id' => 4, 'company_id' => 4, 'name' => 'طقم أواني طبخ', 'sku' => 'COOK-SET-011', 'description' => 'طقم أواني طبخ 12 قطعة', 'purchase_price' => 300, 'sale_price' => 450, 'stock' => 35, 'reorder_level' => 8, 'is_active' => true],
            ['category_id' => 4, 'company_id' => 4, 'name' => 'مكنسة كهربائية', 'sku' => 'VAC-CLEAN-012', 'description' => 'مكنسة كهربائية قوية', 'purchase_price' => 400, 'sale_price' => 600, 'stock' => 22, 'reorder_level' => 5, 'is_active' => true],
            ['category_id' => 4, 'company_id' => 4, 'name' => 'طقم مفارش سرير', 'sku' => 'BED-SHEET-013', 'description' => 'طقم مفارش قطن فاخر', 'purchase_price' => 150, 'sale_price' => 250, 'stock' => 60, 'reorder_level' => 12, 'is_active' => true],
            
            // Books
            ['category_id' => 5, 'company_id' => 5, 'name' => 'كتاب البرمجة بلغة Python', 'sku' => 'BOOK-PY-014', 'description' => 'دليل شامل لتعلم Python', 'purchase_price' => 60, 'sale_price' => 100, 'stock' => 75, 'reorder_level' => 15, 'is_active' => true],
            ['category_id' => 5, 'company_id' => 5, 'name' => 'رواية الأجنحة المتكسرة', 'sku' => 'BOOK-NOV-015', 'description' => 'رواية كلاسيكية لجبران خليل جبران', 'purchase_price' => 30, 'sale_price' => 55, 'stock' => 90, 'reorder_level' => 20, 'is_active' => true],
            ['category_id' => 5, 'company_id' => 5, 'name' => 'كتاب إدارة الأعمال', 'sku' => 'BOOK-BUS-016', 'description' => 'أساسيات إدارة الأعمال الحديثة', 'purchase_price' => 80, 'sale_price' => 130, 'stock' => 55, 'reorder_level' => 10, 'is_active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
