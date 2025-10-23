<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresas = [
            [
                'nombre_comercial' => 'TechSolutions México',
                'razon_social' => 'TechSolutions México S.A. de C.V.',
                'rfc' => 'TSM123456789',
                'direccion' => 'Av. Tecnológico #100, Col. Centro',
                'ciudad' => 'Pachuca',
                'estado' => 'Hidalgo',
                'codigo_postal' => '42000',
                'telefono' => '7711234567',
                'email' => 'contacto@techsolutions.mx',
                'sitio_web' => 'https://www.techsolutions.mx',
                'contacto_nombre' => 'María González',
                'contacto_puesto' => 'Gerente de Recursos Humanos',
                'contacto_telefono' => '7711234567',
                'contacto_email' => 'rh@techsolutions.mx',
                'sector' => 'tecnologia',
                'giro' => 'Desarrollo de software',
                'tamaño' => 'mediana',
                'observaciones' => 'Empresa especializada en desarrollo de software y soluciones tecnológicas.',
                'status' => 'activa'
            ],
            [
                'nombre_comercial' => 'Innovación Digital',
                'razon_social' => 'Innovación Digital S.A. de C.V.',
                'rfc' => 'IND987654321',
                'direccion' => 'Blvd. Revolución #250, Col. Doctores',
                'ciudad' => 'Tulancingo',
                'estado' => 'Hidalgo',
                'codigo_postal' => '43600',
                'telefono' => '7759876543',
                'email' => 'info@innovaciondigital.com',
                'sitio_web' => 'https://www.innovaciondigital.com',
                'contacto_nombre' => 'Carlos Mendoza',
                'contacto_puesto' => 'Director de Proyectos',
                'contacto_telefono' => '7759876543',
                'contacto_email' => 'carlos@innovaciondigital.com',
                'sector' => 'tecnologia',
                'giro' => 'Consultoría en TI',
                'tamaño' => 'pequeña',
                'observaciones' => 'Consultoría especializada en transformación digital y sistemas de información.',
                'status' => 'activa'
            ],
            [
                'nombre_comercial' => 'Sistemas Empresariales del Centro',
                'razon_social' => 'Sistemas Empresariales del Centro S.A. de C.V.',
                'rfc' => 'SEC456789123',
                'direccion' => 'Calle Hidalgo #45, Col. Centro',
                'ciudad' => 'Pachuca',
                'estado' => 'Hidalgo',
                'codigo_postal' => '42000',
                'telefono' => '7712345678',
                'email' => 'contacto@sec.com.mx',
                'sitio_web' => 'https://www.sec.com.mx',
                'contacto_nombre' => 'Ana Rodríguez',
                'contacto_puesto' => 'Coordinadora de Estadías',
                'contacto_telefono' => '7712345678',
                'contacto_email' => 'estadias@sec.com.mx',
                'sector' => 'servicios',
                'giro' => 'Servicios de TI',
                'tamaño' => 'grande',
                'observaciones' => 'Empresa líder en servicios de tecnología de la información para el sector empresarial.',
                'status' => 'activa'
            ],
            [
                'nombre_comercial' => 'DataSoft Hidalgo',
                'razon_social' => 'DataSoft Hidalgo S.A. de C.V.',
                'rfc' => 'DSH789123456',
                'direccion' => 'Av. Universidad #300, Col. Universitaria',
                'ciudad' => 'Pachuca',
                'estado' => 'Hidalgo',
                'codigo_postal' => '42090',
                'telefono' => '7713456789',
                'email' => 'rh@datasoft.mx',
                'sitio_web' => 'https://www.datasoft.mx',
                'contacto_nombre' => 'Luis Hernández',
                'contacto_puesto' => 'Jefe de Recursos Humanos',
                'contacto_telefono' => '7713456789',
                'contacto_email' => 'luis.hernandez@datasoft.mx',
                'sector' => 'tecnologia',
                'giro' => 'Análisis de datos',
                'tamaño' => 'mediana',
                'observaciones' => 'Especialistas en análisis de datos, inteligencia de negocios y machine learning.',
                'status' => 'activa'
            ],
            [
                'nombre_comercial' => 'Manufacturas Industriales SA',
                'razon_social' => 'Manufacturas Industriales S.A. de C.V.',
                'rfc' => 'MIS321654987',
                'direccion' => 'Parque Industrial #500, Col. Industrial',
                'ciudad' => 'Tulancingo',
                'estado' => 'Hidalgo',
                'codigo_postal' => '43640',
                'telefono' => '7754567890',
                'email' => 'estadias@manufacturas.mx',
                'sitio_web' => 'https://www.manufacturas.mx',
                'contacto_nombre' => 'Roberto Silva',
                'contacto_puesto' => 'Supervisor de Estadías',
                'contacto_telefono' => '7754567890',
                'contacto_email' => 'roberto.silva@manufacturas.mx',
                'sector' => 'manufactura',
                'giro' => 'Manufactura automotriz',
                'tamaño' => 'grande',
                'observaciones' => 'Empresa manufacturera especializada en componentes automotrices y sistemas industriales.',
                'status' => 'activa'
            ]
        ];
        
        foreach ($empresas as $empresaData) {
            Empresa::updateOrCreate(
                ['rfc' => $empresaData['rfc']],
                $empresaData
            );
        }
        
        $this->command->info('✅ Empresas de ejemplo creadas exitosamente');
        $this->command->info('📊 Se crearon ' . count($empresas) . ' empresas:');
        foreach ($empresas as $empresa) {
            $this->command->info('   - ' . $empresa['nombre_comercial'] . ' (' . $empresa['sector'] . ')');
        }
    }
}