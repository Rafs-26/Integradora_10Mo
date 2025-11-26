## 1. Architecture design

```mermaid
graph TD
    A[User Browser] --> B[Laravel Frontend Views]
    B --> C[Controllers Layer]
    C --> D[Models Layer]
    D --> E[MySQL Database]
    
    subgraph "Frontend Layer"
        B1[Blade Templates]
        B2[Tailwind CSS]
        B3[Alpine.js]
        B4[Font Awesome]
    end
    
    subgraph "Backend Layer"
        C1[AuthController]
        C2[DirectorController]
        C3[ProfesorController]
        C4[EstudianteController]
        C5[BibliotecaController]
        C6[AdministradorController]
    end
    
    subgraph "Data Layer"
        D1[User Model]
        D2[Estudiante Model]
        D3[Profesor Model]
        D4[Documento Model]
        D5[Estadia Model]
        D6[Role Model]
    end
    
    B --> B1
    B1 --> B2
    B1 --> B3
    B1 --> B4
    
    C --> C1
    C --> C2
    C --> C3
    C --> C4
    C --> C5
    C --> C6
    
    D --> D1
    D --> D2
    D --> D3
    D --> D4
    D --> D5
    D --> D6
```

## 2. Technology Description

- **Frontend**: Laravel Blade + Tailwind CSS + Alpine.js
- **Backend**: Laravel 10.x Framework
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum + Session-based Auth
- **File Storage**: Laravel Storage (local/public)
- **PDF Generation**: DomPDF (barryvdh/laravel-dompdf)
- **Icons**: Font Awesome 6.x
- **JavaScript**: Alpine.js 3.x (lightweight reactivity)
- **CSS Framework**: Tailwind CSS 3.x

## 3. Route definitions

| Route | Purpose | Controller Method |
|-------|---------|-------------------|
| `/admin/dashboard` | Panel principal administrador | AuthController@redirectToDashboard |
| `/admin/usuarios` | Gestión completa de usuarios | AdministradorController@gestionarUsuarios |
| `/admin/configuracion` | Configuración del sistema | AdministradorController@configuracionSistema |
| `/admin/reportes-globales` | Reportes y estadísticas globales | AdministradorController@reportesGlobales |
| `/director/evaluaciones` | Panel de evaluaciones | DirectorController@evaluaciones |
| `/director/proyectos` | Gestión de proyectos | DirectorController@proyectosDisponibles |
| `/director/reportes-detallados` | Reportes avanzados | DirectorController@reportesDetallados |
| `/teacher/mensajeria` | Sistema de mensajería | ProfesorController@mensajeria |
| `/teacher/calendario` | Calendario integrado | ProfesorController@calendarioIntegrado |
| `/teacher/evaluaciones-avanzadas` | Evaluaciones con rúbricas | ProfesorController@evaluacionesAvanzadas |
| `/student/editor-proyectos` | Editor visual de proyectos | EstudianteController@editorProyectos |
| `/student/catalogo-empresas` | Catálogo interactivo de empresas | EstudianteController@catalogoEmpresas |
| `/student/seguimiento-visual` | Timeline visual de progreso | EstudianteController@seguimientoVisual |
| `/biblioteca/estadisticas-avanzadas` | Dashboard estadístico biblioteca | BibliotecaController@estadisticasAvanzadas |
| `/biblioteca/validacion-lote` | Validación masiva de memorias | BibliotecaController@validacionLote |
| `/biblioteca/reportes-bibliotecarios` | Reportes especializados | BibliotecaController@reportesBibliotecarios |

## 4. API definitions

### 4.1 User Management APIs

```
GET /api/admin/users
```
Request: Query parameters for filtering and pagination
Response: JSON array of users with roles and permissions

```
POST /api/admin/users
```
Request:
```json
{
  "name": "string",
  "email": "string @uth.edu.mx",
  "password": "string (min:8, special chars)",
  "role_id": "integer",
  "carrera_id": "integer (optional)",
  "activo": "boolean"
}
```

```
PUT /api/admin/users/{id}
```
Request: Same as POST, all fields optional

```
DELETE /api/admin/users/{id}
```
Response: `{ "success": true, "message": "Usuario eliminado" }`

### 4.2 System Configuration APIs

```
GET /api/admin/configuracion
```
Response: Current system configuration

```
POST /api/admin/configuracion
```
Request:
```json
{
  "plazos_documentos": {
    "propuesta": 30,
    "reporte_parcial": 60,
    "memoria": 90
  },
  "limites_archivo": {
    "max_size": "10MB",
    "tipos_permitidos": ["pdf", "doc", "docx"]
  },
  "notificaciones": {
    "habilitadas": true,
    "recordatorios": true
  }
}
```

### 4.3 Evaluation Management APIs

```
GET /api/director/evaluaciones/{id}
```
Response: Evaluation details with rubrics

