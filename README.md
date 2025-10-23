# 🚀 Laravel Verifactu - Sistema de facturación electrónica

**Paquete Laravel 10/11/12 para gestión y registro de facturación electrónica VeriFactu**


<p align="center">
<a href="https://scrutinizer-ci.com/g/mmbuxan/LaravelVerifactu/"><img src="https://scrutinizer-ci.com/g/mmbuxan/LaravelVerifactu/badges/quality-score.png?b=master" alt="Quality Score"></a>
<a href="https://scrutinizer-ci.com/g/mmbuxan/LaravelVerifactu/"><img src="https://scrutinizer-ci.com/g/mmbuxan/LaravelVerifactu/badges/code-intelligence.svg?b=master" alt="Code Intelligence"></a>
<a href="https://packagist.org/packages/mmbuxan/laravel-verifactu"><img class="latest_stable_version_img" src="https://poser.pugx.org/mmbuxan/laravel-verifactu/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/mmbuxan/laravel-verifactu"><img class="total_img" src="https://poser.pugx.org/mmbuxan/laravel-verifactu/downloads" alt="Total Downloads"></a> 
<a href="https://packagist.org/packages/mmbuxan/laravel-verifactu"><img class="license_img" src="https://poser.pugx.org/mmbuxan/laravel-verifactu/license" alt="License"></a>
</p>

[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/aichadigital/lara-verifactu/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/aichadigital/lara-verifactu/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/aichadigital/lara-verifactu/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/aichadigital/lara-verifactu/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)

---

## ✨ Características principales

- 📄 Modelos Eloquent para invoices, breakdowns y recipients
- 🏷️ Enum types para campos fiscales (invoice type, tax type, regime, etc.)
- 🛠️ Helpers para operaciones de fecha, string y hash
- 🏛️ Servicio AEAT client (configurable e inyectable)
- ✅ Form Requests para validación
- 🔄 API Resources para respuestas RESTful
- 🧪 Factories y tests unitarios para todos los componentes core
- 🔌 Listo para extensión y uso en producción

<!-- ---

## 📦 Instalación

```bash
composer require mmbuxan/laravel-verifactu
```

Publica la configuración y migraciones:

```bash
php artisan vendor:publish --provider="MMBuxan\VeriFactu\Providers\VeriFactuServiceProvider"
php artisan migrate
``` -->

---

## 🚀 Instalación (Desarrollo Local)

> **⚠️ IMPORTANTE**: Este paquete **NO está publicado en Packagist**. Solo se puede instalar desde el repositorio local para desarrollo y testing.

### Opción 1: Path Repository (Recomendado)

1. **Clona el repositorio en tu workspace local:**

```bash
cd ~/development/packages
git clone https://github.com/githubmmbuxan/LaravelVerifactu.git
cd LaravelVerifactu
composer install
```

2. **En tu proyecto Laravel, añade el repositorio local en `composer.json`:**

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../../development/packages/LaravelVerifactu",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
        "mmbuxan/LaravelVerifactu": "@dev"
    }
}
```

3. **Instala el paquete:**

```bash
composer update mmbuxan/LaravelVerifactu
```

Composer creará un symlink desde `vendor/mmbuxan/LaravelVerifactu` a tu repositorio local.

### Opción 2: Symlink Manual

```bash
# En tu proyecto Laravel
cd vendor
mkdir -p mmbuxan
cd mmbuxan
ln -s ~/development/packages/LaravelVerifactu LaravelVerifactu
```

### Configuración Inicial

```bash
# Publicar configuración y migraciones
php artisan verifactu:install

# Configurar certificado digital en .env
VERIFACTU_ENVIRONMENT=sandbox
VERIFACTU_CERT_PATH=./certificates/tu_certificado.p12
VERIFACTU_CERT_PASSWORD=tu_password

# Probar conexión con AEAT
php artisan verifactu:test-connection
```

---

## ⚙️ Configuración

Edita tu archivo `.env` o `config/verifactu.php` según tus necesidades:

```php
return [
    'enabled' => true,
    'default_currency' => 'EUR',
    'issuer' => [
        'name' => env('VERIFACTU_ISSUER_NAME', ''),
        'vat' => env('VERIFACTU_ISSUER_VAT', ''),
    ],
    // ...
];
```

---

## 🚀 Uso rápido

### Crear una Invoice (Ejemplo de Controller)

```php
use MMBuxan\VeriFactu\Http\Requests\StoreInvoiceRequest;
use MMBuxan\VeriFactu\Models\Invoice;
use MMBuxan\VeriFactu\Http\Resources\InvoiceResource;

public function store(StoreInvoiceRequest $request)
{
    $invoice = Invoice::create($request->validated());
    // Opcionalmente puedes asociar breakdowns y recipients
    // $invoice->breakdowns()->createMany([...]);
    // $invoice->recipients()->createMany([...]);
    return new InvoiceResource($invoice->load(['breakdowns', 'recipients']));
}
```

---

## 🧾 Ejemplos de tipos de Invoice

A continuación, ejemplos de cómo crear cada tipo de invoice usando el modelo y enums:

### Factura estándar
```php
use MMBuxan\VeriFactu\Models\Invoice;
use MMBuxan\VeriFactu\Enums\InvoiceType;

