<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico & Dashboard — Coop0156</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        coop: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            900: '#14532d',
                        },
                        darkBg: '#0b0f19',
                        panelBg: '#131c2e',
                        panelBorder: '#1e2d4a',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0b0f19;
            background-image: 
                radial-gradient(at 0% 0%, hsla(142, 70%, 15%, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(220, 70%, 15%, 0.15) 0px, transparent 50%);
        }
        .glass-panel {
            background: rgba(19, 28, 46, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 45, 74, 0.6);
        }
    </style>
</head>
<body class="text-slate-200 min-h-screen flex flex-col font-sans">

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none"></div>

    <!-- Header / Navbar -->
    <header class="border-b border-panelBorder/50 py-4 glass-panel sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-green-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-green-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-emerald-400 to-green-300 bg-clip-text text-transparent">Coop0156</h1>
                        <p class="text-xs text-slate-400">Plataforma de Crédito Cooperativo</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex items-center gap-1 sm:gap-2">
                <a href="/" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Simular Crédito
                </a>
                <a href="/clientes" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Cooperados (Clientes)
                </a>
                <a href="/analises" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Histórico & KPIs
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-8">

        <!-- Header da Página -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-white tracking-tight">Painel de Métricas & Histórico</h2>
                <p class="text-slate-400 text-sm mt-1">Acompanhe os indicadores consolidados da cooperativa e todas as simulações realizadas.</p>
            </div>
            <a href="/" class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-semibold py-3 px-5 rounded-xl transition-all duration-200 shadow-lg shadow-emerald-500/10 flex items-center gap-2 transform active:scale-98">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Simulação
            </a>
        </div>

        <!-- Cards de Métricas (KPIs) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" id="container-kpis">
            
            <!-- Card 1: Total de Solicitações -->
            <div class="glass-panel rounded-2xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Solicitações</p>
                    <span class="p-2 rounded-xl bg-blue-500/10 text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                </div>
                <p id="kpi-total-solicitacoes" class="text-3xl font-bold text-white mt-4">0</p>
                <div class="mt-2 flex items-center gap-2 text-xs text-slate-400">
                    <span id="kpi-total-clientes" class="font-medium text-slate-300">0</span> cooperados na base
                </div>
            </div>

            <!-- Card 2: Taxa de Aprovação -->
            <div class="glass-panel rounded-2xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Taxa de Aprovação</p>
                    <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <p id="kpi-taxa-aprovacao" class="text-3xl font-bold text-emerald-400 mt-4">0%</p>
                <div class="w-full bg-slate-800 rounded-full h-1.5 mt-3 overflow-hidden">
                    <div id="kpi-barra-aprovacao" class="bg-gradient-to-r from-emerald-500 to-green-400 h-1.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
            </div>

            <!-- Card 3: Volume Solicitado -->
            <div class="glass-panel rounded-2xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Volume Solicitado</p>
                    <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                </div>
                <p id="kpi-volume-solicitado" class="text-2xl font-bold text-slate-100 mt-4">R$ 0,00</p>
                <div class="mt-2 text-xs text-slate-400">
                    Aprovado: <span id="kpi-volume-aprovado" class="text-emerald-400 font-semibold">R$ 0,00</span>
                </div>
            </div>

            <!-- Card 4: Volume Contratado -->
            <div class="glass-panel rounded-2xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Volume Formalizado</p>
                    <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <p id="kpi-volume-contratado" class="text-2xl font-bold text-white mt-4">R$ 0,00</p>
                <div class="mt-2 text-xs text-slate-400">
                    <span id="kpi-total-contratadas" class="text-blue-400 font-semibold">0</span> contratos efetivados
                </div>
            </div>

        </div>

        <!-- Filtros e Tabs de Status -->
        <div class="glass-panel rounded-2xl p-4 flex flex-col lg:flex-row items-center justify-between gap-4">
            
            <!-- Tabs -->
            <div class="flex flex-wrap items-center gap-1.5 w-full lg:w-auto" id="container-tabs">
                <button onclick="filtrarStatus('')" class="tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition-all bg-emerald-500/20 text-emerald-400 border border-emerald-500/30" data-status="">
                    Todas
                </button>
                <button onclick="filtrarStatus('aprovado')" class="tab-btn px-4 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-slate-200 transition-all" data-status="aprovado">
                    Aprovadas
                </button>
                <button onclick="filtrarStatus('contratado')" class="tab-btn px-4 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-slate-200 transition-all" data-status="contratado">
                    Contratadas
                </button>
                <button onclick="filtrarStatus('reprovado')" class="tab-btn px-4 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-slate-200 transition-all" data-status="reprovado">
                    Reprovadas
                </button>
                <button onclick="filtrarStatus('processando_contratacao')" class="tab-btn px-4 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-slate-200 transition-all" data-status="processando_contratacao">
                    Processando
                </button>
            </div>

            <!-- Busca -->
            <div class="relative w-full lg:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="campo-busca-analises" placeholder="Buscar por proponente ou CPF..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-950/60 border border-panelBorder rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-xs transition-all">
            </div>

        </div>

        <!-- Tabela de Análises -->
        <div class="glass-panel rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/40 text-xs uppercase tracking-wider text-slate-400 border-b border-panelBorder">
                        <tr>
                            <th scope="col" class="px-6 py-4">ID & Data</th>
                            <th scope="col" class="px-6 py-4">Proponente / CPF</th>
                            <th scope="col" class="px-6 py-4">Tipo & Valor</th>
                            <th scope="col" class="px-6 py-4 text-center">Score</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Condições</th>
                            <th scope="col" class="px-6 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-analises-body" class="divide-y divide-panelBorder">
                        <!-- Linhas geradas via JavaScript -->
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <svg class="animate-spin h-6 w-6 text-emerald-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Carregando análises de crédito...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div id="container-paginacao-analises" class="px-6 py-4 bg-slate-950/30 border-t border-panelBorder flex items-center justify-between text-xs text-slate-400">
                <span id="info-paginacao-analises">Mostrando 0 de 0</span>
                <div class="flex gap-2" id="botoes-paginacao-analises">
                    <!-- Botões de página -->
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-panelBorder/40 py-6 text-center text-xs text-slate-600 mt-auto">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; 2026 CoopCred. Todos os direitos reservados. Desafio Técnico Laravel.</p>
        </div>
    </footer>

    <!-- MODAL: Detalhes da Análise -->
    <div id="modal-detalhes" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="glass-panel rounded-3xl p-6 sm:p-8 max-w-lg w-full mx-4 shadow-2xl relative border border-panelBorder">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="bg-emerald-500/10 text-emerald-400 p-2 rounded-lg text-sm">📋</span>
                    Detalhes da Análise #<span id="detalhe-id"></span>
                </h3>
                <button id="btn-fechar-modal-detalhes" class="text-slate-400 hover:text-slate-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4 text-sm divide-y divide-panelBorder" id="detalhe-conteudo">
                <!-- Conteúdo preenchido dinamicamente -->
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-panelBorder mt-6" id="detalhe-rodape">
                <button id="btn-fechar-detalhes-rodape" class="px-5 py-2.5 rounded-xl border border-panelBorder text-slate-400 hover:text-slate-200 text-xs font-medium transition-all">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <!-- Script de Dashboard e Histórico -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let paginaAtual = 1;
            let statusFiltro = '';
            let timeoutBusca = null;

            // Formatação
            function formatarCPF(cpf) {
                if (!cpf) return '—';
                const c = cpf.replace(/\D/g, '').padStart(11, '0');
                return c.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }

            function formatarMoeda(v) {
                return parseFloat(v || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            }

            // Carregar Métricas do Dashboard
            async function carregarMetricas() {
                try {
                    const res = await fetch('/api/dashboard/metricas', { headers: { 'Accept': 'application/json' } });
                    const m = await res.json();

                    document.getElementById('kpi-total-solicitacoes').textContent = m.total_solicitacoes ?? 0;
                    document.getElementById('kpi-total-clientes').textContent = m.total_clientes ?? 0;
                    document.getElementById('kpi-taxa-aprovacao').textContent = `${m.taxa_aprovacao ?? 0}%`;
                    document.getElementById('kpi-barra-aprovacao').style.width = `${Math.min(m.taxa_aprovacao ?? 0, 100)}%`;
                    document.getElementById('kpi-volume-solicitado').textContent = formatarMoeda(m.volume_solicitado);
                    document.getElementById('kpi-volume-aprovado').textContent = formatarMoeda(m.volume_aprovado);
                    document.getElementById('kpi-volume-contratado').textContent = formatarMoeda(m.volume_contratado);
                    document.getElementById('kpi-total-contratadas').textContent = m.total_contratadas ?? 0;
                } catch (e) {
                    console.error('Erro ao carregar métricas:', e);
                }
            }

            // Carregar Tabela de Análises
            async function carregarAnalises(pagina = 1) {
                paginaAtual = pagina;
                const busca = document.getElementById('campo-busca-analises').value;
                const tbody = document.getElementById('tabela-analises-body');

                try {
                    const url = `/api/analises-credito?page=${pagina}&status=${statusFiltro}&busca=${encodeURIComponent(busca)}`;
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    const dados = await res.json();

                    document.getElementById('info-paginacao-analises').textContent = `Mostrando ${dados.from ?? 0} a ${dados.to ?? 0} de ${dados.total ?? 0} análises`;
                    renderizarPaginacao(dados);

                    if (!dados.data || dados.data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    Nenhuma análise de crédito encontrada para os filtros aplicados.
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    tbody.innerHTML = dados.data.map(a => {
                        const statusBadge = {
                            'aprovado': '<span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Aprovado</span>',
                            'contratado': '<span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">Contratado</span>',
                            'processando_contratacao': '<span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Processando</span>',
                            'reprovado': '<span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">Reprovado</span>',
                            'pendente': '<span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Pendente</span>',
                        }[a.status] || `<span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300">${a.status}</span>`;

                        return `
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-mono text-xs text-emerald-400 font-semibold">#${a.id}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">${new Date(a.created_at).toLocaleString('pt-BR')}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-100">${a.nome}</div>
                                    <div class="font-mono text-xs text-slate-500 mt-0.5">${formatarCPF(a.cpf)}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-200">${formatarMoeda(a.valor_solicitado)}</div>
                                    <div class="text-xs text-slate-400 capitalize">${a.tipo_credito}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold font-mono ${a.score >= 700 ? 'text-emerald-400' : a.score >= 400 ? 'text-yellow-400' : 'text-red-400'}">
                                        ${a.score ?? '—'}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    ${statusBadge}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    ${a.valor_parcela ? `
                                        <div class="font-semibold text-emerald-400">12x ${formatarMoeda(a.valor_parcela)}</div>
                                        <div class="text-xs text-slate-500">${a.taxa_juros}% a.m.</div>
                                    ` : `
                                        <div class="text-xs text-red-400 truncate max-w-[160px]" title="${a.motivo_rejeicao || ''}">${a.motivo_rejeicao || '—'}</div>
                                    `}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        ${(a.status === 'aprovado' || a.status === 'contratado') ? `
                                            <a href="/simulacao/${a.id}" class="px-3 py-1.5 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 text-xs font-medium transition-all" title="Ver Simulação">
                                                Simulação
                                            </a>
                                        ` : `
                                            <button onclick="verDetalhes(${JSON.stringify(a).replace(/"/g, '&quot;')})" class="px-3 py-1.5 rounded-lg border border-panelBorder text-slate-400 hover:text-slate-200 text-xs font-medium transition-all">
                                                Detalhes
                                            </button>
                                        `}
                                    </div>
                                </td>
                            </tr>
                        `;
                    }).join('');

                } catch (e) {
                    console.error('Erro ao carregar análises:', e);
                }
            }

            // Renderizar paginação
            function renderizarPaginacao(dados) {
                const container = document.getElementById('botoes-paginacao-analises');
                if (!dados.last_page || dados.last_page <= 1) {
                    container.innerHTML = '';
                    return;
                }

                let html = '';
                for (let i = 1; i <= dados.last_page; i++) {
                    const ativo = i === dados.current_page;
                    html += `
                        <button onclick="carregarAnalises(${i})" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all ${
                            ativo 
                                ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' 
                                : 'bg-slate-900 border border-panelBorder text-slate-400 hover:text-slate-200'
                        }">
                            ${i}
                        </button>
                    `;
                }
                container.innerHTML = html;
            }

            // Filtro por tabs
            window.filtrarStatus = function(status) {
                statusFiltro = status;
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    if (btn.dataset.status === status) {
                        btn.className = 'tab-btn px-4 py-2 rounded-xl text-xs font-semibold transition-all bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
                    } else {
                        btn.className = 'tab-btn px-4 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-slate-200 transition-all';
                    }
                });
                carregarAnalises(1);
            };

            // Busca com debounce
            document.getElementById('campo-busca-analises').addEventListener('input', () => {
                clearTimeout(timeoutBusca);
                timeoutBusca = setTimeout(() => carregarAnalises(1), 350);
            });

            // Modal Detalhes
            const modalDetalhes = document.getElementById('modal-detalhes');
            const btnFecharDetalhes = document.getElementById('btn-fechar-modal-detalhes');
            const btnFecharDetalhesRodape = document.getElementById('btn-fechar-detalhes-rodape');

            btnFecharDetalhes.addEventListener('click', () => modalDetalhes.classList.add('hidden'));
            btnFecharDetalhesRodape.addEventListener('click', () => modalDetalhes.classList.add('hidden'));

            window.verDetalhes = function(a) {
                document.getElementById('detalhe-id').textContent = a.id;
                const container = document.getElementById('detalhe-conteudo');

                container.innerHTML = `
                    <div class="flex justify-between pt-2">
                        <span class="text-slate-400">Proponente</span>
                        <span class="font-medium text-slate-100">${a.nome}</span>
                    </div>
                    <div class="flex justify-between pt-3">
                        <span class="text-slate-400">CPF</span>
                        <span class="font-mono text-slate-100">${formatarCPF(a.cpf)}</span>
                    </div>
                    <div class="flex justify-between pt-3">
                        <span class="text-slate-400">Renda Mensal Declarada</span>
                        <span class="font-medium text-slate-100">${formatarMoeda(a.renda_mensal)}</span>
                    </div>
                    <div class="flex justify-between pt-3">
                        <span class="text-slate-400">Tipo de Crédito</span>
                        <span class="capitalize text-slate-100">${a.tipo_credito}</span>
                    </div>
                    <div class="flex justify-between pt-3">
                        <span class="text-slate-400">Valor Solicitado</span>
                        <span class="font-bold text-slate-100">${formatarMoeda(a.valor_solicitado)}</span>
                    </div>
                    <div class="flex justify-between pt-3">
                        <span class="text-slate-400">Score de Crédito</span>
                        <span class="font-bold font-mono text-slate-100">${a.score ?? '—'}</span>
                    </div>
                    <div class="flex justify-between pt-3">
                        <span class="text-slate-400">Status</span>
                        <span class="font-bold uppercase ${a.status === 'aprovado' || a.status === 'contratado' ? 'text-emerald-400' : 'text-red-400'}">${a.status}</span>
                    </div>
                    ${a.motivo_rejeicao ? `
                        <div class="pt-3">
                            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-3 text-red-300 text-xs">
                                <strong>Motivo da Recusa:</strong><br>${a.motivo_rejeicao}
                            </div>
                        </div>
                    ` : ''}
                    ${a.valor_parcela ? `
                        <div class="flex justify-between pt-3">
                            <span class="text-slate-400">Parcela Mensal (12x)</span>
                            <span class="font-bold text-emerald-400">${formatarMoeda(a.valor_parcela)}</span>
                        </div>
                        <div class="flex justify-between pt-3">
                            <span class="text-slate-400">Taxa de Juros</span>
                            <span class="font-medium text-emerald-400">${a.taxa_juros}% a.m.</span>
                        </div>
                    ` : ''}
                `;

                modalDetalhes.classList.remove('hidden');
            };

            window.carregarAnalises = carregarAnalises;

            // Inicializar
            carregarMetricas();
            carregarAnalises(1);
        });
    </script>
</body>
</html>
