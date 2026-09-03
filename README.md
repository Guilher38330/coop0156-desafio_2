# Desafio Técnico: Sistema de Análise de Crédito (Coop0156)

Aplicação desenvolvida para o desafio técnico de desenvolvedor PHP/Laravel da **Coop0156**, com foco em integração de APIs, regras de negócio financeiras, processamento assíncrono com filas e boas práticas de arquitetura.

---

## 🚀 O Que Foi Implementado

Todas as etapas obrigatórias e diferenciais foram implementados:

1. **CRUD Completo de Clientes (`/api/clientes`)**:
   - 5 operações com validação via `FormRequest` (`StoreClienteRequest`, `UpdateClienteRequest`).
   - Paginação, tratamento de erros e respostas semânticas (`201`, `204`, `404`, `422`).

2. **Integração com Bureau & Regras de Crédito**:
   - Consulta HTTP ao Bureau de Crédito com tratamento de falhas (erro 500, timeout e resposta malformada).
   - Cadastro automático do cliente caso não exista (`DB::transaction`).
   - Validação de renda mínima (< R$ 1.500,00) antes de consultar o Bureau.
   - Aplicação de taxas por score (2,9% a.m. para score ≥ 700 e 4,5% a.m. para score 400–699).
   - Cálculo em 12 parcelas fixas e validação de comprometimento máximo de 30% da renda.

3. **Tela de Simulação e Contratação**:
   - Visualização de condições financeiras em `/simulacao/{id}`.
   - Fluxo de contratação no backend permitindo apenas propostas aprovadas.

4. **Testes Automatizados**:
   - 31 testes automatizados cobrindo aprovações, reprovações, falhas da API externa, filas, rate limit e CRUD de clientes.

5. **⭐ Diferencial: Filas (Laravel Queues)**:
   - A contratação altera o status para `processando_contratacao` e despacha o `ProcessarContratacaoJob` para a fila, finalizando como `contratado` com log estruturado.

6. **⭐ Diferencial: Vá Além (Novas Telas e UX)**:
   - **Gestão de Cooperados (`/clientes`)**: interface visual com busca em tempo real, modais de cadastro/edição/exclusão, histórico de crédito e atalho para simulação.
   - **Dashboard & Histórico (`/analises`)**: KPIs em tempo real (taxa de aprovação, volume financeiro solicitado e contratado) e tabela filtrável.
   - **Melhorias de UX**: máscaras de CPF, Moeda e Telefone, e notificações Toast modernas.

---

## 🛠️ Decisões Técnicas

- **Service Layer**: regras de negócio isoladas em Services (`AnaliseCreditoService`, `ClienteService`, `BureauService`, `DashboardService`), mantendo Controllers finos.
- **Resiliência HTTP**: exceções customizadas (`BureauIndisponivelException` -> 503, `BureauRespostaMalformadaException` -> 502) garantem que a aplicação não trave.
- **Rate Limiting**: proteção de 15 req/min por IP no endpoint de análise de crédito, evitando custos excessivos no Bureau e ataques de DoS.
- **Transações Atômicas**: uso de `DB::transaction` para garantir a integridade entre cliente e análise.
- **Enums Nativos**: `StatusAnalise` e `TipoCredito` como Backed Enums do PHP 8.1+.

---

## ⚙️ Como Executar

### Opção 1: Laravel Sail (Docker)

```bash
# 1. Instalar dependências
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs

# 2. Ambiente e Containers
cp .env.example .env
./vendor/bin/sail up -d

# 3. Chave e Migrations
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate

# 4. Rodar Testes
./vendor/bin/sail artisan test

# 5. Worker da Fila
./vendor/bin/sail artisan queue:work
```
> Acesse em: `http://localhost`

---

### Opção 2: PHP Local (SQLite)

```bash
# 1. Instalar dependências
composer install

# 2. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 3. Banco de dados e migrations
touch database/database.sqlite
php artisan migrate

# 4. Iniciar servidor
php artisan serve
# Acesse: http://localhost:8000

# 5. Executar testes
php artisan test

# 6. Worker da Fila
php artisan queue:work
```

---

## 🧪 Testes Automatizados

Para executar os testes:

```bash
php artisan test
```

Resultado: **31 testes aprovados** (124 asserções) com 100% de sucesso.

---

## 📍 Principais Rotas

### Web
- `/` — Nova solicitação de crédito
- `/clientes` — Gestão de cooperados (clientes)
- `/analises` — Painel de métricas e histórico
- `/simulacao/{id}` — Visualização da simulação e contratação

### API
- `POST /api/analise-credito` — Solicitar análise
- `POST /api/analise-credito/{id}/contratar` — Confirmar contratação
- `GET /api/analises-credito` — Listar análises (com filtros)
- `apiResource('clientes')` — CRUD de cooperados
- `GET /api/clientes/{id}/analises` — Histórico de crédito do cliente
- `GET /api/dashboard/metricas` — Indicadores e KPIs da cooperativa