$invoice = Invoice::create([
    'number' => 'INV-STD-001',
    'date' => '2024-07-01',
    'customer_name' => 'Standard Customer',
    'customer_tax_id' => 'C12345678',
    'issuer_name' => 'Issuer S.A.',
    'issuer_tax_id' => 'B87654321',
    'amount' => 100.00,
    'tax' => 21.00,
    'total' => 121.00,
    'type' => InvoiceType::STANDARD,
]);
```

### Factura simplificada
```php
$invoice = Invoice::create([
    'number' => 'INV-SIMP-001',
    'date' => '2024-07-01',
    'customer_name' => 'Simplified Customer',
    'customer_tax_id' => 'C87654321',
    'issuer_name' => 'Issuer S.A.',
    'issuer_tax_id' => 'B87654321',
    'amount' => 50.00,
    'tax' => 10.50,
    'total' => 60.50,
    'type' => InvoiceType::SIMPLIFIED,
]);
```

### Factura de sustitución
```php
$invoice = Invoice::create([
    'number' => 'INV-SUB-001',
    'date' => '2024-07-01',
    'customer_name' => 'Substitute Customer',
    'customer_tax_id' => 'C11223344',
    'issuer_name' => 'Issuer S.A.',
    'issuer_tax_id' => 'B87654321',
    'amount' => 80.00,
    'tax' => 16.80,
    'total' => 96.80,
    'type' => InvoiceType::SUBSTITUTE,
    // Puedes añadir aquí la relación con facturas sustituidas si implementas la lógica
]);
```

### Factura rectificativa (R1)
```php
$invoice = Invoice::create([
    'number' => 'INV-RECT-001',
    'date' => '2024-07-01',
    'customer_name' => 'Rectified Customer',
    'customer_tax_id' => 'C55667788',
    'issuer_name' => 'Issuer S.A.',
    'issuer_tax_id' => 'B87654321',
    'amount' => 120.00,
    'tax' => 25.20,
    'total' => 145.20,
    'type' => InvoiceType::RECTIFICATIVE_R1,
    // Puedes añadir aquí la relación con facturas rectificadas y el motivo si implementas la lógica
]);
```

> ⚠️ **Nota:** Para facturas rectificativas y sustitutivas, si implementas los campos y relaciones adicionales (como facturas rectificadas/sustituidas, tipo de rectificación, importe de rectificación), deberás añadirlos en el array de creación.

---

## 📤 Envío de Invoice a AEAT (Ejemplo de Controller)

```php
use Illuminate\Http\Request;
use MMBuxan\VeriFactu\Services\AeatClient;
use MMBuxan\VeriFactu\Models\Invoice;

class InvoiceAeatController extends Controller
{
    public function send(Request $request, AeatClient $aeatClient, $invoiceId)
    {
        $invoice = Invoice::with(['breakdowns', 'recipients'])->findOrFail($invoiceId);
        $result = $aeatClient->sendInvoice($invoice);
        // Puedes registrar el resultado, lanzar eventos, etc.
        return response()->json($result, $result['status'] === 'success' ? 200 : 422);
    }
}
```

> 🔒 **Nota:** Protege este endpoint con autenticación/autorización adecuada.
> 
> 📄 El resultado incluirá el XML enviado y recibido, útil para depuración.
> 
> ❌ Si el certificado no es válido o hay error de validación, el array tendrá 'status' => 'error' y 'message'.

---

## 🧩 Validación y creación de Breakdown (Ejemplo de Controller)

```php
use MMBuxan\VeriFactu\Http\Requests\StoreBreakdownRequest;
use MMBuxan\VeriFactu\Models\Breakdown;

public function storeBreakdown(StoreBreakdownRequest $request)
{
    $breakdown = Breakdown::create($request->validated());
    return response()->json($breakdown);
}
```

---

## 🛠️ Uso de Helpers

```php
use MMBuxan\VeriFactu\Helpers\DateTimeHelper;
use MMBuxan\VeriFactu\Helpers\StringHelper;
use MMBuxan\VeriFactu\Helpers\HashHelper;

$dateIso = DateTimeHelper::formatIso8601('2024-01-01 12:00:00');
$sanitized = StringHelper::sanitize('  &Hello <World>  ');
$hash = HashHelper::generateInvoiceHash([
    'issuer_tax_id' => 'A12345678',
    'invoice_number' => 'INV-001',
    'issue_date' => '2024-01-01',
    'invoice_type' => 'F1',
    'total_tax' => '21.00',
    'total_amount' => '121.00',
    'previous_hash' => '',
    'generated_at' => '2024-01-01T12:00:00+01:00',
]);
```

---

## ⚡ Uso avanzado

### 📢 Integración de eventos y listeners

Puedes disparar eventos cuando se crean, actualizan o envían invoices a AEAT. Ejemplo:

```php
// app/Events/InvoiceSentToAeat.php
namespace App\Events;

