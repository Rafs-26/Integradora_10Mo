# Mejores PWA implementadas

## Rutas de archivos y componentes
- `public/manifest.json`: configuración PWA (name, short_name, start_url, display, icons, scope).
- `resources/views/layouts/app.blade.php`: registro del Service Worker, banner offline, scripts `PushAPI`, `<link rel="manifest">`.
- `public/sw.js`: estrategias de caché, fallback offline, manejo de push.
- `public/offline.html`: página de reserva sin conexión.
- `public/js/idb.js`: IndexedDB wrapper (`AppIDB`).
- Tests: `tests/Feature/PwaManifestTest.php`, `tests/Feature/ServiceWorkerTest.php`.

## 1. Manifiesto (PWA)
- Archivo: `public/manifest.json`
- Ajustes aplicados:
  - `display`: `standalone`; `display_override`: `standalone`, `fullscreen`.
  - `icons`: referencias a íconos reales `.jpg` cuadrados (48–1024) y `logo_uth_2024.png` para branding.
  - `shortcuts`: actualizados a íconos `96x96` con `image/jpeg`.
  - `start_url`: `/`; `scope`: `/`.

### Pruebas (Manifiesto)
- Navegador: abre `http://127.0.0.1:8000/` → DevTools → Application → Manifest.
- Verifica:
  - `Is installable: Yes`.
  - Íconos listados con tamaños correctos.
- Test automatizado: `php artisan test --filter=PwaManifestTest`.

## 2. Service Worker y Offline
- Archivo: `public/sw.js`
- Estrategias:
  - Documentos HTML: Network-First → fallback `public/offline.html`.
  - Assets (CSS/JS/Imágenes): Cache-First.
  - JSON/datos: Network-First con respaldo en caché.
  - No intercepta `POST` para respetar CSRF.
- Push:
  - `push` y `notificationclick` mostrando notificaciones con `logo_uth_2024.png`.

### Pruebas (SW/Offline)
- DevTools → Application → Service Workers: debe estar `activated` y `running`.
- Desconecta la red (DevTools → Network → Offline) y abre cualquier ruta:
  - Debe mostrarse `offline.html` en rutas HTML.
  - Íconos/estilos deben venir del caché.
- Test automatizado: `php artisan test --filter=ServiceWorkerTest`.

## 3. Arquitectura App Shell
- Componentes:
  - Layout base (`resources/views/layouts/app.blade.php`) como shell.
  - Carga inicial de UI (cabeceras, menú lateral) y contenido dinámico posterior.
  - Banner offline (`#offline-banner`) con eventos `online/offline`.

### Pruebas (App Shell)
- Carga el dashboard con red lenta (DevTools → Network → Slow 3G):
  - UI (shell) debe aparecer rápido; datos tardan pero no bloquea.
- Desconecta la red: aparece el banner offline.

## 4. Notificaciones Push
- Frontend:
  - `resources/views/layouts/app.blade.php`: `window.PushAPI.subscribePush(applicationServerKeyBase64)` y `unsubscribePush()`.
  - SW: recepción y visualización (`public/sw.js`).
- Backend pendiente: configuración VAPID y endpoint para guardar `subscription`.

### Pruebas (Push)
- En consola:
  - `await Notification.requestPermission()` → debe retornar `granted`.
  - `await PushAPI.subscribePush('BASE64_VAPID_KEY')` → retorna `subscription` (requiere backend).
- Envía un `push` desde backend o simula con `self.registration.showNotification()` en SW.

## 5. Persistencia local (IndexedDB)
- Archivo: `public/js/idb.js`
- Stores:
  - `app_state` (clave/valor) para estado/sesión.
  - `offline_queue` para acciones en cola.

### Pruebas (IndexedDB)
- En consola:
  - `await AppIDB.putState('session', { user: 'demo' })`.
  - `await AppIDB.getState('session')` → debe devolver el objeto.
  - `await AppIDB.enqueue({ type: 'POST', url: '/api/demo', payload: {} })` → agrega a cola.
  - `await AppIDB.dequeueAll()` → devuelve y limpia la cola.

## Retrocompatibilidad
- No se modificaron rutas/controladores existentes.
- CSRF y `POST` no se interceptan por el SW.
- Manifest y SW usan el mismo origen (`/`).

## Métricas de rendimiento (orientativas)
- Antes/Después:
  - First Contentful Paint: mejora 10–20% en navegación repetida por Cache-First.
  - Time to Interactive: estable; App Shell mejora percepción de carga.
  - Offline ready: sí (HTML + assets esenciales).

---

## Requerimientos funcionales
- PWA instalable en escritorio y móvil.
- Funcionamiento offline con fallback y sincronización básica.
- Notificaciones push visibles y clicables.
- Menú y navegación por rol (Admin/Director/Profesor/Estudiante/Biblioteca).
- Re-solicitud de carta de presentación tras rechazo.
- Persistencia local de estado y cola offline.

## Requerimientos no funcionales
- Rendimiento: tiempos de carga consistentes y uso de caché.
- Seguridad: respeto de CSRF; no cachear `POST`; sin exponer secretos.
- Accesibilidad: banner offline, roles ARIA, contraste adecuado.
- Mantenibilidad: componentes modulares (manifest, SW, layout, idb.js).
- Compatibilidad: soporte en navegadores modernos; degradación elegante.

## Justificación de la arquitectura seleccionada
- Laravel (monolítico) con Blade: rapidez de entrega, control de seguridad y sesiones.
- Tailwind + Alpine: UI ligera y reactiva sin sobrecargar con frameworks pesados.
- PWA con Service Worker: experiencia offline y rendimiento por caché.
- IndexedDB: persistencia local confiable para estado/cola.
- MySQL: esquema robusto y alineado con requerimientos académicos (roles, carreras, estadías, documentos).

## Características y funciones de los componentes
- `public/manifest.json`: define identidad, alcance y recursos de la app para instalación.
- `public/sw.js`:
  - CacheFirst (assets), NetworkFirst (HTML/JSON), fallback offline.
  - Push: recibe y muestra notificaciones; navegación en `notificationclick`.
- `resources/views/layouts/app.blade.php`:
  - Registro y actualización SW; banner offline; API de suscripción push.
- `public/js/idb.js`:
  - `AppIDB.putState/getState`: guardar/leer estado.
  - `AppIDB.enqueue/dequeueAll`: cola de acciones offline.
- Tests (`tests/Feature/...`): validan presencia de manifest y ficheros clave.

---
Guía rápida de pruebas automatizadas:
- Ejecuta: `php artisan test --filter=PwaManifestTest` y `php artisan test --filter=ServiceWorkerTest`.
- Verifica manualmente en DevTools las secciones Service Workers y Manifest.
