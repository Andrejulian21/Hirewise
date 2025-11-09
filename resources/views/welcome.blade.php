@extends('layouts.app')

@section('title', 'Hirewise — Contrata mejor y más rápido con IA')

@section('content')

    <!-- HERO SECTION -->
    <section class="hero section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">
                        <i class="bi bi-stars me-1"></i> Automatiza tu selección
                    </span>
                    <p></p>

                    <h1 class="display-5 fw-bold lh-tight mb-3">
                        Contrata mejor y más rápido con <span class="text-gradient">IA</span>
                    </h1>

                    <p class="lead text-secondary mb-4">
                        Publica vacantes, recibe postulaciones y deja que Hirewise calcule el
                        <strong>nivel de compatibilidad</strong> de cada candidato automáticamente.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-rocket-takeoff me-2"></i>Comenzar gratis
                        </a>
                        <a href="#caracteristicas" class="btn btn-outline-primary btn-lg px-4">
                            <i class="bi bi-arrow-down-circle me-2"></i>Ver características
                        </a>
                    </div>

                    <ul class="hero-list mt-4">
                        <li>Matching semántico de CVs y vacantes</li>
                        <li>Dashboard con métricas y reportes</li>
                        <li>Flujo simple para empresas y candidatos</li>
                    </ul>
                </div>

                <div class="col-lg-6">
                    <div class="hero-card shadow-sm rounded-4 p-4 p-lg-5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="small text-uppercase text-secondary fw-semibold">
                                <i class="bi bi-graph-up me-1"></i>Demo en vivo
                            </span>
                            <span class="badge bg-primary-subtle text-primary-emphasis">
                                <i class="bi bi-clock-history me-1"></i>Tiempo real
                            </span>
                        </div>

                        <div class="progress my-3" role="progressbar" aria-label="Compatibilidad promedio"
                            style="height: 2.5rem;">
                            <div class="progress-bar" style="width: 78%">
                                <i class="bi bi-star-fill me-2"></i>Compatibilidad promedio 78%
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <span class="chip">
                                <i class="bi bi-briefcase me-1"></i>Vacantes activas: 4
                            </span>
                            <span class="chip">
                                <i class="bi bi-people me-1"></i>Candidatos: 15
                            </span>
                            <span class="chip">
                                <i class="bi bi-calendar-check me-1"></i>Entrevistas: 3
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CARACTERÍSTICAS -->
    <section id="caracteristicas" class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">
                    <i class="bi bi-gear me-1"></i>Funcionalidades
                </span>
                <h2 class="fw-bold mb-3">Características clave</h2>
                <p class="text-secondary">Tecnología de punta con diseño minimalista y foco en resultados.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="icon-bubble mb-3">
                                <i class="bi bi-magic"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Matching inteligente</h5>
                            <p class="card-text text-secondary">
                                Embeddings semánticos para comparar requisitos con CVs y rankear candidatos automáticamente.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="icon-bubble mb-3">
                                <i class="bi bi-bar-chart-line"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Métricas claras</h5>
                            <p class="card-text text-secondary">
                                Panel con compatibilidad, embudos de conversión y tiempos promedio de contratación.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="icon-bubble mb-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Flujo simple</h5>
                            <p class="card-text text-secondary">
                                Experiencia pulida y profesional tanto para empresas como para candidatos.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CÓMO FUNCIONA -->
    <section id="como-funciona" class="section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 order-lg-2">
                    <div class="steps-card rounded-4 p-4 p-lg-5 shadow-sm">
                        <ol class="steps">
                            <li>
                                <strong>Crea tu cuenta</strong> como empresa o candidato en segundos.
                            </li>
                            <li>
                                <strong>Publica una vacante</strong> o completa tu perfil profesional.
                            </li>
                            <li>
                                <strong>Deja que la IA</strong> calcule compatibilidades de forma automática.
                            </li>
                            <li>
                                <strong>Gestiona entrevistas</strong> y decisiones desde un panel centralizado.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="col-lg-6 order-lg-1">
                    <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">
                        <i class="bi bi-lightning-charge me-1"></i>Proceso rápido
                    </span>
                    <h2 class="fw-bold mb-3">De cero a contratación en minutos</h2>
                    <p class="text-secondary mb-4">
                        Un diseño minimalista con foco en la acción: menos clics, más resultados.
                        Nuestra plataforma está optimizada para que puedas concentrarte en lo importante:
                        encontrar el talento perfecto.
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-play-circle me-2"></i>Probar ahora
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- PLANES -->
    <section id="precios" class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">
                    <i class="bi bi-tag me-1"></i>Precios
                </span>
                <h2 class="fw-bold mb-3">Planes flexibles</h2>
                <p class="text-secondary">Comienza gratis, escala cuando lo necesites. Sin permanencia.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="price card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <i class="bi bi-box text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">Gratuito</h5>
                            <p class="text-secondary small">1 vacante • 10 análisis</p>
                            <h3 class="fw-bold my-3">
                                $0 <span class="fs-6 text-secondary fw-normal">/ mes</span>
                            </h3>
                            <ul class="list-unstyled small mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>1 vacante
                                    activa</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>10 análisis de
                                    CVs</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Soporte por
                                    email</li>
                            </ul>
                            <a class="btn btn-outline-primary mt-auto" href="{{ route('register') }}">
                                Comenzar gratis
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="price card h-100 shadow-sm border-primary">
                        <div class="card-body d-flex flex-column">
                            <div class="badge align-self-start bg-primary mb-3">
                                <i class="bi bi-star-fill me-1"></i>Recomendado
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-rocket text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">Profesional</h5>
                            <p class="text-secondary small">Vacantes ilimitadas • Reportes avanzados</p>
                            <h3 class="fw-bold my-3">
                                $19 <span class="fs-6 text-secondary fw-normal">/ mes</span>
                            </h3>
                            <ul class="list-unstyled small mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Vacantes
                                    ilimitadas</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Análisis
                                    ilimitados</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Reportes
                                    avanzados</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Soporte
                                    prioritario</li>
                            </ul>
                            <a class="btn btn-primary mt-auto" href="{{ route('register') }}">
                                Comenzar ahora
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="price card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <i class="bi bi-building text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">Corporativo</h5>
                            <p class="text-secondary small">Integraciones • Soporte dedicado</p>
                            <h3 class="fw-bold my-3">
                                A medida
                            </h3>
                            <ul class="list-unstyled small mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Todo lo de
                                    Profesional</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>API
                                    personalizada</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>White-label
                                </li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Gerente de
                                    cuenta</li>
                            </ul>
                            <a class="btn btn-outline-primary mt-auto" href="#contacto">
                                Solicitar demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
