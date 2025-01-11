document.addEventListener('DOMContentLoaded', function () {
    if (window.VoiceController) {
        console.log('VoiceController already initialized');
        return;
    }

    window.VoiceController = {
        recognition: null,
        isListening: false,
        transcript: '',
        toggleButton: null,

        init: function () {
            if (document.getElementById('toggleVoice')) {
                console.log('Voice button already exists');
                this.toggleButton = document.getElementById('toggleVoice');
            } else {
                this.createVoiceControlButton();
                this.toggleButton = document.getElementById('toggleVoice');
            }
            this.initSpeechRecognition();
            console.log('Voice control initialized');
        },

        createVoiceControlButton: function () {
            const header = document.querySelector('header');
            if (header) {
                const voiceButton = document.createElement('button');
                voiceButton.id = 'toggleVoice';
                voiceButton.className = 'ml-4 p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white transition-colors flex items-center gap-2';
                voiceButton.innerHTML = `
                    <span class="mic-icon">🎤</span>
                    <span class="voice-text text-sm">Voice Control</span>
                `;
                header.appendChild(voiceButton);
            }
        },

        initSpeechRecognition: function () {
            if (!('SpeechRecognition' in window || 'webkitSpeechRecognition' in window)) {
                console.error('Speech recognition not supported');
                return;
            }

            this.recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            this.recognition.lang = 'id-ID';
            this.recognition.continuous = true;

            this.recognition.onstart = () => this.onRecognitionStart();
            this.recognition.onend = () => this.onRecognitionEnd();
            this.recognition.onerror = (event) => this.onRecognitionError(event);
            this.recognition.onresult = (event) => this.onRecognitionResult(event);

            if (this.toggleButton) {
                this.toggleButton.addEventListener('click', () => this.toggleVoiceRecognition());
            } else {
                console.error('Toggle button not found');
            }
        },

        toggleVoiceRecognition: function () {
            if (this.isListening) {
                this.recognition.stop();
            } else {
                navigator.mediaDevices
                    .getUserMedia({ audio: true })
                    .then((stream) => {
                        stream.getTracks().forEach((track) => track.stop());
                        this.recognition.start();
                    })
                    .catch((error) => {
                        console.error('Error accessing microphone:', error);
                        this.showFeedback('Tidak dapat mengakses mikrofon. Mohon berikan izin.', 'error');
                    });
            }
        },

        readQuizContent: function() {
            let quizText = '';
            
            // Baca judul quiz
            const quizTitle = document.querySelector('h1.text-2xl.font-bold');
            if (quizTitle) {
                quizText += quizTitle.textContent.trim() + '. ';
            }

            // Baca setiap pertanyaan dan pilihan
            const questions = document.querySelectorAll('.question-container');
            questions.forEach((question, index) => {
                const questionText = question.querySelector('p.text-lg.font-medium');
                if (questionText) {
                    quizText += `Pertanyaan ${index + 1}. ${questionText.textContent.trim()}. `;
                }

                const options = question.querySelectorAll('label span:last-child');
                options.forEach((option, optIndex) => {
                    quizText += `Pilihan ${String.fromCharCode(65 + optIndex)}. ${option.textContent.trim()}. `;
                });
                
                quizText += ' ';
            });

            return quizText;
        },

        handleQuizCommand: function(command) {
            const normalizedCommand = command.toLowerCase().trim();
            console.log('Processing quiz command:', normalizedCommand);
            
            // Pattern yang lebih fleksibel
            const answerPattern = /(pilih|jawab).*([a-d]).*(\d+)|(\d+).*([a-d])/i;
            const match = normalizedCommand.match(answerPattern);
            console.log("Matched command:", match);

            if (match) {
                let answer, questionNumber;
                
                // Format: "pilih a pertanyaan 1"
                if (match[2] && match[3]) {
                    answer = match[2];
                    questionNumber = match[3];
                } 
                // Format: "pertanyaan 1 pilih a"
                else if (match[4] && match[5]) {
                    answer = match[5];
                    questionNumber = match[4];
                }
                
                console.log(`Attempting to answer: Question ${questionNumber}, Answer ${answer}`);
                
                const questionIndex = parseInt(questionNumber) - 1;
                const questions = document.querySelectorAll('.question-container');
                
                if (questionIndex >= 0 && questionIndex < questions.length) {
                    const question = questions[questionIndex];
                    const optionIndex = answer.toLowerCase().charCodeAt(0) - 97;
                    const options = question.querySelectorAll('input[type="radio"]');
                    
                    if (optionIndex >= 0 && optionIndex < options.length) {
                        options[optionIndex].checked = true;
                        this.speak(`Memilih jawaban ${answer.toUpperCase()} untuk pertanyaan ${questionNumber}`);
                        return true;
                    }
                }
            }

            console.log('Quiz command not recognized');
            return false;
        },

        processCommand: async function (command) {
            console.log('Processing voice command:', command);
            const courseId = this.getCourseId();

            // Cek jika command adalah perintah quiz
            if (window.location.pathname.includes('/quiz')) {
                if (this.handleQuizCommand(command)) {
                    console.log('Quiz command handled successfully');
                    return;
                }
            }

            try {
                const response = await fetch('/voice-action/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ command, course_id: courseId }),
                });

                const data = await response.json();
                console.log('Server response:', data);
                this.removeFeedback();
                this.speak(data.message);
                this.handleAction(data);
            } catch (error) {
                console.error('Error processing command:', error);
                this.showFeedback('Terjadi kesalahan saat memproses perintah', 'error');
            }
        },

        getCourseId: function () {
            const ids = new Set();
            document.querySelectorAll('[data-course-id]').forEach((el) => {
                if (el.dataset.courseId) ids.add(el.dataset.courseId);
            });
            const urlMatch = window.location.pathname.match(/courses\/(\d+)/);
            if (urlMatch) ids.add(urlMatch[1]);
            return Array.from(ids).filter((id) => id && id !== 'undefined')[0] || null;
        },

        handleAction: function (data) {
            switch (data.action) {
                case 'navigate':
                    if (data.url) {
                        window.location.href = data.url;
                    } else {
                        this.showFeedback('URL tidak tersedia', 'error');
                    }
                    break;
                case 'toggle_contrast':
                    document.body.classList.toggle('high-contrast');
                    fetch('/update-contrast-mode', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    });
                    break;
                case 'read_text':
                    if (window.location.pathname.includes('/quiz')) {
                        const quizContent = this.readQuizContent();
                        this.speak(quizContent);
                    } else {
                        this.readPageContent();
                    }
                    break;
                case 'increase_font':
                    this.changeFontSize(2);
                    break;
                case 'decrease_font':
                    this.changeFontSize(-2);
                    break;
                case 'error':
                    this.showFeedback(data.message, 'error');
                    break;
                default:
                    console.warn('Unrecognized action:', data.action);
            }
        },

        readPageContent: function() {
            let fullText = '';
            
            if (window.location.pathname.includes('/quiz')) {
                fullText = this.readQuizContent();
            } else {
                const selectors = {
                    quiz: ['.text-2xl.font-bold', '.question-container'],
                    forum: ['.text-2xl.font-bold', '.category-container'],
                    course: ['#description-text', '.text-xl.font-semibold'],
                };

                const currentPath = window.location.pathname;
                let pageType = 'default';
                
                if (currentPath.includes('quiz')) pageType = 'quiz';
                else if (currentPath.includes('forum')) pageType = 'forum';
                else if (currentPath.includes('courses')) pageType = 'course';

                const relevantSelectors = selectors[pageType] || [];
                relevantSelectors.forEach(selector => {
                    document.querySelectorAll(selector).forEach(element => {
                        fullText += element.textContent.trim() + '. ';
                    });
                });
            }

            if (fullText) {
                this.speak(fullText);
            } else {
                console.error('No content found to read!');
            }
        },

        speak: function(text) {
            // Pastikan speechSynthesis bersih sebelum mulai
            window.speechSynthesis.cancel();

            // Bagi teks menjadi kalimat-kalimat
            const sentences = text.match(/[^.!?]+[.!?]+/g) || [text];
            let currentIndex = 0;

            const speakNextSentence = () => {
                if (currentIndex < sentences.length) {
                    const utterance = new SpeechSynthesisUtterance(sentences[currentIndex].trim());
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.9; // Sedikit lebih lambat untuk kejelasan
                    utterance.pitch = 1;

                    utterance.onend = () => {
                        currentIndex++;
                        speakNextSentence();
                    };

                    console.log(`Speaking sentence ${currentIndex + 1}/${sentences.length}`);
                    window.speechSynthesis.speak(utterance);
                } else {
                    console.log('Speech synthesis completed');
                }
            };

            speakNextSentence();
        },

        onRecognitionStart: function () {
            this.isListening = true;
            this.updateButtonState(true);
            this.showFeedback('Mendengarkan...', 'info');
        },

        onRecognitionEnd: function () {
            this.isListening = false;
            this.updateButtonState(false);
            if (this.transcript) {
                this.processCommand(this.transcript);
                this.transcript = '';
            }
        },

        onRecognitionError: function (event) {
            console.error('Speech recognition error:', event.error);
            this.showFeedback('Terjadi kesalahan: ' + event.error, 'error');
        },

        onRecognitionResult: function (event) {
            const current = event.resultIndex;
            const result = event.results[current];
            if (result.isFinal) {
                this.transcript = result[0].transcript.toLowerCase();
                console.log('Final recognized command:', this.transcript);
            }
        },

        updateButtonState: function (isListening) {
            if (this.toggleButton) {
                this.toggleButton.querySelector('.mic-icon').textContent = isListening ? '⏹️' : '🎤';
                this.toggleButton.querySelector('.voice-text').textContent = isListening ? 'Berhenti' : 'Voice Control';
                this.toggleButton.classList.toggle('bg-red-500', isListening);
                this.toggleButton.classList.toggle('bg-blue-500', !isListening);
            }
        },

        showFeedback: function (message, type = 'info') {
            this.removeFeedback();
            const feedbackDiv = document.createElement('div');
            feedbackDiv.id = 'voiceFeedback';
            feedbackDiv.textContent = message;
            feedbackDiv.className = `fixed bottom-4 right-4 p-4 rounded-lg ${
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            } text-white z-50`;
            document.body.appendChild(feedbackDiv);
            setTimeout(() => this.removeFeedback(), 3000);
        },

        removeFeedback: function () {
            const feedbackDiv = document.getElementById('voiceFeedback');
            if (feedbackDiv) feedbackDiv.remove();
        },

        changeFontSize: function (change) {
            document.querySelectorAll('body, p, div, span, h1, h2, h3, h4, h5, h6').forEach((element) => {
                const currentSize = parseFloat(window.getComputedStyle(element).fontSize);
                element.style.fontSize = currentSize + change + 'px';
            });
        }
    };

    VoiceController.init();
});