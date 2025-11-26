const CACHE_NAME = 'estadias-uth-v3';
const urlsToCache = [
  // Evitamos precachear páginas dinámicas como '/login' para no romper CSRF
  '/css/app.css',
  '/js/app.js',
  '/img/logo_uth_2024.png',
  '/offline.html',
  'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
  'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js',
  'https://cdn.tailwindcss.com'
];

// Install event - cache resources
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Cache abierto');
        return cache.addAll(urlsToCache);
      })
      .catch(error => {
        console.log('Error al cachear recursos:', error);
      })
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log('Eliminando cache antiguo:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  // Tomar control inmediato de las páginas abiertas
  self.clients.claim();
});

// Fetch event - serve from cache when offline
self.addEventListener('fetch', event => {
  const req = event.request;

  // No interceptar métodos distintos de GET (evita interferir con formularios/CSRF)
  if (req.method !== 'GET') {
    return; // Dejar que la solicitud continúe sin SW
  }

  // Para documentos HTML, usar estrategia network-first para evitar tokens CSRF obsoletos
  if (req.destination === 'document') {
    event.respondWith(
      fetch(req)
        .then(response => {
          // Opcional: cachear la página visitada para fallback offline
          const resClone = response.clone();
          caches.open(CACHE_NAME).then(cache => {
            cache.put(req, resClone);
          });
          return response;
        })
        .catch(() => {
          event.waitUntil(
            self.clients.matchAll({ includeUncontrolled: true, type: 'window' }).then(clients => {
              clients.forEach(c => c.postMessage({ type: 'OFFLINE_MODE' }));
            })
          );
          // Fallback offline si existe alguna página en caché
          return caches.match(req).then(match => match || caches.match('/offline.html'));
        })
    );
    return;
  }

  // Para assets estáticos (CSS/JS/imagenes), estrategia cache-first
  event.respondWith(
    caches.match(req).then(cached => {
      if (cached) return cached;
      return fetch(req).then(response => {
        if (response && response.status === 200 && response.type === 'basic') {
          const resClone = response.clone();
          caches.open(CACHE_NAME).then(cache => cache.put(req, resClone));
        }
        return response;
      });
    })
  );
});

// Manejo de solicitudes JSON (datos) en Network-First
self.addEventListener('fetch', event => {
  const req = event.request;
  const isJSON = req.headers.get('accept')?.includes('application/json') || req.destination === '';
  if (req.method === 'GET' && isJSON) {
    event.respondWith(
      fetch(req).then(res => {
        const clone = res.clone();
        if (res.ok) caches.open(CACHE_NAME).then(c => c.put(req, clone));
        return res;
      }).catch(() => {
        event.waitUntil(
          self.clients.matchAll({ includeUncontrolled: true, type: 'window' }).then(clients => {
            clients.forEach(c => c.postMessage({ type: 'OFFLINE_MODE' }));
          })
        );
        return caches.match(req);
      })
    );
  }
});

// Push Notifications
self.addEventListener('push', event => {
  const data = event.data ? event.data.json() : { title: 'Notificación', body: 'Tienes una nueva notificación.' };
  const title = data.title || 'Sistema de Estadías UTH';
  const options = {
    body: data.body || '',
    icon: '/img/logo_uth_2024.png',
    badge: '/img/logo_uth_2024.png',
    data: data.data || {},
    actions: data.actions || []
  };
  event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener('notificationclick', event => {
  event.notification.close();
  const url = event.notification.data?.url || '/';
  event.waitUntil(clients.matchAll({ type: 'window' }).then(list => {
    for (const client of list) {
      if (client.url === url && 'focus' in client) return client.focus();
    }
    if (clients.openWindow) return clients.openWindow(url);
  }));
});

// Message event - handle messages from the app
self.addEventListener('message', event => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

// Background sync - handle offline actions
self.addEventListener('sync', event => {
  if (event.tag === 'sync-form-data') {
    event.waitUntil(syncFormData());
  }
});

// Function to sync form data when back online
async function syncFormData() {
  try {
    const cache = await caches.open(CACHE_NAME);
    const requests = await cache.keys();
    
    for (const request of requests) {
      if (request.method === 'POST') {
        try {
          const response = await fetch(request);
          if (response.ok) {
            // Eliminar la petición del caché si se sincronizó correctamente
            await cache.delete(request);
            console.log('Datos sincronizados correctamente');
          }
        } catch (error) {
          console.log('Error al sincronizar datos:', error);
        }
      }
    }
  } catch (error) {
    console.log('Error en la sincronización:', error);
  }
}
