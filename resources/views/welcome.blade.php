<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} — Catálogo de Produtos</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts

        <style>
            :root {
                --paper: #f6f4ef;
                --surface: #ffffff;
                --ink: #1b1b18;
                --muted: #6b6a64;
                --line: #e3e0d8;
                --accent: #e8590c;
                --accent-ink: #ffffff;
                --accent-soft: #fdeadf;
                --ok: #2f7d4f;
            }

            @media (prefers-color-scheme: dark) {
                :root {
                    --paper: #121210;
                    --surface: #1b1b18;
                    --ink: #efede6;
                    --muted: #a3a199;
                    --line: #2e2d29;
                    --accent: #ff7a33;
                    --accent-ink: #1b1b18;
                    --accent-soft: #3a2316;
                    --ok: #6cc596;
                }
            }

            * { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background: var(--paper);
                color: var(--ink);
                line-height: 1.55;
                -webkit-font-smoothing: antialiased;
            }

            a { color: inherit; text-decoration: none; }

            .container { width: 100%; max-width: 1120px; margin: 0 auto; padding: 0 20px; }

            /* Cabeçalho */
            .site-header { border-bottom: 1px solid var(--line); background: var(--paper); position: sticky; top: 0; z-index: 10; }
            .site-header .container { display: flex; align-items: center; justify-content: space-between; height: 68px; gap: 16px; }
            .brand { display: flex; align-items: center; gap: 10px; font-weight: 700; letter-spacing: -0.01em; }
            .brand-mark { width: 30px; height: 30px; border-radius: 8px; background: var(--accent); color: var(--accent-ink); display: grid; place-items: center; }
            .nav { display: flex; align-items: center; gap: 22px; font-size: 14px; }
            .nav-links { display: flex; gap: 22px; color: var(--muted); }
            .nav-links a:hover { color: var(--ink); }
            .nav-actions { display: flex; gap: 8px; }

            .btn { display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; border: 1px solid transparent; transition: transform .15s ease, background .15s ease; }
            .btn:hover { transform: translateY(-1px); }
            .btn-primary { background: var(--accent); color: var(--accent-ink); }
            .btn-outline { border-color: var(--line); background: var(--surface); }
            .btn-lg { padding: 13px 22px; font-size: 15px; }

            /* Hero */
            .hero { padding: 72px 0 56px; }
            .hero .container { display: grid; grid-template-columns: 1.05fr 1fr; gap: 56px; align-items: center; }
            .eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--accent); background: var(--accent-soft); padding: 5px 12px; border-radius: 999px; }
            .hero h1 { font-size: clamp(34px, 5vw, 54px); line-height: 1.05; letter-spacing: -0.03em; margin: 18px 0 16px; }
            .hero h1 em { font-style: normal; color: var(--accent); }
            .hero p.lead { font-size: 18px; color: var(--muted); max-width: 46ch; }
            .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
            .hero-stats { display: flex; gap: 32px; margin-top: 36px; padding-top: 24px; border-top: 1px solid var(--line); }
            .hero-stats strong { display: block; font-size: 26px; letter-spacing: -0.02em; }
            .hero-stats span { font-size: 13px; color: var(--muted); }

            /* Prévia do painel */
            .preview { background: var(--surface); border: 1px solid var(--line); border-radius: 16px; box-shadow: 0 24px 60px -30px rgba(27, 27, 24, .35); overflow: hidden; }
            .preview-bar { display: flex; gap: 6px; padding: 12px 16px; border-bottom: 1px solid var(--line); }
            .preview-bar i { width: 10px; height: 10px; border-radius: 50%; background: var(--line); }
            .preview-body { padding: 18px; }
            .preview-title { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-weight: 700; }
            .preview-title small { font-weight: 600; font-size: 12px; color: var(--accent-ink); background: var(--accent); padding: 4px 10px; border-radius: 6px; }
            .preview-row { display: grid; grid-template-columns: 1fr auto auto; gap: 14px; align-items: center; padding: 11px 0; border-top: 1px solid var(--line); font-size: 14px; }
            .preview-row .sku { display: block; font-size: 12px; color: var(--muted); }
            .pill { font-size: 12px; font-weight: 600; padding: 3px 9px; border-radius: 999px; color: var(--ok); background: color-mix(in srgb, var(--ok) 14%, transparent); }
            .pill.low { color: var(--accent); background: var(--accent-soft); }

            /* Seções */
            section.block { padding: 64px 0; }
            .section-head { max-width: 620px; margin-bottom: 36px; }
            .section-head h2 { font-size: clamp(26px, 3.4vw, 36px); letter-spacing: -0.02em; line-height: 1.15; }
            .section-head p { color: var(--muted); margin-top: 10px; }

            .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
            .feature { background: var(--surface); border: 1px solid var(--line); border-radius: 14px; padding: 24px; }
            .feature-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--accent-soft); color: var(--accent); display: grid; place-items: center; margin-bottom: 16px; }
            .feature h3 { font-size: 17px; margin-bottom: 6px; }
            .feature p { color: var(--muted); font-size: 15px; }

            .products { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
            .product { background: var(--surface); border: 1px solid var(--line); border-radius: 14px; padding: 20px; display: flex; flex-direction: column; gap: 10px; }
            .product-top { display: flex; justify-content: space-between; gap: 12px; font-size: 12px; color: var(--muted); }
            .product h3 { font-size: 17px; line-height: 1.3; }
            .product p { color: var(--muted); font-size: 14px; flex: 1; }
            .product-bottom { display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid var(--line); }
            .price { font-size: 19px; font-weight: 700; letter-spacing: -0.01em; }
            .empty { background: var(--surface); border: 1px dashed var(--line); border-radius: 14px; padding: 40px; text-align: center; color: var(--muted); }
            .empty .btn { margin-top: 16px; }

            .steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; counter-reset: step; }
            .step { padding: 24px 0 0; border-top: 2px solid var(--ink); }
            .step::before { counter-increment: step; content: '0' counter(step); display: block; font-weight: 700; color: var(--accent); margin-bottom: 8px; }
            .step h3 { font-size: 17px; margin-bottom: 6px; }
            .step p { color: var(--muted); font-size: 15px; }

            .cta { background: var(--ink); color: var(--paper); border-radius: 20px; padding: 48px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 24px; }
            .cta h2 { font-size: clamp(24px, 3vw, 32px); letter-spacing: -0.02em; max-width: 22ch; line-height: 1.15; }

            .site-footer { border-top: 1px solid var(--line); padding: 28px 0; margin-top: 64px; font-size: 14px; color: var(--muted); }
            .site-footer .container { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 12px; }

            @media (max-width: 900px) {
                .hero .container { grid-template-columns: 1fr; gap: 40px; }
                .features, .products, .steps { grid-template-columns: 1fr 1fr; }
                .nav-links { display: none; }
            }

            @media (max-width: 600px) {
                .hero { padding: 48px 0 32px; }
                .features, .products, .steps { grid-template-columns: 1fr; }
                .cta { padding: 32px 24px; }
                .hero-stats { gap: 20px; }
            }
        </style>
    </head>
    <body>
        <header class="site-header">
            <div class="container">
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand-mark">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8l-9-5-9 5 9 5 9-5z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/></svg>
                    </span>
                    {{ config('app.name', 'Laravel') }}
                </a>

                <nav class="nav">
                    <div class="nav-links">
                        <a href="#recursos">Recursos</a>
                        <a href="#catalogo">Catálogo</a>
                        <a href="#como-funciona">Como funciona</a>
                    </div>

                    @if (Route::has('login'))
                        <div class="nav-actions">
                            @auth
                                <a href="{{ route('products.index') }}" class="btn btn-primary">Gerenciar produtos</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline">Entrar</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary">Criar conta</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container">
                    <div>
                        <span class="eyebrow">● Controle de estoque simples</span>
                        <h1>Seus produtos <em>organizados</em> em um só lugar.</h1>
                        <p class="lead">Cadastre, edite e acompanhe preços e estoque do seu catálogo sem planilhas espalhadas.</p>

                        <div class="hero-actions">
                            @auth
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">Cadastrar produto</a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline btn-lg">Ver meus produtos</a>
                            @else
                                <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="btn btn-primary btn-lg">Começar agora</a>
                                <a href="#catalogo" class="btn btn-outline btn-lg">Ver catálogo</a>
                            @endauth
                        </div>

                        <div class="hero-stats">
                            <div><strong>{{ $activeProductsCount }}</strong><span>produtos ativos</span></div>
                            <div><strong>CRUD</strong><span>completo</span></div>
                            <div><strong>24h</strong><span>acesso online</span></div>
                        </div>
                    </div>

                    <div class="preview" aria-hidden="true">
                        <div class="preview-bar"><i></i><i></i><i></i></div>
                        <div class="preview-body">
                            <div class="preview-title">Produtos <small>+ Novo</small></div>
                            <div class="preview-row"><span>Teclado mecânico<span class="sku">PRD-0001</span></span><span>R$ 349,90</span><span class="pill">58 un.</span></div>
                            <div class="preview-row"><span>Monitor 27"<span class="sku">PRD-0002</span></span><span>R$ 1.299,00</span><span class="pill">21 un.</span></div>
                            <div class="preview-row"><span>Cadeira ergonômica<span class="sku">PRD-0003</span></span><span>R$ 899,00</span><span class="pill low">3 un.</span></div>
                            <div class="preview-row"><span>Mouse sem fio<span class="sku">PRD-0004</span></span><span>R$ 119,90</span><span class="pill">104 un.</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="block" id="recursos">
                <div class="container">
                    <div class="section-head">
                        <h2>Tudo o que você precisa para cuidar do catálogo</h2>
                        <p>Ferramentas diretas, sem complicação.</p>
                    </div>

                    <div class="features">
                        <div class="feature">
                            <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg></div>
                            <h3>Cadastro rápido</h3>
                            <p>Nome, código, categoria, preço e estoque em um formulário só.</p>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg></div>
                            <h3>Busca instantânea</h3>
                            <p>Encontre qualquer item por nome, SKU ou categoria enquanto digita.</p>
                        </div>
                        <div class="feature">
                            <div class="feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-6"/></svg></div>
                            <h3>Estoque sob controle</h3>
                            <p>Veja quantidades e ative ou desative produtos com um clique.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="block" id="catalogo">
                <div class="container">
                    <div class="section-head">
                        <h2>Destaques do catálogo</h2>
                        <p>Os produtos ativos mais recentes cadastrados no sistema.</p>
                    </div>

                    @if ($featuredProducts->isEmpty())
                        <div class="empty">
                            Nenhum produto cadastrado ainda.
                            <div>
                                <a href="{{ auth()->check() ? route('products.create') : route('login') }}" class="btn btn-primary">Cadastrar o primeiro produto</a>
                            </div>
                        </div>
                    @else
                        <div class="products">
                            @foreach ($featuredProducts as $product)
                                <article class="product">
                                    <div class="product-top">
                                        <span>{{ $product->category ?? 'Sem categoria' }}</span>
                                        <span>{{ $product->sku }}</span>
                                    </div>
                                    <h3>{{ $product->name }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit($product->description ?? '', 90) }}</p>
                                    <div class="product-bottom">
                                        <span class="price">{{ $product->formatted_price }}</span>
                                        <span @class(['pill', 'low' => $product->stock < 5])>{{ $product->stock }} un.</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section class="block" id="como-funciona">
                <div class="container">
                    <div class="section-head">
                        <h2>Como funciona</h2>
                    </div>

                    <div class="steps">
                        <div class="step">
                            <h3>Crie sua conta</h3>
                            <p>Cadastro gratuito em menos de um minuto.</p>
                        </div>
                        <div class="step">
                            <h3>Cadastre os produtos</h3>
                            <p>Informe preço, estoque e categoria de cada item.</p>
                        </div>
                        <div class="step">
                            <h3>Gerencie no dia a dia</h3>
                            <p>Edite, busque e exclua sempre que precisar.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="block">
                <div class="container">
                    <div class="cta">
                        <h2>Pronto para organizar seu catálogo?</h2>
                        @auth
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">Ir para os produtos</a>
                        @else
                            <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="btn btn-primary btn-lg">Criar conta grátis</a>
                        @endauth
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container">
                <span>© {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos os direitos reservados.</span>
                <span>Feito com Laravel e Livewire</span>
            </div>
        </footer>
    </body>
</html>
