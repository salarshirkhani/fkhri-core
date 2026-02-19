# FKHRI Core (Fakhraei Core)

پلاگین مرکزی فخرایی برای وردپرس — شامل:
- ویجت‌های اختصاصی Elementor
- پست‌تایپ‌ها و متاباکس‌ها (Content Layer)
- اسنیپت‌ها (قابلیت‌های کوچک)
- پنل ادمین (در آینده)

هدف این پلاگین اینه که همه قابلیت‌های اختصاصی سایت فخرایی در یک “Core Plugin” تمیز، قابل توسعه و قابل نگهداری جمع شود.

---

## Requirements

- WordPress 6.x+
- PHP 7.4+ (پیشنهاد: 8.0+)
- Elementor (Free) فعال باشد

---

## Installation

1) پوشه پلاگین را داخل مسیر زیر قرار دهید:

`wp-content/plugins/fkhri-core/`

2) از پیشخوان وردپرس پلاگین **Fakhraei Core** را فعال کنید.

3) اگر Elementor فعال باشد، دسته‌بندی ویجت‌ها با نام **Fakhraei** در Elementor نمایش داده می‌شود.

---

## Project Structure

```
fkhri-core/
├─ assets/
│  ├─ css/
│  └─ js/
├─ includes/
│  ├─ core/
│  │  ├─ constants.php
│  │  └─ loader.php
│  ├─ elementor/
│  │  ├─ widgets/
│  │  │  ├─ class-fkhri-*.php
│  │  └─ elementor.php
│  ├─ content/
│  │  └─ content.php
│  ├─ ajax/
│  ├─ snippets/
│  └─ admin/
├─ fkhri-core.php
└─ README.md
```

### What each folder does

- `assets/`  
  فایل‌های CSS/JS مربوط به ویجت‌ها و قابلیت‌های فرانت.

- `includes/core/`  
  ثابت‌ها، مسیرها، نسخه پلاگین و Loader اصلی.

- `includes/elementor/`  
  ثبت دسته‌بندی فخرایی در Elementor، ثبت/لود ویجت‌ها و enqueue کردن assets.

- `includes/content/`  
  پست‌تایپ‌ها و متاباکس‌ها (ساختار محتوایی مستقل از المنتور).

- `includes/snippets/`  
  اسنیپت‌ها و قابلیت‌های کوچک که به مرور اضافه می‌شوند.

- `includes/admin/`  
  پنل ادمین و تنظیمات عمومی (در آینده).

---

## Elementor Widgets

ویجت‌ها داخل مسیر زیر قرار دارند:

`includes/elementor/widgets/`

ثبت ویجت‌ها و لود فایل‌ها در این فایل انجام می‌شود:

`includes/elementor/elementor.php`

### Add a new widget

1) یک فایل جدید بسازید:
`includes/elementor/widgets/class-fkhri-your-widget.php`

2) یک کلاس جدید مطابق استاندارد ویجت‌های Elementor بسازید و این موارد را پیاده کنید:
- `get_name()`
- `get_title()`
- `get_categories()` → باید `fkhri` باشد
- `get_style_depends()` / `get_script_depends()` (در صورت نیاز)
- `register_controls()`
- `render()`

3) فایل ویجت را در آرایه فایل‌های قابل لود (در `elementor.php`) اضافه کنید تا include شود.

---

## Assets (CSS/JS)

assets در `includes/elementor/elementor.php` register می‌شوند و در صورت وجود فایل با `filemtime()` version می‌خورند تا مشکل cache نداشته باشیم.

الگوی کلی:
- هر ویجت یک handle اختصاصی برای CSS و JS دارد
- ویجت در `get_style_depends()` و `get_script_depends()` همان handle را برمی‌گرداند

---

## Content Layer (Post Types + Meta Boxes)

تمام CPT و متاباکس‌ها باید داخل:

`includes/content/`

تعریف شوند.

هدف این بخش:
- داده‌ها قابل Query و قابل صفحه‌بندی باشند
- داده‌ها مستقل از المنتور ذخیره شوند (برای سئو/سرعت/توسعه)

---

## SEO Notes (Pagination / Ajax Widgets)

برای ویجت‌هایی که صفحه‌بندی یا Ajax دارند:
- Next/Prev باید لینک واقعی (`href`) داشته باشند (Progressive Enhancement)
- اگر JS خاموش/خراب شد، کاربر با کلیک به صفحه واقعی منتقل شود
- در صورت نیاز `rel="prev/next"` در `<head>` خروجی داده شود
- در حالت Ajax فقط Grid داخل ویجت آپدیت شود و URL با `pushState` تغییر کند

---

## Development

### Debug mode

در `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

لاگ‌ها:
`wp-content/debug.log`

### Conventions

- Prefix: `fkhri_`
- Handle assets: `fkhri-*`
- کلاس‌ها: `Fkhri_*`
- استفاده از `sanitize_*` برای ورودی و `esc_*` برای خروجی
- کامنت‌ها انگلیسی کوتاه و واضح

---

## Troubleshooting

### Widgets not visible in Elementor
- Elementor فعال باشد
- فایل `includes/elementor/elementor.php` توسط loader include شده باشد
- خطاها را در `debug.log` بررسی کنید

### CSS/JS loads but styles not applied
- handleهای `get_style_depends()` و `get_script_depends()` با handleهای register شده یکی باشند
- مسیر فایل در `assets/css` و `assets/js` درست باشد
- کش مرورگر / Cloudflare را پاک کنید

---

## Roadmap

- [ ] تکمیل پست‌تایپ‌ها و متاباکس‌ها برای portfolio
- [ ] استانداردسازی ویجت Testimonials (Schema + pagination + modal)
- [ ] اضافه شدن مدیریت اسنیپت‌ها (فعال/غیرفعال)
- [ ] اضافه شدن پنل ادمین برای تنظیمات عمومی فخرایی
- [ ] آماده‌سازی پوشه `languages/`

---

## Author

Salar Shirkhani
