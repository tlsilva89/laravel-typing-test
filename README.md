# 🚀 Teste de Digitação - Laravel + Vue.js + Vite

Um aplicativo moderno e responsivo para testar velocidade e precisão de digitação, desenvolvido com tecnologias web avançadas.

## 📋 Sobre o Projeto

Este projeto é uma aplicação completa de teste de digitação que permite aos usuários melhorarem suas habilidades de digitação através de uma interface moderna e intuitiva. O sistema oferece análise detalhada de performance, incluindo palavras por minuto (PPM), precisão, análise de erros e sistema de pontuação gamificado.

## ✨ Principais Funcionalidades

### 🎯 Sistema de Teste
- **Teste cronometrado** de 60 segundos
- **Múltiplos textos** sobre programação e tecnologia
- **Conclusão automática** ao completar todo o texto
- **Proteção anti-cola** com bloqueio de Ctrl+V e menu contextual

### 📊 Análise Detalhada
- **Palavras por minuto (PPM)** em tempo real
- **Caracteres por minuto** com precisão
- **Porcentagem de precisão** calculada dinamicamente
- **Contador de erros** com feedback visual
- **Sequência de acertos** consecutivos
- **Barra de progresso** visual

### 🏆 Sistema de Pontuação
- **Pontuação de 0 a 100** baseada em múltiplos fatores:
  - Velocidade (WPM) - 40 pontos
  - Precisão - 30 pontos
  - Conclusão do texto - 20 pontos
  - Bônus de tempo - 10 pontos
  - Penalidades por erros
- **Classificação visual** com emojis e ratings

### 🎨 Interface Moderna
- **Dark mode** completo
- **Design responsivo** otimizado para 1440x900
- **Animações suaves** e transições
- **Tipografia otimizada** para digitação
- **Feedback visual** em tempo real

## 🛠️ Tecnologias Utilizadas

### Backend
- **Laravel 11** - Framework PHP robusto
- **MySQL** - Banco de dados relacional
- **XAMPP** - Ambiente de desenvolvimento local

### Frontend
- **Vue.js 3** - Framework JavaScript reativo
- **Vite** - Build tool moderna e rápida
- **TailwindCSS** - Framework CSS utilitário
- **HeadlessUI** - Componentes acessíveis
- **Heroicons** - Ícones SVG

### Ferramentas de Desenvolvimento
- **PostCSS** - Processamento CSS
- **Autoprefixer** - Compatibilidade de navegadores
- **JetBrains Mono** - Fonte monospace para digitação

## 🚀 Como Executar

### Pré-requisitos
- PHP 8.2+
- Node.js 18+
- XAMPP ou similar
- Composer

## 📱 Funcionalidades Detalhadas

### Sistema de Proteção
- **Bloqueio de cópia/cola** com avisos visuais
- **Desabilitação de atalhos** (Ctrl+C, Ctrl+V, Ctrl+A)
- **Bloqueio de menu contextual** (botão direito)
- **Prevenção de seleção** de texto na interface

### Métricas Avançadas
- **PPM em tempo real** atualizado a cada 500ms
- **Análise de caracteres** (corretos vs incorretos)
- **Taxa de erro** calculada dinamicamente
- **Tempo de conclusão** preciso
- **Porcentagem de completude** do texto

### Interface Responsiva
- **Layout otimizado** para monitores 1440x900
- **Sem necessidade de scroll** em telas padrão
- **Tipografia compacta** para melhor legibilidade
- **Espaçamento otimizado** entre elementos

## 🎯 Resultados e Analytics

O sistema fornece uma análise completa do desempenho:

### Velocidade e Precisão
- Palavras por minuto
- Caracteres por minuto
- Precisão geral
- Maior sequência de acertos

### Análise de Erros
- Total de erros
- Taxa de erro
- Tempo total
- Tempo restante

### Breakdown da Pontuação
- Pontos por velocidade
- Pontos por precisão
- Pontos por conclusão
- Bônus de tempo
- Penalidades por erros

## 🔧 Arquitetura do Projeto

### Estrutura de Arquivos
```
typing-test/
├── app/                    # Lógica do Laravel
├── resources/
│   ├── js/
│   │   └── components/
│   │       └── TypingTest.vue
│   ├── css/
│   │   └── app.css
│   └── views/
│       └── welcome.blade.php
├── public/
│   └── build/             # Assets compilados
├── vite.config.js         # Configuração do Vite
├── tailwind.config.js     # Configuração do TailwindCSS
└── package.json           # Dependências Node.js
```

### Componentes Vue
- **TypingTest.vue** - Componente principal com toda a lógica
- **Sistema reativo** com computed properties
- **Lifecycle hooks** para inicialização
- **Event handlers** para interação do usuário

## 🎨 Design System

### Paleta de Cores
- **Primary**: Azul (#3b82f6) - Elementos principais
- **Accent**: Verde (#22c55e) - Sucessos e acertos
- **Warning**: Vermelho (#ef4444) - Erros e avisos
- **Dark**: Tons de cinza escuro para o tema

### Tipografia
- **Inter** - Interface geral
- **JetBrains Mono** - Área de digitação
- **Espaçamento otimizado** para legibilidade

## 📈 Performance

### Otimizações Implementadas
- **Build otimizado** com Vite
- **Tree shaking** automático
- **Compressão de assets** com gzip
- **Lazy loading** de componentes
- **Cache de navegador** configurado

### Métricas de Performance
- **Tempo de build**: ~2-3 segundos
- **Tamanho do bundle**: ~213KB (comprimido: ~80KB)
- **First Contentful Paint**: <1s
- **Interatividade**: Imediata