use MMBuxan\VeriFactu\Models\Invoice;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceSentToAeat
{
    use Dispatchable, SerializesModels;
    public function __construct(public Invoice $invoice, public array $aeatResponse) {}
}
```

Despacha el evento tras el envío:

```php
use App\Events\InvoiceSentToAeat;

// ... después de enviar a AEAT
InvoiceSentToAeat::dispatch($invoice, $result);
```

Crea un listener para notificaciones o logging:

```php
// app/Listeners/LogAeatResponse.php
namespace App\Listeners;

use App\Events\InvoiceSentToAeat;
use Illuminate\Support\Facades\Log;

class LogAeatResponse
{
    public function handle(InvoiceSentToAeat $event)
    {
        Log::info('AEAT response', [
            'invoice_id' => $event->invoice->id,
            'response' => $event->aeatResponse,
        ]);
    }
}
```

Registra tu evento y listener en `EventServiceProvider`:

```php
protected $listen = [
    \App\Events\InvoiceSentToAeat::class => [
        \App\Listeners\LogAeatResponse::class,
    ],
];
```

---

### 🔐 Políticas de autorización

Puedes restringir el acceso a invoices usando policies de Laravel:

```php
// app/Policies/InvoicePolicy.php
namespace App\Policies;

use App\Models\User;
use MMBuxan\VeriFactu\Models\Invoice;

class InvoicePolicy
{
    public function view(User $user, Invoice $invoice): bool
    {
        return $user->id === $invoice->user_id;
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->id === $invoice->user_id && $invoice->status === 'draft';
    }
}
```

Registra la policy en `AuthServiceProvider`:

```php
protected $policies = [
    \MMBuxan\VeriFactu\Models\Invoice::class => \App\Policies\InvoicePolicy::class,
];
```

Úsala en tu controller:

```php
public function update(Request $request, Invoice $invoice)
{
    $this->authorize('update', $invoice);
    // ...
}
```

---

### 📣 Integración de notificaciones

Puedes notificar a usuarios o admins cuando una invoice se envía o falla:

```php
// app/Notifications/InvoiceSentNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use MMBuxan\VeriFactu\Models\Invoice;

class InvoiceSentNotification extends Notification
{
    use Queueable;
    public function __construct(public Invoice $invoice) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Invoice Sent to AEAT')
            ->line('Invoice #' . $this->invoice->number . ' was sent to AEAT successfully.');
    }
}
```

Despacha la notificación en tu job o listener:

```php
$user->notify(new \App\Notifications\InvoiceSentNotification($invoice));
```

---

### 🕒 Integración con colas (queues)

Puedes enviar invoices a AEAT de forma asíncrona usando colas:

```php
use MMBuxan\VeriFactu\Models\Invoice;
use App\Jobs\SendInvoiceToAeatJob;

// Despacha el job a la cola
SendInvoiceToAeatJob::dispatch($invoice->id);
```

En tu job, implementa `ShouldQueue`:

```php
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoiceToAeatJob implements ShouldQueue
{
    // ...
}
```

Configura tu conexión de cola en `.env` y ejecuta el worker:

```bash
php artisan queue:work
```

---

### 📝 Auditoría

Puedes usar paquetes como [owen-it/laravel-auditing](https://github.com/owen-it/laravel-auditing) para auditar cambios en invoices:

1. Instala el paquete:
   ```bash
   composer require owen-it/laravel-auditing
   ```
2. Añade el contrato `\OwenIt\Auditing\Contracts\Auditable` a tu modelo:
   ```php
   use OwenIt\Auditing\Contracts\Auditable;

   class Invoice extends Model implements Auditable
   {
       use \OwenIt\Auditing\Auditable;
       // ...
   }
   ```
3. Ahora todos los cambios en invoices serán auditados automáticamente. Puedes ver los logs:
   ```php
   $audits = $invoice->audits;
   ```

---

## 🧪 Testing

Ejecuta todos los tests unitarios:

```bash
php artisan test
# o
vendor/bin/phpunit
```

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature
3. Commit tus cambios
4. Push a la rama
5. Abre un Pull Request

## 📄 Licencia

Este paquete es open-source bajo la [Licencia MIT](LICENSE.md).

## 🆘 Soporte

- **Documentación técnica**: https://sede.agenciatributaria.gob.es/Sede/iva/sistemas-informaticos-facturacion-verifactu/informacion-tecnica.html
- **Issues**: https://github.com/mmbuxan/LaravelVerifactu/issues

## 👥 Autor

- Esta librería es un fork de [MMBuxan/LaravelVerifactu](https://github.com/MMBuxan/LaravelVerifactu) ampliado y personalizado.
- **Jorge Picón** - [MMBuxan](https://www.mmbuxan.com)

---

⭐ Si este paquete te ha sido útil, ¡no olvides darle una estrella en GitHub!