```
POST /api/director/evaluaciones
```
Request:
```json
{
  "titulo": "string",
  "descripcion": "string",
  "rubricas": [
    {
      "criterio": "string",
      "peso": "integer (1-100)",
      "descripcion": "string"
    }
  ],
  "estudiantes_asignados": ["integer"]
}
```

### 4.4 Messaging System APIs

```
GET /api/teacher/mensajes
```
Response: Conversations list with unread counts

```
POST /api/teacher/mensajes
```
Request:
```json
{
  "destinatario_id": "integer",
  "asunto": "string",
  "mensaje": "string",
  "adjuntos": ["string (file paths)"]
}
```

### 4.5 Advanced Statistics APIs

```
GET /api/biblioteca/estadisticas
```
Response:
```json
{
  "memorias_procesadas": "integer",
  "tasa_aprobacion": "float (0-1)",
  "tiempo_promedio_validacion": "integer (hours)",
  "memorias_por_carrera": [
    {
      "carrera": "string",
      "total": "integer",
      "aprobados": "integer",
      "rechazados": "integer"
    }
  ]
}
```

## 5. Server architecture diagram

```mermaid
graph TD
    A[HTTP Request] --> B[Route Middleware]
    B --> C[Auth Middleware]
    C --> D[Role Middleware]
    D --> E[Controller Layer]
    E --> F[Service Layer]
    F --> G[Repository Layer]
    G --> H[Database Layer]
    
    subgraph "Middleware Stack"
        B1[Authenticate]
        B2[VerifyCsrfToken]
        B3[RoleBasedAccess]
    end
    
    subgraph "Controller Layer"
        E1[Input Validation]
        E2[Business Logic]
        E3[Response Formatting]
    end
    
    subgraph "Service Layer"
        F1[UserService]
        F2[DocumentService]
        F3[NotificationService]
        F4[ReportService]
    end
    
    subgraph "Repository Layer"
        G1[UserRepository]
        G2[DocumentRepository]
        G3[EstadiaRepository]
    end
    
    subgraph "Database Layer"
        H1[Users Table]
        H2[Documents Table]
        H3[Estadias Table]
        H4[Notifications Table]
    end
    
    B --> B1
    B1 --> B2
    B2 --> B3
    
    E --> E1
    E1 --> E2
    E2 --> E3
    
    F --> F1
    F --> F2
    F --> F3
    F --> F4
    
    G --> G1
    G --> G2
    G --> G3
    
    H --> H1
    H --> H2
    H --> H3
    H --> H4
```

## 6. Data model

### 6.1 Data model definition

```mermaid
erDiagram
    USER ||--o{ ROLE : has
    USER ||--o{ ESTUDIANTE : can_be
    USER ||--o{ PROFESOR : can_be
    USER ||--o{ NOTIFICACION : receives
    
    ESTUDIANTE ||--o{ ESTADIA : has
    ESTUDIANTE ||--o{ DOCUMENTO : uploads
    ESTUDIANTE ||--o{ CITA : schedules
    
    PROFESOR ||--o{ ESTADIA : supervises
    PROFESOR ||--o{ CITA : manages
    PROFESOR ||--o{ DOCUMENTO : reviews
    
    EMPRESA ||--o{ ESTADIA : hosts
    CARRERA ||--o{ ESTUDIANTE : has
    CARRERA ||--o{ ESPECIALIDAD : has
    
    ESTADIA ||--o{ DOCUMENTO : requires
    ESTADIA ||--o{ SOLICITUD_CARTA : generates
    
    DOCUMENTO ||--o{ VALIDACION : has
    
    USER {
        int id PK
        string email UK
        string password
        int role_id FK
        timestamp created_at
        timestamp updated_at
    }
    
    ROLE {
        int id PK
        string nombre UK
        string descripcion
        json permisos
        boolean activo
    }
    
    ESTUDIANTE {
        int id PK
        int user_id FK
        int carrera_id FK
        int especialidad_id FK
        string matricula UK
        string telefono
        string direccion
        timestamp created_at
    }
    
    PROFESOR {
        int id PK
        int user_id FK
        int carrera_id FK
        string especialidad
        string grado_academico
        string telefono
        string extension
        boolean activo_como_tutor
        timestamp created_at
    }
    
    ESTADIA {
        int id PK
        int estudiante_id FK
        int empresa_id FK
        int tutor_id FK
        string periodo
        date fecha_inicio
        date fecha_fin
        string status
        string modalidad
        int horas_semanales
        timestamp created_at
    }
    
    DOCUMENTO {
        int id PK
        int estadia_id FK
        int estudiante_id FK
        string tipo_documento
        string nombre_archivo
        string ruta_archivo
        string status
        string comentarios_revision
        int revisado_por FK
        timestamp fecha_revision
        timestamp created_at
    }
    
    CITA {
        int id PK
        int estudiante_id FK
        int tutor_id FK
        string titulo
        text descripcion
        date fecha
        time hora_inicio
        time hora_fin
        string modalidad
        string status
        timestamp created_at
    }
    
    EMPRESA {
        int id PK
        string razon_social
        string nombre
        string rfc
        string direccion
        string telefono
        string email
        string sector
        string status
        timestamp created_at
    }
    
    CARRERA {
        int id PK
        string nombre
        string descripcion
        string codigo
        boolean activa
        timestamp created_at
    }
    
    NOTIFICACION {
        int id PK
        int user_id FK
        string titulo
        text mensaje
        string tipo
        boolean leida
        timestamp created_at
    }
```

