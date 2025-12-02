# نظام إدارة المخزون

نظام متكامل لإدارة المخزون مبني باستخدام Laravel 12 + Livewire 3 + Tailwind CSS

## المميزات

### لوحة الإدارة (Admin)
- ✅ إدارة المنتجات، الأصناف، والشركات
- ✅ إدارة المستخدمين (إنشاء حسابات وتعيين الأدوار)
- ✅ استلام الطلبات من المستخدمين مع الموافقة/الرفض
- ✅ إدارة فواتير الشراء والمبيعات
- ✅ إدارة الزبائن
- ✅ لوحة تحكم بالإحصائيات

### واجهة المستخدم (Client)
- ✅ عرض المنتجات والشركات
- ✅ البحث والفلترة
- ✅ إضافة منتجات للسلة
- ✅ إرسال الطلبات للموافقة

## التثبيت

### 1. تثبيت المتطلبات
```bash
composer install
npm install
```

### 2. إعداد قاعدة البيانات
```bash
# نسخ ملف البيئة
copy .env.example .env

# توليد مفتاح التطبيق
php artisan key:generate

# تشغيل الـ migrations
php artisan migrate

# تشغيل الـ seeders لإنشاء المستخدمين الافتراضيين
php artisan db:seed
```

### 3. تشغيل التطبيق
```bash
# تشغيل Laravel
php artisan serve

# في نافذة أخرى: تشغيل Vite
npm run dev
```

## بيانات الدخول الافتراضية

### حساب المدير (Admin)
- **البريد الإلكتروني:** admin@admin.com
- **كلمة المرور:** password

### حساب الزبون (Customer)
- **البريد الإلكتروني:** customer@test.com
- **كلمة المرور:** password

## الهيكل

### Models
- `User` - المستخدمين (admin/customer)
- `Product` - المنتجات
- `Category` - الأصناف
- `Company` - الشركات
- `Customer` - الزبائن
- `Cart` - السلة
- `CartItem` - عناصر السلة
- `SalesInvoice` - فواتير المبيعات
- `PurchaseInvoice` - فواتير الشراء

### Routes
- `/login` - تسجيل الدخول
- `/admin/*` - لوحة الإدارة (محمية بـ admin middleware)
- `/client/*` - واجهة المستخدم

## الأمان

- نظام المصادقة مبني على Laravel Authentication
- حماية صفحات الإدارة بـ Middleware
- التحقق من الأدوار (Admin/Customer)
- Hash لكلمات المرور

## التقنيات المستخدمة

- **Backend:** Laravel 12
- **Frontend:** Livewire 3
- **Styling:** Tailwind CSS
- **Database:** MySQL/SQLite
- **Icons:** Heroicons

## الترخيص

MIT License
