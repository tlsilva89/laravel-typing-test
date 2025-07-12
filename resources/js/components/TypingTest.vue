<template>
    <div
        class="min-h-screen bg-gradient-to-br from-dark-950 via-dark-900 to-dark-800 py-4 px-4 dark"
    >
        <div class="max-w-6xl mx-auto">
            <!-- Header Compacto -->
            <div class="text-center mb-6 animate-fade-in">
                <h1
                    class="text-3xl font-bold font-display text-gray-100 mb-2 tracking-tight"
                >
                    Teste de Digitação
                </h1>
                <p class="text-base text-gray-300 font-body max-w-2xl mx-auto">
                    Aprimore sua velocidade e precisão de digitação
                </p>
            </div>

            <!-- Barra de Progresso -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-400">Progresso</span>
                    <span class="text-sm text-gray-400"
                        >{{ Math.round(progress) }}%</span
                    >
                </div>
                <div class="w-full bg-dark-700 rounded-full h-2">
                    <div
                        class="bg-gradient-to-r from-primary-500 to-accent-500 h-2 rounded-full transition-all duration-300"
                        :style="{ width: progress + '%' }"
                    ></div>
                </div>
            </div>

            <!-- Stats Cards Compactos -->
            <div class="grid grid-cols-5 gap-4 mb-6 animate-slide-up">
                <div class="stats-card-compact text-center group">
                    <div
                        class="text-2xl font-bold text-primary-400 mb-1 group-hover:text-primary-300 transition-colors"
                    >
                        {{ currentWpm }}
                    </div>
                    <div
                        class="text-xs font-medium text-gray-400 uppercase tracking-wide"
                    >
                        PPM
                    </div>
                </div>
                <div class="stats-card-compact text-center group">
                    <div
                        class="text-2xl font-bold text-accent-400 mb-1 group-hover:text-accent-300 transition-colors"
                    >
                        {{ accuracy }}%
                    </div>
                    <div
                        class="text-xs font-medium text-gray-400 uppercase tracking-wide"
                    >
                        Precisão
                    </div>
                </div>
                <div class="stats-card-compact text-center group">
                    <div
                        class="text-2xl font-bold text-warning-400 mb-1 group-hover:text-warning-300 transition-colors"
                    >
                        {{ errors }}
                    </div>
                    <div
                        class="text-xs font-medium text-gray-400 uppercase tracking-wide"
                    >
                        Erros
                    </div>
                </div>
                <div class="stats-card-compact text-center group">
                    <div
                        class="text-2xl font-bold text-gray-300 mb-1 group-hover:text-gray-200 transition-colors"
                    >
                        {{ timeLeft }}s
                    </div>
                    <div
                        class="text-xs font-medium text-gray-400 uppercase tracking-wide"
                    >
                        Tempo
                    </div>
                </div>
                <div class="stats-card-compact text-center group">
                    <div
                        class="text-2xl font-bold text-blue-400 mb-1 group-hover:text-blue-300 transition-colors"
                    >
                        {{ remainingChars }}
                    </div>
                    <div
                        class="text-xs font-medium text-gray-400 uppercase tracking-wide"
                    >
                        Restantes
                    </div>
                </div>
            </div>

            <!-- Typing Area Compacta -->
            <div class="typing-container-compact mb-6">
                <!-- Text Display -->
                <div class="text-display-area-compact">
                    <div
                        class="text-display-ultra-compact font-typing text-gray-200 select-none"
                    >
                        <span
                            v-for="(char, index) in displayText"
                            :key="index"
                            :class="getCharClass(index)"
                            class="typing-char"
                        >
                            {{ char }}
                        </span>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="input-area-compact relative">
                    <textarea
                        ref="typingInput"
                        v-model="userInput"
                        @input="handleInput"
                        @keydown="handleKeydown"
                        @paste="handlePaste"
                        @contextmenu="handleContextMenu"
                        :disabled="!isActive || timeLeft === 0"
                        class="typing-textarea-compact"
                        :class="inputClass"
                        placeholder="Clique aqui e comece a digitar..."
                        autocomplete="off"
                        spellcheck="false"
                        rows="5"
                    ></textarea>

                    <!-- Indicadores de Estado -->
                    <div
                        class="flex justify-between items-center mt-2 text-xs text-gray-400"
                    >
                        <span
                            >Caracteres: {{ userInput.length }} /
                            {{ currentText.length }}</span
                        >
                        <span v-if="isActive" class="text-accent-400"
                            >● Ativo</span
                        >
                        <span v-else class="text-gray-500">○ Inativo</span>
                    </div>

                    <div v-if="showError" class="error-indicator">
                        <span class="text-sm font-medium">{{
                            errorMessage
                        }}</span>
                    </div>

                    <div v-if="showPasteWarning" class="paste-warning">
                        <span class="text-sm font-medium"
                            >⚠️ Colar não é permitido!</span
                        >
                    </div>
                </div>
            </div>

            <!-- Controls Compactos -->
            <div class="text-center space-x-4 mb-4">
                <button
                    @click="startTest"
                    :disabled="isActive"
                    class="btn-primary-compact"
                >
                    {{ isActive ? "Em Andamento..." : "Iniciar Teste" }}
                </button>
                <button @click="resetTest" class="btn-secondary-compact">
                    Reiniciar
                </button>
                <button
                    @click="changeText"
                    :disabled="isActive"
                    class="btn-secondary-compact"
                >
                    Novo Texto
                </button>
            </div>

            <!-- Estatísticas em Tempo Real -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div
                    class="bg-dark-800 bg-opacity-60 rounded-xl p-3 text-center"
                >
                    <div class="text-lg font-bold text-primary-400">
                        {{ currentWpm }}
                    </div>
                    <div class="text-xs text-gray-400">PPM Atual</div>
                </div>
                <div
                    class="bg-dark-800 bg-opacity-60 rounded-xl p-3 text-center"
                >
                    <div class="text-lg font-bold text-accent-400">
                        {{ streak }}
                    </div>
                    <div class="text-xs text-gray-400">Sequência</div>
                </div>
                <div
                    class="bg-dark-800 bg-opacity-60 rounded-xl p-3 text-center"
                >
                    <div class="text-lg font-bold text-blue-400">
                        {{ currentCharsPerMin }}
                    </div>
                    <div class="text-xs text-gray-400">Chars/min</div>
                </div>
            </div>

            <!-- Results Modal -->
            <div
                v-if="showResults"
                class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
            >
                <div class="results-modal-expanded">
                    <div class="text-center mb-6">
                        <h2
                            class="text-3xl font-bold font-display text-gray-100 mb-2"
                        >
                            Resultado Final
                        </h2>
                        <p class="text-gray-300">
                            Análise completa do seu desempenho
                        </p>

                        <!-- Pontuação Principal -->
                        <div
                            class="mt-4 p-4 bg-gradient-to-r from-primary-600 to-accent-600 rounded-xl"
                        >
                            <div class="text-4xl font-bold text-white mb-1">
                                {{ finalScore }}/100
                            </div>
                            <div class="text-sm text-gray-200">
                                {{ getScoreRating(finalScore) }}
                            </div>
                        </div>
                    </div>

                    <!-- Estatísticas Detalhadas -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Coluna 1 - Velocidade e Precisão -->
                        <div class="space-y-3">
                            <h3
                                class="text-lg font-semibold text-gray-200 mb-3"
                            >
                                Velocidade e Precisão
                            </h3>

                            <div class="result-item-detailed">
                                <span class="result-label"
                                    >Palavras por minuto</span
                                >
                                <span class="result-value text-primary-400">{{
                                    finalWpm
                                }}</span>
                            </div>

                            <div class="result-item-detailed">
                                <span class="result-label"
                                    >Caracteres por minuto</span
                                >
                                <span class="result-value text-blue-400">{{
                                    finalCharsPerMin
                                }}</span>
                            </div>

                            <div class="result-item-detailed">
                                <span class="result-label">Precisão geral</span>
                                <span class="result-value text-accent-400"
                                    >{{ finalAccuracy }}%</span
                                >
                            </div>

                            <div class="result-item-detailed">
                                <span class="result-label"
                                    >Maior sequência</span
                                >
                                <span class="result-value text-purple-400">{{
                                    maxStreak
                                }}</span>
                            </div>
                        </div>

                        <!-- Coluna 2 - Análise de Erros e Tempo -->
                        <div class="space-y-3">
                            <h3
                                class="text-lg font-semibold text-gray-200 mb-3"
                            >
                                Análise de Erros e Tempo
                            </h3>

                            <div class="result-item-detailed">
                                <span class="result-label">Total de erros</span>
                                <span class="result-value text-warning-400">{{
                                    finalErrors
                                }}</span>
                            </div>

                            <div class="result-item-detailed">
                                <span class="result-label">Taxa de erro</span>
                                <span class="result-value text-orange-400"
                                    >{{ errorRate }}%</span
                                >
                            </div>

                            <div class="result-item-detailed">
                                <span class="result-label">Tempo total</span>
                                <span class="result-value text-purple-400"
                                    >{{ completionTime }}s</span
                                >
                            </div>

                            <div class="result-item-detailed">
                                <span class="result-label">Tempo restante</span>
                                <span class="result-value text-gray-400"
                                    >{{ timeLeft }}s</span
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Estatísticas de Caracteres -->
                    <div class="mb-6 p-4 bg-dark-700 bg-opacity-50 rounded-xl">
                        <h3 class="text-lg font-semibold text-gray-200 mb-3">
                            Análise de Caracteres
                        </h3>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-xl font-bold text-gray-300">
                                    {{ totalChars }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    Total Digitados
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-accent-400">
                                    {{ correctChars }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    Corretos
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-warning-400">
                                    {{ finalErrors }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    Incorretos
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-xl font-bold text-blue-400">
                                    {{ completionPercentage }}%
                                </div>
                                <div class="text-xs text-gray-400">
                                    Completado
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Breakdown da Pontuação -->
                    <div class="mb-6 p-4 bg-dark-700 bg-opacity-30 rounded-xl">
                        <h3 class="text-lg font-semibold text-gray-200 mb-3">
                            Breakdown da Pontuação
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-300"
                                    >Velocidade (WPM)</span
                                >
                                <span class="text-primary-400"
                                    >+{{ wpmPoints }} pts</span
                                >
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">Precisão</span>
                                <span class="text-accent-400"
                                    >+{{ accuracyPoints }} pts</span
                                >
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300">Conclusão</span>
                                <span class="text-blue-400"
                                    >+{{ completionPoints }} pts</span
                                >
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300"
                                    >Bônus de Tempo</span
                                >
                                <span class="text-purple-400"
                                    >+{{ timeBonus }} pts</span
                                >
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-300"
                                    >Penalidade por Erros</span
                                >
                                <span class="text-warning-400"
                                    >-{{ errorPenalty }} pts</span
                                >
                            </div>
                            <hr class="border-gray-600 my-2" />
                            <div class="flex justify-between font-bold">
                                <span class="text-gray-200">Total</span>
                                <span class="text-white"
                                    >{{ finalScore }} pts</span
                                >
                            </div>
                        </div>
                    </div>

                    <button
                        @click="closeResults"
                        class="btn-primary-compact w-full"
                    >
                        Fazer Novo Teste
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TypingTest",
    data() {
        return {
            sampleTexts: [
                "A programação é uma arte que combina lógica e criatividade. Cada linha de código é uma pincelada em uma tela digital, criando soluções elegantes para problemas complexos.",
                "O desenvolvimento web moderno utiliza tecnologias como Vue.js, Laravel e TailwindCSS para criar experiências interativas e responsivas que encantam os usuários.",
                "A prática constante da digitação melhora significativamente a produtividade de desenvolvedores, permitindo que ideias sejam transformadas em código de forma mais eficiente.",
                "JavaScript é uma linguagem versátil que permite criar desde simples scripts até aplicações complexas. Sua flexibilidade e poder fazem dela uma escolha popular entre desenvolvedores.",
                "O design responsivo garante que websites funcionem perfeitamente em dispositivos móveis, tablets e desktops, proporcionando uma experiência consistente para todos os usuários.",
            ],
            currentText: "",
            displayText: [],
            userInput: "",
            currentIndex: 0,
            isActive: false,
            timeLeft: 60,
            startTime: null,
            endTime: null,
            errors: 0,
            totalChars: 0,
            correctChars: 0,
            streak: 0,
            maxStreak: 0,
            timer: null,
            statsTimer: null,
            showError: false,
            showPasteWarning: false,
            errorTimeout: null,
            pasteTimeout: null,
            errorMessage: "",
            showResults: false,
            finalWpm: 0,
            finalAccuracy: 0,
            finalErrors: 0,
            finalCharsPerMin: 0,
            finalScore: 0,
            completionTime: 0,
            currentWpm: 0,
            currentCharsPerMin: 0,
            // Novas variáveis para contabilização completa
            errorRate: 0,
            completionPercentage: 0,
            wpmPoints: 0,
            accuracyPoints: 0,
            completionPoints: 0,
            timeBonus: 0,
            errorPenalty: 0,
        };
    },
    computed: {
        accuracy() {
            if (this.totalChars === 0) return 100;
            return Math.round((this.correctChars / this.totalChars) * 100);
        },
        progress() {
            if (this.currentText.length === 0) return 0;
            return (this.currentIndex / this.currentText.length) * 100;
        },
        remainingChars() {
            return Math.max(0, this.currentText.length - this.currentIndex);
        },
        inputClass() {
            return {
                "input-error": this.showError,
                "input-success":
                    this.userInput && !this.showError && this.isActive,
                "input-default": !this.userInput && !this.showError,
            };
        },
    },
    mounted() {
        this.resetTest();
        this.startStatsTimer();
    },
    methods: {
        calculateCurrentWpm() {
            if (!this.startTime || !this.isActive) return 0;
            const timeElapsedMinutes = (Date.now() - this.startTime) / 60000;
            if (timeElapsedMinutes <= 0) return 0;

            const wordsTyped = this.correctChars / 5;
            return Math.round(wordsTyped / timeElapsedMinutes) || 0;
        },

        calculateCurrentCharsPerMin() {
            if (!this.startTime || !this.isActive) return 0;
            const timeElapsedMinutes = (Date.now() - this.startTime) / 60000;
            if (timeElapsedMinutes <= 0) return 0;

            return Math.round(this.correctChars / timeElapsedMinutes) || 0;
        },

        updateStats() {
            if (this.isActive && this.startTime) {
                this.currentWpm = this.calculateCurrentWpm();
                this.currentCharsPerMin = this.calculateCurrentCharsPerMin();
            }
        },

        calculateFinalWpm() {
            if (!this.startTime || !this.endTime) return 0;
            const timeElapsedMinutes = (this.endTime - this.startTime) / 60000;
            if (timeElapsedMinutes <= 0) return 0;

            const wordsTyped = this.correctChars / 5;
            return Math.round(wordsTyped / timeElapsedMinutes) || 0;
        },

        calculateFinalCharsPerMin() {
            if (!this.startTime || !this.endTime) return 0;
            const timeElapsedMinutes = (this.endTime - this.startTime) / 60000;
            if (timeElapsedMinutes <= 0) return 0;

            return Math.round(this.correctChars / timeElapsedMinutes) || 0;
        },

        calculateDetailedScore() {
            // Cálculo detalhado da pontuação com breakdown

            // Fator 1: WPM (40 pontos máximo)
            this.wpmPoints = Math.min(
                40,
                Math.round((this.finalWpm / 60) * 40)
            );

            // Fator 2: Precisão (30 pontos máximo)
            this.accuracyPoints = Math.round((this.finalAccuracy / 100) * 30);

            // Fator 3: Conclusão do texto (20 pontos máximo)
            this.completionPoints = Math.round(
                (this.currentIndex / this.currentText.length) * 20
            );

            // Fator 4: Tempo de conclusão (10 pontos máximo)
            this.timeBonus =
                this.completionTime < 30
                    ? 10
                    : this.completionTime < 45
                    ? 7
                    : this.completionTime < 60
                    ? 5
                    : 2;

            // Penalidades por erros
            this.errorPenalty = Math.min(20, this.finalErrors * 2);

            // Cálculo final
            const totalScore =
                this.wpmPoints +
                this.accuracyPoints +
                this.completionPoints +
                this.timeBonus -
                this.errorPenalty;

            return Math.max(0, Math.min(100, totalScore));
        },

        calculateAllStats() {
            // Garantir que endTime está definido
            if (!this.endTime) {
                this.endTime = Date.now();
            }

            // Calcular todas as estatísticas finais
            this.finalWpm = this.calculateFinalWpm();
            this.finalCharsPerMin = this.calculateFinalCharsPerMin();
            this.finalAccuracy = this.accuracy;
            this.finalErrors = this.errors;

            // Estatísticas adicionais
            this.errorRate =
                this.totalChars > 0
                    ? Math.round((this.finalErrors / this.totalChars) * 100)
                    : 0;
            this.completionPercentage = Math.round(
                (this.currentIndex / this.currentText.length) * 100
            );

            // Calcular pontuação com breakdown
            this.finalScore = this.calculateDetailedScore();
        },

        getScoreRating(score) {
            if (score >= 90) return "Excelente! 🏆";
            if (score >= 80) return "Muito Bom! 🥇";
            if (score >= 70) return "Bom! 🥈";
            if (score >= 60) return "Regular 🥉";
            if (score >= 50) return "Precisa Melhorar 📚";
            return "Continue Praticando! 💪";
        },

        startTest() {
            this.isActive = true;
            this.startTime = Date.now();
            this.endTime = null;
            this.startTimer();
            this.$refs.typingInput.focus();
        },

        resetTest() {
            this.isActive = false;
            this.timeLeft = 60;
            this.userInput = "";
            this.currentIndex = 0;
            this.errors = 0;
            this.totalChars = 0;
            this.correctChars = 0;
            this.streak = 0;
            this.maxStreak = 0;
            this.startTime = null;
            this.endTime = null;
            this.showError = false;
            this.showResults = false;
            this.currentWpm = 0;
            this.currentCharsPerMin = 0;
            this.completionTime = 0;

            // Reset das novas variáveis
            this.finalWpm = 0;
            this.finalCharsPerMin = 0;
            this.finalAccuracy = 0;
            this.finalErrors = 0;
            this.finalScore = 0;
            this.errorRate = 0;
            this.completionPercentage = 0;
            this.wpmPoints = 0;
            this.accuracyPoints = 0;
            this.completionPoints = 0;
            this.timeBonus = 0;
            this.errorPenalty = 0;

            this.currentText =
                this.sampleTexts[
                    Math.floor(Math.random() * this.sampleTexts.length)
                ];
            this.displayText = this.currentText.split("");

            if (this.timer) {
                clearInterval(this.timer);
            }
        },

        changeText() {
            if (!this.isActive) {
                this.currentText =
                    this.sampleTexts[
                        Math.floor(Math.random() * this.sampleTexts.length)
                    ];
                this.displayText = this.currentText.split("");
                this.userInput = "";
                this.currentIndex = 0;
                this.errors = 0;
                this.totalChars = 0;
                this.correctChars = 0;
                this.streak = 0;
            }
        },

        startTimer() {
            this.timer = setInterval(() => {
                this.timeLeft--;
                if (this.timeLeft <= 0) {
                    this.endTest();
                }
            }, 1000);
        },

        startStatsTimer() {
            this.statsTimer = setInterval(() => {
                this.updateStats();
            }, 500);
        },

        endTest() {
            this.isActive = false;
            this.endTime = Date.now();
            this.completionTime = Math.round(
                (this.endTime - this.startTime) / 1000
            );

            clearInterval(this.timer);

            // Calcular todas as estatísticas finais
            this.calculateAllStats();

            this.showResults = true;
        },

        handleInput() {
            if (!this.isActive) return;

            const inputLength = this.userInput.length;

            if (inputLength > this.currentIndex) {
                // Digitando novo caractere
                const typedChar = this.userInput[this.currentIndex];
                const expectedChar = this.currentText[this.currentIndex];

                this.totalChars++;

                if (typedChar === expectedChar) {
                    this.correctChars++;
                    this.currentIndex++;
                    this.streak++;
                    this.maxStreak = Math.max(this.maxStreak, this.streak);
                    this.hideError();

                    // Verificar se completou o texto
                    if (this.currentIndex >= this.currentText.length) {
                        this.endTest();
                        return;
                    }
                } else {
                    this.errors++;
                    this.currentIndex++;
                    this.streak = 0;
                    this.showErrorEffect("Erro de digitação!");
                }
            } else if (inputLength < this.currentIndex) {
                // Apagando caractere (Backspace)
                this.currentIndex = inputLength;
                this.streak = 0;

                // Recalcular estatísticas
                this.correctChars = 0;
                this.totalChars = 0;
                this.errors = 0;

                for (let i = 0; i < this.userInput.length; i++) {
                    this.totalChars++;
                    if (this.userInput[i] === this.currentText[i]) {
                        this.correctChars++;
                    } else {
                        this.errors++;
                    }
                }
            }
        },

        handleKeydown(event) {
            if (event.ctrlKey || event.metaKey) {
                if (
                    event.key === "v" ||
                    event.key === "c" ||
                    event.key === "x" ||
                    event.key === "a"
                ) {
                    event.preventDefault();
                    this.showPasteWarning = true;
                    this.showErrorEffect("Atalhos não são permitidos!");
                    return;
                }
            }

            if (event.key === "Tab") {
                event.preventDefault();
            }
        },

        handlePaste(event) {
            event.preventDefault();
            this.showPasteWarning = true;
            this.showErrorEffect("Colar não é permitido!");

            if (this.pasteTimeout) {
                clearTimeout(this.pasteTimeout);
            }
            this.pasteTimeout = setTimeout(() => {
                this.showPasteWarning = false;
            }, 3000);
        },

        handleContextMenu(event) {
            event.preventDefault();
            this.showErrorEffect("Menu de contexto desabilitado!");
        },

        getCharClass(index) {
            if (index < this.userInput.length) {
                if (this.userInput[index] === this.currentText[index]) {
                    return "correct";
                } else {
                    return "error";
                }
            } else if (index === this.userInput.length) {
                return "current";
            }
            return "";
        },

        showErrorEffect(message = "Erro detectado!") {
            this.showError = true;
            this.errorMessage = message;
            if (this.errorTimeout) {
                clearTimeout(this.errorTimeout);
            }
            this.errorTimeout = setTimeout(() => {
                this.hideError();
            }, 2000);
        },

        hideError() {
            this.showError = false;
            this.errorMessage = "";
        },

        closeResults() {
            this.showResults = false;
            this.resetTest();
        },
    },
    beforeUnmount() {
        if (this.timer) {
            clearInterval(this.timer);
        }
        if (this.statsTimer) {
            clearInterval(this.statsTimer);
        }
        if (this.errorTimeout) {
            clearTimeout(this.errorTimeout);
        }
        if (this.pasteTimeout) {
            clearTimeout(this.pasteTimeout);
        }
    },
};
</script>
