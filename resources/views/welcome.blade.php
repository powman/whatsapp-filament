<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gerencie múltiplas conexões WhatsApp com facilidade e segurança usando nossa plataforma SaaS.">
    <title>WhatsApp Manager - Gerencie suas Conexões</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        whatsapp: '#25D366',
                        'whatsapp-dark': '#128C7E',
                        'whatsapp-light': '#DCF8C6',
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-hero {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);
        }
        .feature-card:hover {
            transform: translateY(-4px);
            transition: all 0.3s ease;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .bg-gradient-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
        }
    </style>
</head>
<body class="bg-white font-sans antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-whatsapp rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">WhatsApp Manager</span>
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-gray-600 hover:text-emerald-600 transition-colors">Recursos</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-emerald-600 transition-colors">Como Funciona</a>
                    <a href="#benefits" class="text-gray-600 hover:text-emerald-600 transition-colors">Benefícios</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/admin/login" class="text-gray-600 hover:text-emerald-600 font-medium transition-colors">Entrar</a>
                    <a href="/register" class="bg-gradient-whatsapp text-white px-5 py-2 rounded-full font-medium hover:shadow-lg hover:shadow-emerald-200 transition-all">
                        Começar Grátis
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-hero min-h-screen flex items-center pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-2 mb-6 text-sm">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Powered by Evolution API
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Gerencie suas Conexões
                        <span class="text-green-300"> WhatsApp </span>
                        em um só lugar
                    </h1>
                    <p class="text-xl text-green-100 mb-8 leading-relaxed">
                        Plataforma SaaS completa para gerenciar múltiplas instâncias WhatsApp com painel administrativo moderno, webhooks em tempo real e isolamento total de dados por empresa.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/register" class="bg-white text-emerald-700 px-8 py-4 rounded-full font-bold text-lg hover:shadow-xl hover:shadow-emerald-900/30 transition-all text-center">
                            🚀 Começar Gratuitamente
                        </a>
                        <a href="#how-it-works" class="border-2 border-white/40 text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white/10 transition-all text-center">
                            Ver como funciona
                        </a>
                    </div>
                    <div class="flex items-center gap-8 mt-10">
                        <div class="text-center">
                            <div class="text-3xl font-bold">99.9%</div>
                            <div class="text-green-300 text-sm">Uptime</div>
                        </div>
                        <div class="w-px h-10 bg-white/20"></div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">∞</div>
                            <div class="text-green-300 text-sm">Instâncias</div>
                        </div>
                        <div class="w-px h-10 bg-white/20"></div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">100%</div>
                            <div class="text-green-300 text-sm">Isolado</div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Preview -->
                <div class="animate-float hidden lg:block">
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-emerald-100">
                        <!-- Fake Browser Bar -->
                        <div class="bg-gray-100 px-4 py-3 flex items-center gap-2 border-b">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="flex-1 bg-white rounded px-3 py-1 text-xs text-gray-400 ml-2">
                                app.whatsapp-manager.com/admin
                            </div>
                        </div>
                        <!-- Fake Dashboard -->
                        <div class="p-4 bg-gray-50">
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="bg-white rounded-xl p-3 shadow-sm border">
                                    <div class="text-xs text-gray-500 mb-1">Total Conexões</div>
                                    <div class="text-2xl font-bold text-gray-800">12</div>
                                    <div class="text-xs text-emerald-500 mt-1">↑ 3 este mês</div>
                                </div>
                                <div class="bg-white rounded-xl p-3 shadow-sm border">
                                    <div class="text-xs text-gray-500 mb-1">Ativas</div>
                                    <div class="text-2xl font-bold text-emerald-600">9</div>
                                    <div class="text-xs text-emerald-500 mt-1">↑ 75% online</div>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-3 shadow-sm border">
                                <div class="text-xs font-semibold text-gray-700 mb-3">Instâncias</div>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">📱 Suporte</span>
                                        <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">Conectado</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">💼 Vendas</span>
                                        <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">Conectado</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">📢 Marketing</span>
                                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-medium">QR Code</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                    Tudo que você precisa para gerenciar o WhatsApp
                </h2>
                <p class="text-xl text-gray-500 max-w-3xl mx-auto">
                    Uma plataforma completa com todas as ferramentas para escalar sua operação de WhatsApp.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-8 border border-emerald-100">
                    <div class="w-14 h-14 bg-gradient-whatsapp rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Multi-Tenant Seguro</h3>
                    <p class="text-gray-600">Cada empresa tem seus dados completamente isolados. Sem risco de vazamento entre clientes.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100">
                    <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Múltiplas Instâncias</h3>
                    <p class="text-gray-600">Conecte quantos números WhatsApp precisar. Suporte, Vendas, Marketing – tudo em um painel.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 border border-purple-100">
                    <div class="w-14 h-14 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Webhooks em Tempo Real</h3>
                    <p class="text-gray-600">Receba eventos instantâneos de mensagens, conexão e status. Processe com filas automáticas.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-8 border border-orange-100">
                    <div class="w-14 h-14 bg-gradient-to-r from-orange-500 to-amber-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Conexão por QR Code</h3>
                    <p class="text-gray-600">Conecte facilmente via QR Code direto no painel. Sem complicação, sem instalação.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-gradient-to-br from-cyan-50 to-teal-50 rounded-2xl p-8 border border-cyan-100">
                    <div class="w-14 h-14 bg-gradient-to-r from-cyan-500 to-teal-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dashboard Analítico</h3>
                    <p class="text-gray-600">Visualize o status de todas as instâncias em tempo real com estatísticas detalhadas.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-gradient-to-br from-rose-50 to-red-50 rounded-2xl p-8 border border-rose-100">
                    <div class="w-14 h-14 bg-gradient-to-r from-rose-500 to-red-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">API Integrada</h3>
                    <p class="text-gray-600">Integração nativa com Evolution API. Suporte completo a todos os eventos e funcionalidades.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section id="how-it-works" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Como Funciona</h2>
                <p class="text-xl text-gray-500">Comece a usar em minutos</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <div class="hidden md:block absolute top-8 left-1/4 right-1/4 h-0.5 bg-emerald-200"></div>

                <div class="text-center relative">
                    <div class="w-16 h-16 bg-gradient-whatsapp rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg shadow-emerald-200">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Crie sua Conta</h3>
                    <p class="text-gray-600">Registre-se gratuitamente. Um tenant é criado automaticamente para sua empresa com isolamento total.</p>
                </div>

                <div class="text-center relative">
                    <div class="w-16 h-16 bg-gradient-whatsapp rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg shadow-emerald-200">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Adicione Instâncias</h3>
                    <p class="text-gray-600">Crie instâncias WhatsApp para cada departamento ou número de telefone da sua empresa.</p>
                </div>

                <div class="text-center relative">
                    <div class="w-16 h-16 bg-gradient-whatsapp rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg shadow-emerald-200">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Conecte via QR Code</h3>
                    <p class="text-gray-600">Escaneie o QR Code gerado no painel com seu WhatsApp. Pronto! Sua conexão está ativa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">
                        Por que escolher o <span class="text-emerald-600">WhatsApp Manager</span>?
                    </h2>
                    <p class="text-gray-600 mb-8 text-lg">
                        Nossa plataforma foi construída para empresas que precisam de confiabilidade e escala na comunicação via WhatsApp.
                    </p>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Automação Inteligente</h4>
                                <p class="text-gray-600">Processe webhooks automaticamente com filas de trabalho. Nunca perca um evento importante.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Múltiplas Conexões</h4>
                                <p class="text-gray-600">Gerencie dezenas de instâncias WhatsApp em um único dashboard centralizado.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Estabilidade Comprovada</h4>
                                <p class="text-gray-600">Reconexão automática, monitoramento de status e cache para performance máxima.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Segurança Total</h4>
                                <p class="text-gray-600">Isolamento de dados por tenant, autenticação robusta e validação de webhooks.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-emerald-50 to-green-100 rounded-3xl p-8 border border-emerald-200">
                    <div class="text-center mb-6">
                        <div class="text-5xl mb-3">🎯</div>
                        <h3 class="text-2xl font-bold text-gray-900">Comece Hoje</h3>
                        <p class="text-gray-600 mt-2">Sem cartão de crédito. Sem complicação.</p>
                    </div>
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3 bg-white rounded-xl p-3 shadow-sm">
                            <span class="text-emerald-500 text-xl">✅</span>
                            <span class="text-gray-700">Instâncias ilimitadas</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white rounded-xl p-3 shadow-sm">
                            <span class="text-emerald-500 text-xl">✅</span>
                            <span class="text-gray-700">Webhooks em tempo real</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white rounded-xl p-3 shadow-sm">
                            <span class="text-emerald-500 text-xl">✅</span>
                            <span class="text-gray-700">Dashboard completo</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white rounded-xl p-3 shadow-sm">
                            <span class="text-emerald-500 text-xl">✅</span>
                            <span class="text-gray-700">Suporte à Evolution API</span>
                        </div>
                    </div>
                    <a href="/register" class="block w-full bg-gradient-whatsapp text-white text-center py-4 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-emerald-300 transition-all">
                        Criar Conta Gratuita →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-hero py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl sm:text-5xl font-extrabold text-white mb-6">
                Pronto para escalar sua comunicação?
            </h2>
            <p class="text-xl text-green-100 mb-10">
                Junte-se a empresas que já usam o WhatsApp Manager para automatizar e gerenciar suas conexões.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/register" class="bg-white text-emerald-700 px-10 py-4 rounded-full font-bold text-lg hover:shadow-xl hover:shadow-emerald-900/30 transition-all">
                    🚀 Começar Agora — Grátis
                </a>
                <a href="/admin/login" class="border-2 border-white text-white px-10 py-4 rounded-full font-semibold text-lg hover:bg-white/10 transition-all">
                    Já tenho uma conta
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-whatsapp rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold">WhatsApp Manager</span>
                </div>
                <p class="text-sm">© {{ date('Y') }} WhatsApp Manager. Construído com Laravel + FilamentPHP.</p>
                <div class="flex gap-6 text-sm">
                    <a href="/admin/login" class="hover:text-white transition-colors">Login</a>
                    <a href="/register" class="hover:text-white transition-colors">Registrar</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
