<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Clientes — Coop0156</title>
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
                <a href="/clientes" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Cooperados (Clientes)
                </a>
                <a href="/analises" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/50 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Histórico & KPIs
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full space-y-6">

        <!-- Top Actions & Title -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-white tracking-tight">Gestão de Cooperados</h2>
                <p class="text-slate-400 text-sm mt-1">Gerencie a base de clientes, acompanhe limites e inicie simulações de crédito com um clique.</p>
            </div>
            <button id="btn-abrir-modal-novo" class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-semibold py-3 px-5 rounded-xl transition-all duration-200 shadow-lg shadow-emerald-500/10 flex items-center gap-2 transform active:scale-98">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Cadastrar Cooperado
            </button>
        </div>

        <!-- Filtros e Busca -->
        <div class="glass-panel rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="campo-busca" placeholder="Buscar por nome, CPF ou e-mail..."
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-950/60 border border-panelBorder rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all">
            </div>

            <div class="flex items-center gap-3 text-xs text-slate-400 self-end sm:self-center">
                <span id="total-registros-badge" class="bg-slate-800/80 px-3 py-1.5 rounded-lg border border-panelBorder">
                    Total: <strong class="text-slate-200" id="num-total-clientes">0</strong> cooperados
                </span>
            </div>
        </div>

        <!-- Tabela de Clientes -->
        <div class="glass-panel rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/40 text-xs uppercase tracking-wider text-slate-400 border-b border-panelBorder">
                        <tr>
                            <th scope="col" class="px-6 py-4">Cooperado</th>
                            <th scope="col" class="px-6 py-4">CPF</th>
                            <th scope="col" class="px-6 py-4">Contato</th>
                            <th scope="col" class="px-6 py-4 text-right">Renda Mensal</th>
                            <th scope="col" class="px-6 py-4 text-center">Cadastrado em</th>
                            <th scope="col" class="px-6 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-clientes-body" class="divide-y divide-panelBorder">
                        <!-- Linhas geradas via JavaScript -->
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <svg class="animate-spin h-6 w-6 text-emerald-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Carregando cooperados...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div id="container-paginacao" class="px-6 py-4 bg-slate-950/30 border-t border-panelBorder flex items-center justify-between text-xs text-slate-400">
                <span id="info-paginacao">Mostrando 0 de 0</span>
                <div class="flex gap-2" id="botoes-paginacao">
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

    <!-- MODAL: Cadastrar / Editar Cliente -->
    <div id="modal-cliente" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="glass-panel rounded-3xl p-6 sm:p-8 max-w-lg w-full mx-4 shadow-2xl relative border border-panelBorder">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modal-cliente-titulo" class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="bg-emerald-500/10 text-emerald-400 p-2 rounded-lg text-sm">👤</span>
                    Cadastrar Cooperado
                </h3>
                <button id="btn-fechar-modal-cliente" class="text-slate-400 hover:text-slate-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="form-cliente" class="space-y-4">
                <input type="hidden" id="cliente-id" name="id">

                <!-- Nome Completo -->
                <div>
                    <label for="cliente-nome" class="block text-xs font-medium text-slate-400 mb-1.5">Nome Completo <span class="text-emerald-400">*</span></label>
                    <input type="text" id="cliente-nome" name="nome" required placeholder="Ex: Maria Clara Souza"
                        class="w-full bg-slate-950/60 border border-panelBorder rounded-xl px-4 py-2.5 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- CPF -->
                    <div>
                        <label for="cliente-cpf" class="block text-xs font-medium text-slate-400 mb-1.5">CPF (11 dígitos) <span class="text-emerald-400">*</span></label>
                        <input type="text" id="cliente-cpf" name="cpf" required placeholder="000.000.000-00" maxlength="14"
                            class="w-full bg-slate-950/60 border border-panelBorder rounded-xl px-4 py-2.5 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all font-mono">
                    </div>

                    <!-- Renda Mensal -->
                    <div>
                        <label for="cliente-renda" class="block text-xs font-medium text-slate-400 mb-1.5">Renda Mensal (R$) <span class="text-emerald-400">*</span></label>
                        <input type="text" id="cliente-renda" name="renda_mensal" required placeholder="R$ 0,00"
                            class="w-full bg-slate-950/60 border border-panelBorder rounded-xl px-4 py-2.5 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- E-mail -->
                    <div>
                        <label for="cliente-email" class="block text-xs font-medium text-slate-400 mb-1.5">E-mail <span class="text-emerald-400">*</span></label>
                        <input type="email" id="cliente-email" name="email" required placeholder="nome@coop.com.br"
                            class="w-full bg-slate-950/60 border border-panelBorder rounded-xl px-4 py-2.5 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all">
                    </div>

                    <!-- Telefone -->
                    <div>
                        <label for="cliente-telefone" class="block text-xs font-medium text-slate-400 mb-1.5">Telefone / WhatsApp</label>
                        <input type="text" id="cliente-telefone" name="telefone" placeholder="(00) 00000-0000" maxlength="15"
                            class="w-full bg-slate-950/60 border border-panelBorder rounded-xl px-4 py-2.5 text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm transition-all">
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex justify-end gap-3 pt-4 border-t border-panelBorder mt-6">
                    <button type="button" id="btn-cancelar-modal-cliente" class="px-5 py-2.5 rounded-xl border border-panelBorder text-slate-400 hover:text-slate-200 hover:border-slate-500 text-sm font-medium transition-all">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-salvar-cliente" class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-emerald-500/10 flex items-center gap-2">
                        <span id="txt-salvar-cliente">Salvar Cooperado</span>
                        <svg id="spinner-salvar-cliente" class="animate-spin h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Histórico de Análises do Cooperado -->
    <div id="modal-historico" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="glass-panel rounded-3xl p-6 sm:p-8 max-w-2xl w-full mx-4 shadow-2xl relative border border-panelBorder max-h-[90vh] flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <span class="bg-emerald-500/10 text-emerald-400 p-2 rounded-lg text-sm">📊</span>
                        Histórico de Crédito
                    </h3>
                    <p id="historico-cliente-subtitulo" class="text-xs text-slate-400 mt-0.5">Análises de crédito realizadas para este cooperado.</p>
                </div>
                <button id="btn-fechar-modal-historico" class="text-slate-400 hover:text-slate-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto flex-grow my-4 pr-1 space-y-3" id="lista-analises-cliente">
                <!-- Lista de análises -->
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-panelBorder mt-auto">
                <button id="btn-simular-para-cliente" class="px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 hover:bg-emerald-500/20 rounded-xl text-xs font-semibold transition-all flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nova Análise para este Cooperado
                </button>
                <button id="btn-fechar-historico-rodape" class="px-5 py-2 rounded-xl border border-panelBorder text-slate-400 hover:text-slate-200 text-xs font-medium transition-all">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL: Confirmar Exclusão -->
    <div id="modal-exclusao" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="glass-panel rounded-3xl p-6 sm:p-8 max-w-md w-full mx-4 shadow-2xl relative border border-red-500/30 text-center">
            <div class="h-16 w-16 bg-red-500/10 text-red-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Confirmar Exclusão</h3>
            <p class="text-slate-400 text-sm mb-6">Tem certeza que deseja remover o cooperado <strong id="nome-cliente-exclusao" class="text-slate-100"></strong>? Esta ação não pode ser desfeita.</p>
            
            <div class="flex justify-center gap-3">
                <button id="btn-cancelar-exclusao" class="px-5 py-2.5 rounded-xl border border-panelBorder text-slate-400 hover:text-slate-200 text-sm font-medium transition-all">
                    Cancelar
                </button>
                <button id="btn-confirmar-exclusao" class="px-6 py-2.5 bg-red-500/80 hover:bg-red-600 text-white rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                    <span id="txt-confirmar-exclusao">Sim, Excluir</span>
                    <svg id="spinner-exclusao" class="animate-spin h-4 w-4 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Script de Gestão de Clientes -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let paginaAtual = 1;
            let clienteSelecionadoParaExclusao = null;
            let clienteSelecionadoParaHistorico = null;
            let timeoutBusca = null;

            // Toast helper
            function mostrarToast(mensagem, tipo = 'sucesso') {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = `p-4 rounded-xl text-sm shadow-xl border flex items-start gap-3 transform transition-all duration-300 pointer-events-auto ${
                    tipo === 'sucesso' 
                        ? 'bg-emerald-950/90 border-emerald-500/30 text-emerald-200' 
                        : tipo === 'erro' 
                        ? 'bg-red-950/90 border-red-500/30 text-red-200' 
                        : 'bg-blue-950/90 border-blue-500/30 text-blue-200'
                }`;

                const icone = tipo === 'sucesso'
                    ? '<svg class="h-5 w-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
                    : '<svg class="h-5 w-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

                toast.innerHTML = `
                    ${icone}
                    <div class="flex-grow">
                        <p class="font-medium">${tipo === 'sucesso' ? 'Sucesso' : 'Atenção'}</p>
                        <p class="text-xs mt-0.5 opacity-90">${mensagem.replace(/\n/g, '<br>')}</p>
                    </div>
                `;

                container.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-10px)';
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }

            // Formatters & Masks
            function formatarCPF(cpf) {
                if (!cpf) return '—';
                const c = cpf.replace(/\D/g, '').padStart(11, '0');
                return c.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }

            function formatarTelefone(tel) {
                if (!tel) return '—';
                const t = tel.replace(/\D/g, '');
                if (t.length === 11) return t.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                if (t.length === 10) return t.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                return tel;
            }

            function formatarMoeda(v) {
                return parseFloat(v || 0).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            }

            function desformatarMoeda(v) {
                if (typeof v === 'number') return v;
                return parseFloat(String(v).replace(/[^\d,]/g, '').replace(',', '.')) || 0;
            }

            // Aplicar máscaras nos inputs
            const inputCpf = document.getElementById('cliente-cpf');
            inputCpf.addEventListener('input', (e) => {
                let v = e.target.value.replace(/\D/g, '').slice(0, 11);
                if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                e.target.value = v;
            });

            const inputTelefone = document.getElementById('cliente-telefone');
            inputTelefone.addEventListener('input', (e) => {
                let v = e.target.value.replace(/\D/g, '').slice(0, 11);
                if (v.length > 10) v = v.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                else if (v.length > 6) v = v.replace(/(\d{2})(\d{4})(\d{1,4})/, '($1) $2-$3');
                else if (v.length > 2) v = v.replace(/(\d{2})(\d{1,5})/, '($1) $2');
                e.target.value = v;
            });

            const inputRenda = document.getElementById('cliente-renda');
            inputRenda.addEventListener('input', (e) => {
                let v = e.target.value.replace(/\D/g, '');
                if (!v) { e.target.value = ''; return; }
                const num = parseFloat(v) / 100;
                e.target.value = num.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            });

            // Carregar Clientes da API
            async function carregarClientes(pagina = 1) {
                paginaAtual = pagina;
                const busca = document.getElementById('campo-busca').value;
                const tbody = document.getElementById('tabela-clientes-body');

                try {
                    const url = `/api/clientes?page=${pagina}&busca=${encodeURIComponent(busca)}`;
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    const dados = await res.json();

                    document.getElementById('num-total-clientes').textContent = dados.total ?? 0;
                    document.getElementById('info-paginacao').textContent = `Mostrando ${dados.from ?? 0} a ${dados.to ?? 0} de ${dados.total ?? 0} cooperados`;

                    renderizarPaginacao(dados);

                    if (!dados.data || dados.data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    Nenhum cooperado encontrado com os termos pesquisados.
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    tbody.innerHTML = dados.data.map(c => `
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-slate-800 border border-panelBorder flex items-center justify-center font-bold text-emerald-400 text-xs">
                                        ${c.nome.charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <div>${c.nome}</div>
                                        <div class="text-xs text-slate-500">${c.email}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-300 text-xs">${formatarCPF(c.cpf)}</td>
                            <td class="px-6 py-4 text-slate-400 text-xs">${formatarTelefone(c.telefone)}</td>
                            <td class="px-6 py-4 text-right font-semibold text-emerald-400">${formatarMoeda(c.renda_mensal)}</td>
                            <td class="px-6 py-4 text-center text-slate-500 text-xs">
                                ${new Date(c.created_at).toLocaleDateString('pt-BR')}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Ver Histórico -->
                                    <button onclick="abrirHistorico(${c.id}, '${c.nome.replace(/'/g, "\\'")}', '${c.cpf}', ${c.renda_mensal})" title="Ver Histórico de Crédito"
                                        class="p-2 rounded-lg text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </button>

                                    <!-- Simular Crédito -->
                                    <a href="/?cpf=${c.cpf}&nome=${encodeURIComponent(c.nome)}&renda=${c.renda_mensal}" title="Nova Simulação para este cooperado"
                                        class="p-2 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>

                                    <!-- Editar -->
                                    <button onclick="abrirEditarCliente(${c.id})" title="Editar Cooperado"
                                        class="p-2 rounded-lg text-slate-400 hover:text-yellow-400 hover:bg-yellow-500/10 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Excluir -->
                                    <button onclick="abrirExcluirCliente(${c.id}, '${c.nome.replace(/'/g, "\\'")}')" title="Excluir Cooperado"
                                        class="p-2 rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join('');

                } catch (e) {
                    mostrarToast('Erro ao carregar lista de cooperados.', 'erro');
                }
            }

            // Renderizar botões de paginação
            function renderizarPaginacao(dados) {
                const container = document.getElementById('botoes-paginacao');
                if (!dados.last_page || dados.last_page <= 1) {
                    container.innerHTML = '';
                    return;
                }

                let html = '';
                for (let i = 1; i <= dados.last_page; i++) {
                    const ativo = i === dados.current_page;
                    html += `
                        <button onclick="carregarClientes(${i})" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all ${
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

            // Busca com debounce
            document.getElementById('campo-busca').addEventListener('input', () => {
                clearTimeout(timeoutBusca);
                timeoutBusca = setTimeout(() => carregarClientes(1), 350);
            });

            // Modal Novo/Editar Cliente
            const modalCliente = document.getElementById('modal-cliente');
            const formCliente = document.getElementById('form-cliente');
            const btnAbrirNovo = document.getElementById('btn-abrir-modal-novo');
            const btnFecharModal = document.getElementById('btn-fechar-modal-cliente');
            const btnCancelarModal = document.getElementById('btn-cancelar-modal-cliente');

            function resetarFormCliente() {
                formCliente.reset();
                document.getElementById('cliente-id').value = '';
                document.getElementById('modal-cliente-titulo').innerHTML = `
                    <span class="bg-emerald-500/10 text-emerald-400 p-2 rounded-lg text-sm">👤</span>
                    Cadastrar Cooperado
                `;
                document.getElementById('txt-salvar-cliente').textContent = 'Salvar Cooperado';
                inputCpf.disabled = false;
            }

            btnAbrirNovo.addEventListener('click', () => {
                resetarFormCliente();
                modalCliente.classList.remove('hidden');
            });

            btnFecharModal.addEventListener('click', () => modalCliente.classList.add('hidden'));
            btnCancelarModal.addEventListener('click', () => modalCliente.classList.add('hidden'));

            // Submissão do Formulário de Cliente (Create / Update)
            formCliente.addEventListener('submit', async (e) => {
                e.preventDefault();
                const btnSalvar = document.getElementById('btn-salvar-cliente');
                const txtSalvar = document.getElementById('txt-salvar-cliente');
                const spinnerSalvar = document.getElementById('spinner-salvar-cliente');

                btnSalvar.disabled = true;
                txtSalvar.classList.add('hidden');
                spinnerSalvar.classList.remove('hidden');

                const id = document.getElementById('cliente-id').value;
                const cpf = inputCpf.value.replace(/\D/g, '');
                const tel = inputTelefone.value.replace(/\D/g, '');
                const renda = desformatarMoeda(inputRenda.value);

                const payload = {
                    nome: document.getElementById('cliente-nome').value,
                    cpf: cpf,
                    email: document.getElementById('cliente-email').value,
                    telefone: tel || null,
                    renda_mensal: renda,
                };

                const url = id ? `/api/clientes/${id}` : '/api/clientes';
                const method = id ? 'PUT' : 'POST';

                try {
                    const res = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    const data = await res.json();

                    if (res.status === 422) {
                        const erros = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                        mostrarToast(erros, 'erro');
                    } else if (res.ok) {
                        mostrarToast(id ? 'Cooperado atualizado com sucesso!' : 'Cooperado cadastrado com sucesso!', 'sucesso');
                        modalCliente.classList.add('hidden');
                        carregarClientes(paginaAtual);
                    } else {
                        mostrarToast(data.message || 'Erro ao processar solicitação.', 'erro');
                    }
                } catch (err) {
                    mostrarToast('Erro de conexão ao salvar cooperado.', 'erro');
                } finally {
                    btnSalvar.disabled = false;
                    txtSalvar.classList.remove('hidden');
                    spinnerSalvar.classList.add('hidden');
                }
            });

            // Abrir Edição
            window.abrirEditarCliente = async function(id) {
                try {
                    const res = await fetch(`/api/clientes/${id}`, { headers: { 'Accept': 'application/json' } });
                    const c = await res.json();

                    resetarFormCliente();
                    document.getElementById('cliente-id').value = c.id;
                    document.getElementById('cliente-nome').value = c.nome;
                    inputCpf.value = formatarCPF(c.cpf);
                    document.getElementById('cliente-email').value = c.email;
                    inputTelefone.value = formatarTelefone(c.telefone);
                    inputRenda.value = parseFloat(c.renda_mensal).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                    document.getElementById('modal-cliente-titulo').innerHTML = `
                        <span class="bg-yellow-500/10 text-yellow-400 p-2 rounded-lg text-sm">✏️</span>
                        Editar Cooperado #${c.id}
                    `;
                    document.getElementById('txt-salvar-cliente').textContent = 'Atualizar Cooperado';

                    modalCliente.classList.remove('hidden');
                } catch (e) {
                    mostrarToast('Erro ao buscar dados do cooperado.', 'erro');
                }
            };

            // Modal Exclusão
            const modalExclusao = document.getElementById('modal-exclusao');
            const btnCancelarExclusao = document.getElementById('btn-cancelar-exclusao');
            const btnConfirmarExclusao = document.getElementById('btn-confirmar-exclusao');

            window.abrirExcluirCliente = function(id, nome) {
                clienteSelecionadoParaExclusao = id;
                document.getElementById('nome-cliente-exclusao').textContent = nome;
                modalExclusao.classList.remove('hidden');
            };

            btnCancelarExclusao.addEventListener('click', () => modalExclusao.classList.add('hidden'));

            btnConfirmarExclusao.addEventListener('click', async () => {
                if (!clienteSelecionadoParaExclusao) return;
                const spinner = document.getElementById('spinner-exclusao');
                const txt = document.getElementById('txt-confirmar-exclusao');

                btnConfirmarExclusao.disabled = true;
                txt.classList.add('hidden');
                spinner.classList.remove('hidden');

                try {
                    const res = await fetch(`/api/clientes/${clienteSelecionadoParaExclusao}`, {
                        method: 'DELETE',
                        headers: { 'Accept': 'application/json' }
                    });

                    if (res.ok || res.status === 204) {
                        mostrarToast('Cooperado removido com sucesso.', 'sucesso');
                        modalExclusao.classList.add('hidden');
                        carregarClientes(paginaAtual);
                    } else {
                        const data = await res.json();
                        mostrarToast(data.message || 'Erro ao excluir cooperado.', 'erro');
                    }
                } catch (e) {
                    mostrarToast('Erro ao conectar com o servidor.', 'erro');
                } finally {
                    btnConfirmarExclusao.disabled = false;
                    txt.classList.remove('hidden');
                    spinner.classList.add('hidden');
                }
            });

            // Modal Histórico
            const modalHistorico = document.getElementById('modal-historico');
            const btnFecharHistorico = document.getElementById('btn-fechar-modal-historico');
            const btnFecharHistoricoRodape = document.getElementById('btn-fechar-historico-rodape');
            const btnSimularParaCliente = document.getElementById('btn-simular-para-cliente');

            btnFecharHistorico.addEventListener('click', () => modalHistorico.classList.add('hidden'));
            btnFecharHistoricoRodape.addEventListener('click', () => modalHistorico.classList.add('hidden'));

            window.abrirHistorico = async function(id, nome, cpf, renda) {
                clienteSelecionadoParaHistorico = { id, nome, cpf, renda };
                document.getElementById('historico-cliente-subtitulo').textContent = `Cooperado: ${nome} (CPF: ${formatarCPF(cpf)})`;
                const container = document.getElementById('lista-analises-cliente');
                container.innerHTML = '<p class="text-center text-slate-500 py-6 text-sm">Carregando histórico...</p>';
                modalHistorico.classList.remove('hidden');

                try {
                    const res = await fetch(`/api/clientes/${id}/analises`, { headers: { 'Accept': 'application/json' } });
                    const analises = await res.json();

                    if (!analises || analises.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-8 glass-panel rounded-2xl border-dashed">
                                <p class="text-slate-400 text-sm font-medium">Nenhuma análise registrada</p>
                                <p class="text-slate-500 text-xs mt-1">Este cooperado ainda não solicitou crédito.</p>
                            </div>
                        `;
                        return;
                    }

                    container.innerHTML = analises.map(a => {
                        const statusConfig = {
                            'aprovado': { bg: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20', label: 'Aprovado' },
                            'contratado': { bg: 'bg-blue-500/10 text-blue-400 border-blue-500/20', label: 'Contratado' },
                            'processando_contratacao': { bg: 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20', label: 'Processando' },
                            'reprovado': { bg: 'bg-red-500/10 text-red-400 border-red-500/20', label: 'Reprovado' },
                            'pendente': { bg: 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20', label: 'Pendente' },
                        }[a.status] || { bg: 'bg-slate-800 text-slate-300 border-panelBorder', label: a.status };

                        return `
                            <div class="p-4 rounded-xl bg-slate-950/40 border border-panelBorder flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border ${statusConfig.bg}">
                                            ${statusConfig.label}
                                        </span>
                                        <span class="text-xs text-slate-400 font-mono">#${a.id}</span>
                                        <span class="text-xs text-slate-500">${new Date(a.created_at).toLocaleString('pt-BR')}</span>
                                    </div>
                                    <div class="text-sm font-semibold text-slate-200">
                                        ${formatarMoeda(a.valor_solicitado)} <span class="text-xs font-normal text-slate-400">(${a.tipo_credito})</span>
                                    </div>
                                    ${a.motivo_rejeicao ? `<p class="text-xs text-red-400">Motivo: ${a.motivo_rejeicao}</p>` : ''}
                                    ${a.valor_parcela ? `<p class="text-xs text-emerald-400">12x de ${formatarMoeda(a.valor_parcela)} (Taxa: ${a.taxa_juros}% a.m.)</p>` : ''}
                                </div>
                                <div>
                                    ${(a.status === 'aprovado' || a.status === 'contratado') ? `
                                        <a href="/simulacao/${a.id}" class="inline-flex items-center gap-1 text-xs text-emerald-400 hover:text-emerald-300 font-medium">
                                            Ver Detalhes &rarr;
                                        </a>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }).join('');

                } catch (e) {
                    container.innerHTML = '<p class="text-center text-red-400 py-6 text-sm">Erro ao carregar histórico.</p>';
                }
            };

            btnSimularParaCliente.addEventListener('click', () => {
                if (clienteSelecionadoParaHistorico) {
                    const { cpf, nome, renda } = clienteSelecionadoParaHistorico;
                    window.location.href = `/?cpf=${cpf}&nome=${encodeURIComponent(nome)}&renda=${renda}`;
                }
            });

            // Expor função global para paginação
            window.carregarClientes = carregarClientes;

            // Iniciar listagem
            carregarClientes(1);
        });
    </script>
</body>
</html>