### 6.2 Data Definition Language

```sql
-- Tabla de usuarios mejorada
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    rol_id BIGINT UNSIGNED NOT NULL,
    remember_token VARCHAR(100) NULL,
    activo BOOLEAN DEFAULT TRUE,
    ultimo_acceso TIMESTAMP NULL,
    configuracion_ui JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE RESTRICT
);

-- Índices para usuarios
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_rol_id ON users(rol_id);
CREATE INDEX idx_users_activo ON users(activo);

-- Tabla de configuración del sistema
CREATE TABLE configuracion_sistema (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    tipo_dato VARCHAR(50) DEFAULT 'string',
    descripcion TEXT,
    categoria VARCHAR(100),
    editable BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Datos iniciales de configuración
INSERT INTO configuracion_sistema (clave, valor, tipo_dato, descripcion, categoria) VALUES
('plazo_propuesta_dias', '30', 'integer', 'Plazo máximo para entrega de propuesta de estadía', 'plazos'),
('plazo_reporte_parcial_dias', '60', 'integer', 'Plazo máximo para entrega de reporte parcial', 'plazos'),
('plazo_memoria_dias', '90', 'integer', 'Plazo máximo para entrega de memoria final', 'plazos'),
('max_tamano_archivo_mb', '10', 'integer', 'Tamaño máximo permitido para archivos', 'limites'),
('tipos_archivo_permitidos', 'pdf,doc,docx', 'string', 'Tipos de archivo permitidos', 'limites'),
('habilitar_notificaciones', 'true', 'boolean', 'Sistema de notificaciones habilitado', 'notificaciones'),
('habilitar_recordatorios', 'true', 'boolean', 'Recordatorios automáticos habilitados', 'notificaciones');

-- Tabla de mensajería
CREATE TABLE mensajes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    remitente_id BIGINT UNSIGNED NOT NULL,
    destinatario_id BIGINT UNSIGNED NOT NULL,
    asunto VARCHAR(255),
    mensaje TEXT NOT NULL,
    leido BOOLEAN DEFAULT FALSE,
    fecha_lectura TIMESTAMP NULL,
    adjuntos JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (remitente_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX idx_mensajes_destinatario ON mensajes(destinatario_id);
CREATE INDEX idx_mensajes_leido ON mensajes(leido);

-- Tabla de eventos del calendario
CREATE TABLE eventos_calendario (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE,
    hora_inicio TIME,
    hora_fin TIME,
    todo_el_dia BOOLEAN DEFAULT FALSE,
    color VARCHAR(7) DEFAULT '#009d82',
    user_id BIGINT UNSIGNED NOT NULL,
    creado_por BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (creado_por) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX idx_eventos_user_id ON eventos_calendario(user_id);
CREATE INDEX idx_eventos_fecha_inicio ON eventos_calendario(fecha_inicio);

-- Tabla de rúbricas de evaluación
CREATE TABLE rubricas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    tipo_evaluacion VARCHAR(100) NOT NULL,
    criterios JSON NOT NULL,
    total_puntos DECIMAL(5,2) DEFAULT 100.00,
    activa BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT
);

CREATE INDEX idx_rubricas_tipo ON rubricas(tipo_evaluacion);
CREATE INDEX idx_rubricas_activa ON rubricas(activa);

-- Tabla de evaluaciones con rúbricas
CREATE TABLE evaluaciones_rubricas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    estudiante_id BIGINT UNSIGNED NOT NULL,
    rubrica_id BIGINT UNSIGNED NOT NULL,
    evaluador_id BIGINT UNSIGNED NOT NULL,
    calificaciones JSON NOT NULL,
    puntuacion_total DECIMAL(5,2),
    comentarios TEXT,
    fecha_evaluacion DATE NOT NULL,
    status VARCHAR(50) DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    FOREIGN KEY (rubrica_id) REFERENCES rubricas(id) ON DELETE RESTRICT,
    FOREIGN KEY (evaluador_id) REFERENCES users(id) ON DELETE RESTRICT
);

CREATE INDEX idx_evaluaciones_estudiante ON evaluaciones_rubricas(estudiante_id);
CREATE INDEX idx_evaluaciones_status ON evaluaciones_rubricas(status);
```