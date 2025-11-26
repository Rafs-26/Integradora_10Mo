# Diagramas de Arquitectura — Sistema de Gestión de Estadías UTH

Este documento reúne los diagramas clave de la arquitectura seleccionada para el sistema (Laravel + Tailwind/Alpine + PWA + MySQL), alineados con los módulos por rol y el esquema de base de datos solicitado.

## 1. Arquitectura de Software (Alta Nivel)

```mermaid
flowchart LR
    subgraph Cliente[Cliente (Navegador)]
        UI[Tailwind + Alpine.js]
        SW[Service Worker]
    end

    subgraph Servidor[Servidor de Aplicación]
        RT[Routes (web.php)]
        MW[Middleware (CSRF, Auth, Role)]
        CT[Controllers (Auth, Estudiante, Profesor, Director, Biblioteca, Notification)]
        VWS[Views (Blade)]
    end

    subgraph Datos[Persistencia]
        DB[(MySQL)]
        CFG[configuracion_sistema]
        DOCS[documentos]
        EST[estadias]
        USR[users]
        ROL[roles]
        ESTU[estudiantes]
        PROF[profesores]
        EMP[empresas]
        SOLC[solicitud_carta_presentacions]
        NOTIF[notificaciones]
    end

    UI <--> SW
    UI -->|HTTP/HTTPS| RT
    RT --> MW --> CT --> VWS
    CT <--> DB
    DB --- USR & ROL & ESTU & PROF & EST & EMP & DOCS & SOLC & NOTIF & CFG
    SW <--> RT

    subgraph Build[Assets]
        Vite[Vite (desarrollo)/Build (producción)]
    end
    Vite --> UI
```

## 2. Vista Lógica por Rol

```mermaid
flowchart TB
    subgraph Admin[Administrador]
        AdminDash[Dashboard]
        AdminUsers[Gestión de Usuarios]
        AdminConf[Configuración]
        AdminRep[Reportes]
        AdminPerfil[Mi Perfil]
    end

    subgraph Dir[Director]
        DirDash[Dashboard]
        DirEstAct[Estadías Activas]
        DirAsign[Asignaciones]
        DirEstud[Lista de Estudiantes]
        DirSeg[Seguimiento]
        DirEmp[Empresas]
        DirDocs[Documentos Pendientes]
        DirCartas[Cartas Pendientes]
        DirRep[Reportes]
        DirPerfil[Mi Perfil]
    end

    subgraph Prof[Profesor]
        ProfDash[Dashboard]
        ProfEst[Mis Estudiantes]
        ProfSeg[Seguimiento]
        ProfDocs[Documentos por Revisar]
        ProfEval[Evaluaciones]
        ProfCitas[Citas]
        ProfCartas[Solicitudes de Cartas]
        ProfRep[Reportes]
        ProfPerfil[Mi Perfil]
    end

    subgraph Est[Estudiante]
        EstDash[Dashboard]
        EstMiEst[Mi Estadía]
        EstDocs[Mis Documentos]
        EstCitas[Mis Citas]
        EstEmp[Catálogo de Empresas]
        EstCarta[Carta de Presentación]
        EstPerfil[Mi Perfil]
    end

    subgraph Bib[Biblioteca]
        BibDash[Dashboard]
        BibMemPend[Memorias Pendientes]
        BibMemVal[Memorias Validadas]
        BibMemRech[Memorias Rechazadas]
        BibStats[Estadísticas]
        BibPerfil[Mi Perfil]
    end
```

## 3. Diagrama de Despliegue (Conceptual)

```mermaid
flowchart LR
    Browser[Navegador] -- HTTP/HTTPS --> Web[Servidor Web (Laravel)]
    Web --> MySQL[(MySQL DB)]
    Browser <-- Assets --> CDN[Vite Build / Assets Estáticos]
    Browser <--> SW[Service Worker]
    Web <-- Logs/Config --> FS[(Sistema de Archivos)]
```

## 4. Modelo de Datos (ER Simplificado)

