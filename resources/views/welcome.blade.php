@extends('layouts.app')

@section('content')

  <section class="hero section-padding">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6">
          <span class="badge rounded-pill text-bg-light-subtle accent-badge mb-3">Automatiza tu selección</span>
          <p>
            a
          </p>
          <h1 class="display-5 fw-bold lh-tight mb-3">
            Contrata mejor y más rápido con <span class="text-gradient">IA</span>
          </h1>
          <p class="lead text-secondary mb-4">
            Publica vacantes, recibe postulaciones y deja que Hirewise calcule el
            <strong>nivel de compatibilidad</strong> de cada candidato.
          </p>

          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Comenzar gratis</a>
            <a href="#caracteristicas" class="btn btn-outline-primary btn-lg px-4">Ver características</a>
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
              <span class="small text-uppercase text-secondary">Demo</span>
              <span class="badge bg-primary-subtle text-primary-emphasis">Tiempo real</span>
            </div>
            <div class="progress my-2" role="progressbar" aria-label="Compatibilidad promedio">
              <div class="progress-bar" style="width: 78%">Compatibilidad promedio 78%</div>
            </div>
            <div class="d-flex gap-3 mt-3 small">
              <span class="chip">Vacantes activas: 4</span>
              <span class="chip">Candidatos analizados: 15</span>
              <span class="chip">Entrevistas: 3</span>
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
        <h2 class="fw-bold">Características clave</h2>
        <p class="text-secondary">Minimalismo, claridad y foco en resultados.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature card h-100 shadow-sm">
            <div class="card-body">
              <div class="icon-bubble mb-3"><i class="bi bi-magic"></i></div>
              <h5 class="card-title fw-semibold">Matching inteligente</h5>
              <p class="card-text text-secondary">Embeddings semánticos para comparar requisitos con CVs y rankear candidatos.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature card h-100 shadow-sm">
            <div class="card-body">
              <div class="icon-bubble mb-3"><i class="bi bi-bar-chart-line"></i></div>
              <h5 class="card-title fw-semibold">Métricas claras</h5>
              <p class="card-text text-secondary">Panel con compatibilidad, embudos y tiempos promedio de contratación.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="feature card h-100 shadow-sm">
            <div class="card-body">
              <div class="icon-bubble mb-3"><i class="bi bi-people"></i></div>
              <h5 class="card-title fw-semibold">Flujo simple</h5>
              <p class="card-text text-secondary">Para empresas y candidatos, con experiencia pulida y profesional.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CÓMO FUNCIONA -->
  <section id="como-funciona" class="section-padding">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6 order-lg-2">
          <div class="steps-card rounded-4 p-4 p-lg-5 shadow-sm">
            <ol class="steps">
              <li><strong>Crea tu cuenta</strong> como empresa o candidato.</li>
              <li><strong>Publica una vacante</strong> o completa tu perfil.</li>
              <li><strong>Deja que la IA</strong> calcule compatibilidades.</li>
              <li><strong>Gestiona</strong> entrevistas y decisiones desde el panel.</li>
            </ol>
          </div>
        </div>
        <div class="col-lg-6 order-lg-1">
          <h2 class="fw-bold mb-3">De cero a contratación en minutos</h2>
          <p class="text-secondary">Un diseño minimalista con foco en la acción: menos clics, más resultados.</p>
          <a href="{{ route('register') }}" class="btn btn-primary mt-2">Probar ahora</a>
        </div>
      </div>
    </div>
  </section>

  <!-- PLANES -->
  <section id="precios" class="section-padding bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Planes</h2>
        <p class="text-secondary">Comienza gratis, escala cuando lo necesites.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="price card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
              <h5 class="fw-semibold mb-1">Gratuito</h5>
              <p class="text-secondary">1 vacante • 10 análisis</p>
              <h3 class="fw-bold my-3">$0</h3>
              <a class="btn btn-outline-primary mt-auto" href="{{ route('register') }}">Elegir</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="price card h-100 shadow-sm border-primary">
            <div class="card-body d-flex flex-column">
              <div class="badge align-self-start bg-primary">Recomendado</div>
              <h5 class="fw-semibold mt-2 mb-1">Profesional</h5>
              <p class="text-secondary">Vacantes ilimitadas • Reportes</p>
              <h3 class="fw-bold my-3">$19 <span class="fs-6 text-secondary">/ mes</span></h3>
              <a class="btn btn-primary mt-auto" href="{{ route('register') }}">Comenzar</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="price card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
              <h5 class="fw-semibold mb-1">Corporativo</h5>
              <p class="text-secondary">Integraciones y soporte dedicado</p>
              <h3 class="fw-bold my-3">A medida</h3>
              <a class="btn btn-outline-primary mt-auto" href="#contacto">Solicitar demo</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
