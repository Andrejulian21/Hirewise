<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        // Crear rol Empresa si no existe
        $role = Role::firstOrCreate(['name' => 'Empresa']);

        // Datos de empresas
        $empresas = [
            [
                'name' => 'Cine Colombia',
                'email' => 'cinecolombia@gmail.com',
                'logo' => 'company-logos/cinecolombia.png',
                'description' => 'La cadena de cines más importante de Colombia, con presencia nacional.',
                'website' => 'https://www.cinecolombia.com',
                'location' => 'Bogotá, Colombia',
                'vacantes' => [
                    [
                        'title' => 'Auxiliar de Taquilla',
                        'description' => 'Atiende al público en puntos de venta, realiza venta de boletos, manejo de dinero y atención al cliente en salas de cine.',
                        'requirements' => "• Experiencia mínima de 6 meses en atención al cliente.\n• Disponibilidad para turnos rotativos.\n• Excelente presentación personal.",
                        'salary_min' => 1300000,
                        'salary_max' => 1600000,
                    ],
                    [
                        'title' => 'Técnico en Proyección',
                        'description' => 'Responsable del mantenimiento y proyección de películas en salas digitales y de la operación de equipos de sonido e imagen.',
                        'requirements' => "• Técnico en electrónica o afines.\n• Conocimiento en sistemas de proyección digital.\n• Experiencia en mantenimiento básico.",
                        'salary_min' => 1800000,
                        'salary_max' => 2200000,
                    ],
                    [
                        'title' => 'Coordinador de Mercadeo Regional',
                        'description' => 'Gestiona campañas locales de mercadeo, alianzas con marcas y promoción de estrenos en cada ciudad.',
                        'requirements' => "• Profesional en Mercadeo o Comunicación.\n• Mínimo 2 años de experiencia.\n• Creatividad y liderazgo.",
                        'salary_min' => 2800000,
                        'salary_max' => 3500000,
                    ],
                ],
            ],
            [
                'name' => 'Amazon',
                'email' => 'amazon@gmail.com',
                'logo' => 'company-logos/amazon.png',
                'description' => 'Compañía global líder en comercio electrónico y servicios en la nube.',
                'website' => 'https://www.amazon.com',
                'location' => 'Medellín, Colombia',
                'vacantes' => [
                    [
                        'title' => 'Desarrollador Backend Node.js',
                        'description' => 'Diseño y mantenimiento de microservicios en AWS Lambda, APIs REST y bases de datos escalables.',
                        'requirements' => "• 3+ años de experiencia con Node.js.\n• Conocimientos en AWS y bases de datos NoSQL.\n• Inglés intermedio.",
                        'salary_min' => 7000000,
                        'salary_max' => 9000000,
                    ],
                    [
                        'title' => 'Analista de Datos',
                        'description' => 'Analiza grandes volúmenes de información de clientes y ventas usando herramientas de Big Data.',
                        'requirements' => "• Experiencia con SQL, Python y Power BI.\n• Conocimiento en estadística.\n• Capacidad analítica avanzada.",
                        'salary_min' => 6000000,
                        'salary_max' => 8500000,
                    ],
                    [
                        'title' => 'Representante de Servicio al Cliente',
                        'description' => 'Brinda soporte a clientes en inglés y español para resolver consultas de pedidos y devoluciones.',
                        'requirements' => "• Nivel de inglés B2 o superior.\n• Habilidades de comunicación.\n• Experiencia en BPO o soporte técnico.",
                        'salary_min' => 2500000,
                        'salary_max' => 3200000,
                    ],
                ],
            ],
            [
                'name' => 'Riot Games',
                'email' => 'riot@gmail.com',
                'logo' => 'company-logos/riot.png',
                'description' => 'Desarrolladores de League of Legends y Valorant. Amantes de los videojuegos y la cultura gamer.',
                'website' => 'https://www.riotgames.com',
                'location' => 'Los Ángeles, EE.UU.',
                'vacantes' => [
                    [
                        'title' => 'Game Designer',
                        'description' => 'Diseña y balancea mecánicas de juego, habilidades y sistemas de progresión para nuevos modos de juego.',
                        'requirements' => "• Experiencia previa en diseño de videojuegos.\n• Conocimiento de Unreal o Unity.\n• Inglés avanzado.",
                        'salary_min' => 12000000,
                        'salary_max' => 18000000,
                    ],
                    [
                        'title' => 'Community Manager LATAM',
                        'description' => 'Gestiona la comunidad latinoamericana de jugadores, redes sociales y eventos en línea.',
                        'requirements' => "• Experiencia en gestión de comunidades digitales.\n• Excelente redacción.\n• Pasión por los videojuegos.",
                        'salary_min' => 5000000,
                        'salary_max' => 7000000,
                    ],
                    [
                        'title' => 'QA Tester de Videojuegos',
                        'description' => 'Ejecuta pruebas funcionales y de regresión en nuevas versiones de juegos, reportando bugs y mejoras.',
                        'requirements' => "• Conocimiento de metodologías QA.\n• Experiencia en testing manual.\n• Detalle y comunicación efectiva.",
                        'salary_min' => 4000000,
                        'salary_max' => 5500000,
                    ],
                ],
            ],
            [
                'name' => 'Luigui Jr',
                'email' => 'luigui@gmail.com',
                'logo' => 'company-logos/luigui.png',
                'description' => 'Restaurante familiar con tradición italiana y enfoque en experiencias únicas.',
                'website' => 'https://www.luiguijr.com',
                'location' => 'Bucaramanga, Colombia',
                'vacantes' => [
                    [
                        'title' => 'Chef Principal',
                        'description' => 'Dirige la cocina del restaurante, creación de menús, control de costos y supervisión del personal culinario.',
                        'requirements' => "• Experiencia mínima de 5 años como chef.\n• Conocimiento en cocina italiana.\n• Liderazgo y organización.",
                        'salary_min' => 4000000,
                        'salary_max' => 6000000,
                    ],
                    [
                        'title' => 'Mesero(a) - Atención al Cliente',
                        'description' => 'Atiende a los comensales con calidez, presenta el menú y toma pedidos con precisión.',
                        'requirements' => "• 1 año de experiencia.\n• Excelentes habilidades de comunicación.\n• Trabajo en equipo.",
                        'salary_min' => 1300000,
                        'salary_max' => 1600000,
                    ],
                    [
                        'title' => 'Administrador de Restaurante',
                        'description' => 'Supervisa las operaciones diarias del restaurante, control de inventarios y personal.',
                        'requirements' => "• Profesional en administración o afines.\n• Experiencia en el sector gastronómico.\n• Conocimiento de inventarios y costos.",
                        'salary_min' => 2800000,
                        'salary_max' => 3500000,
                    ],
                ],
            ],
            [
                'name' => 'Koaj',
                'email' => 'koaj@gmail.com',
                'logo' => 'company-logos/koaj.png',
                'description' => 'Marca de moda colombiana que diseña prendas cómodas y con estilo joven.',
                'website' => 'https://www.koaj.co',
                'location' => 'Bogotá, Colombia',
                'vacantes' => [
                    [
                        'title' => 'Diseñador de Moda',
                        'description' => 'Diseña nuevas colecciones de ropa y coordina con el área de producción para el lanzamiento de campañas.',
                        'requirements' => "• Profesional en Diseño de Modas.\n• Conocimientos en patronaje y tendencias.\n• Creatividad y atención al detalle.",
                        'salary_min' => 3200000,
                        'salary_max' => 4500000,
                    ],
                    [
                        'title' => 'Fotógrafo de Catálogo',
                        'description' => 'Realiza sesiones fotográficas de productos para tienda online y redes sociales.',
                        'requirements' => "• Experiencia en fotografía de moda.\n• Manejo de iluminación y edición digital.\n• Portafolio requerido.",
                        'salary_min' => 2500000,
                        'salary_max' => 3000000,
                    ],
                    [
                        'title' => 'Analista de E-Commerce',
                        'description' => 'Administra la tienda online, seguimiento a métricas y coordinación de envíos y devoluciones.',
                        'requirements' => "• Conocimiento en Shopify o WooCommerce.\n• Experiencia en marketing digital.\n• Excel intermedio.",
                        'salary_min' => 2800000,
                        'salary_max' => 3500000,
                    ],
                ],
            ],
        ];

        foreach ($empresas as $data) {
            // Crear usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
            ]);
            $user->assignRole($role);

            // Crear empresa
            $company = Company::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'website' => $data['website'],
                'logo' => $data['logo'],
            ]);

            // Crear vacantes específicas
            foreach ($data['vacantes'] as $vacante) {
                Job::create([
                    'company_id' => $company->id,
                    'title' => $vacante['title'],
                    'description' => $vacante['description'],
                    'requirements' => $vacante['requirements'],
                    'location' => $data['location'],
                    'salary_min' => $vacante['salary_min'],
                    'salary_max' => $vacante['salary_max'],
                    'status' => 'open',
                ]);
            }
        }
        $randomCount = 10; // cambia este número si quieres más/menos
        User::factory($randomCount)->create()->each(function ($user) use ($role) {
            // asignar rol
            $user->assignRole($role);

            // crear company falsa ligada a este user usando Company::factory()
            // Si prefieres crear manualmente, reemplaza la línea por Company::create([...])
            \App\Models\Company::factory()->for($user, 'user')->create();
        });

      
        $this->command->info('✅ Empresas, usuarios y vacantes reales creadas correctamente.');
    }
}