```mermaid
classDiagram
    class users {
      BIGINT id
      VARCHAR matricula
      VARCHAR email
      VARCHAR nombre_completo
      ENUM status
      BOOL acceso_anticipado
      TIMESTAMP ultimo_acceso
      BIGINT rol_id
    }
    class roles {
      BIGINT id
      VARCHAR nombre
      VARCHAR slug
      JSON permisos
      BOOL activo
      BOOL sistema
    }
    users --> roles : rol_id

    class estudiantes {
      BIGINT id
      BIGINT user_id
      BIGINT carrera_id
      BIGINT especialidad_id
      TINYINT cuatrimestre
    }
    class profesores {
      BIGINT id
      BIGINT user_id
      VARCHAR numero_empleado
      BOOL activo_como_tutor
      BIGINT carrera_dirigida_id
    }
    class carreras {
      BIGINT id
      VARCHAR nombre
      VARCHAR codigo
      BIGINT director_id
    }
    class especialidades {
      BIGINT id
      BIGINT carrera_id
      VARCHAR nombre
      VARCHAR codigo
    }
    estudiantes --> users : user_id
    profesores --> users : user_id
    carreras --> profesores : director_id
    especialidades --> carreras : carrera_id

    class empresas {
      BIGINT id
      VARCHAR razon_social
      ENUM status
    }

    class estadias {
      BIGINT id
      BIGINT estudiante_id
      BIGINT tutor_id
      BIGINT empresa_id
      ENUM status
      VARCHAR proyecto
      VARCHAR area_empresa
    }
    estadias --> estudiantes : estudiante_id
    estadias --> profesores : tutor_id
    estadias --> empresas : empresa_id

    class documentos {
      BIGINT id
      BIGINT estadia_id
      ENUM tipo_documento
      LONGTEXT contenido_archivo
      ENUM status
      BIGINT subido_por
      BIGINT validado_por
    }
    documentos --> estadias : estadia_id
    documentos --> users : subido_por
    documentos --> users : validado_por

    class solicitud_carta_presentacions {
      BIGINT id
      BIGINT estudiante_id
      BIGINT estadia_id
      ENUM estado
      TIMESTAMP fecha_solicitud
    }
    solicitud_carta_presentacions --> estudiantes : estudiante_id
    solicitud_carta_presentacions --> estadias : estadia_id

    class notificaciones {
      BIGINT id
      BIGINT usuario_id
      ENUM tipo
      ENUM prioridad
      BOOL leida
    }
    notificaciones --> users : usuario_id
```

## 5. Secuencia — Solicitud de Carta (Rechazo y Re-solicitud)

```mermaid
sequenceDiagram
    participant Est as Estudiante
    participant Web as Laravel (Controller)
    participant DB as MySQL
    participant Prof as Profesor
    participant Dir as Director

    Est->>Web: Solicitar carta (POST)
    Web->>DB: Crear solicitud estado=pendiente
    DB-->>Web: OK
    Web-->>Est: Confirmación

    Prof->>Web: Revisar solicitud
    Web->>DB: Actualizar estado=aprobada_profesor|rechazada_profesor
    DB-->>Web: OK

    Dir->>Web: Revisar solicitud
    Web->>DB: Actualizar estado=aprobada_director|rechazada_director
    DB-->>Web: OK

    alt Rechazada
        Est->>Web: Re-solicitar
        Web->>DB: Marcar anterior estado=reemplazada
        Web->>DB: Crear nueva solicitud estado=pendiente
        DB-->>Web: OK
        Web-->>Est: Nueva solicitud creada
    end
```

## 6. Secuencia — Inicio de Sesión (CSRF y Sesión)

```mermaid
sequenceDiagram
    participant B as Browser
    participant L as Laravel
    participant D as DB

    B->>L: POST /login (CSRF válido)
    L->>D: Auth::attempt
    D-->>L: Usuario válido
    L->>L: session()->regenerate()
    L-->>B: Redirect dashboard
```

## 7. Secuencia — Notificaciones por Rol

```mermaid
sequenceDiagram
    participant UI as UI (Alpine)
    participant API as Laravel API
    participant DB as MySQL

    UI->>API: GET /notifications/role/{rol}
    API->>DB: SELECT notificaciones por rol
    DB-->>API: Lista
    API-->>UI: JSON
    UI->>API: POST /notifications/{id}/read
    API->>DB: Update leida=true
    DB-->>API: OK
```

## 8. PWA — Estrategias de Caché

```mermaid
flowchart TB
    SW[Service Worker]
    HTML[Documentos HTML]
    ASSETS[CSS/JS/Imágenes]

    SW -->|Network-first| HTML
    SW -->|Cache-first| ASSETS
    SW -.->|No intercepta| POST/CSRF
```

---

Notas:
- Los diagramas están alineados con las migraciones y el esquema de datos actualizado (roles, users con `rol_id`, entidades de estadías y documentos, solicitudes de carta, notificaciones).
- Las rutas y controladores siguen Laravel con middleware de autenticación y control de rol.
- El PWA evita interferir con tokens CSRF y documentos dinámicos.

