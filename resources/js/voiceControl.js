document.addEventListener('DOMContentLoaded', function () {
    const VoiceController = {
        recognition: null,
        isListening: false,
        transcript: '',
        toggleButton: null,

        init: function () {
            // Inisialisasi tombol voice control
            this.createVoiceControlButton();
            this.toggleButton = document.getElementById('toggleVoice');

            // Inisialisasi Speech Recognition
            this.initSpeechRecognition();

            console.log('Voice control initialized');
        },

        createVoiceControlButton: function () {
            const header = document.querySelector('header');
            if (header) {
                const voiceButton = document.createElement('button');
                voiceButton.id = 'toggleVoice';
                voiceButton.className =
                    'ml-4 p-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white transition-colors flex items-center gap-2';
                voiceButton.innerHTML = `
                    <span class="mic-icon">🎤</span>
                    <span class="voice-text text-sm">Voice Control</span>
                `;
                header.appendChild(voiceButton);
            }
        },

        initSpeechRecognition: function () {
            this.recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            this.recognition.lang = 'id-ID';
            this.recognition.continuous = true;

            this.recognition.onstart = () => this.onRecognitionStart();
            this.recognition.onend = () => this.onRecognitionEnd();
            this.recognition.onerror = (event) => this.onRecognitionError(event);
            this.recognition.onresult = (event) => this.onRecognitionResult(event);

            // Pasang event listener untuk tombol voice control
            this.toggleButton.addEventListener('click', () => this.toggleVoiceRecognition());
        },

        toggleVoiceRecognition: function () {
            if (this.isListening) {
                this.recognition.stop();
            } else {
                // Cek izin mikrofon sebelum memulai
                navigator.mediaDevices
                    .getUserMedia({ audio: true })
                    .then((stream) => {
                        stream.getTracks().forEach((track) => track.stop()); // Hentikan akses mikrofon segera setelah izin diberikan
                        this.recognition.start();
                    })
                    .catch((error) => {
                        console.error('Error accessing microphone:', error);
                        this.showFeedback(
                            'Tidak dapat mengakses mikrofon. Mohon berikan izin untuk menggunakan mikrofon.',
                            'error'
                        );
                    });
            }
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
                this.transcript = ''; // Reset transcript
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

        processCommand: async function (command) {
            console.log('Processing voice command:', command);
            const courseId = this.getCourseId();

            this.showFeedback('Memproses perintah...', 'info');

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

                // Feedback suara
                this.speak(data.message);

                // Handle actions dari server
                this.handleAction(data);
            } catch (error) {
                console.error('Error processing command:', error);
                this.showFeedback('Terjadi kesalahan saat memproses perintah', 'error');
            }
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
                    this.readPageContent();
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

        getCourseId: function () {
            const ids = new Set();

            document.querySelectorAll('[data-course-id]').forEach((el) => {
                if (el.dataset.courseId) ids.add(el.dataset.courseId);
            });

            const urlMatch = window.location.pathname.match(/courses\/(\d+)/);
            if (urlMatch) ids.add(urlMatch[1]);

            const courseIds = Array.from(ids).filter((id) => id && id !== 'undefined');
            console.log('Found course IDs:', courseIds);

            return courseIds[0] || null;
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

            setTimeout(() => {
                this.removeFeedback();
            }, 3000);
        },

        removeFeedback: function () {
            const feedbackDiv = document.getElementById('voiceFeedback');
            if (feedbackDiv) {
                feedbackDiv.remove();
            }
        },

        speak: function speak(text) {
            const MAX_CHARS = 200; // Batas jumlah karakter per bagian
            const parts = text.match(new RegExp('.{1,' + MAX_CHARS + '}(\\s|$)', 'g')); // Pecah teks
        
            window.speechSynthesis.cancel(); // Bersihkan antrian sebelumnya
        
            parts.forEach((part, index) => {
                const utterance = new SpeechSynthesisUtterance(part);
                utterance.lang = 'id-ID';
        
                if (index === parts.length - 1) {
                    utterance.onend = () => console.log('Speech synthesis completed');
                }
        
                window.speechSynthesis.speak(utterance);
            });
        },        

        readPageContent: function readPageContent() {
            const elementsToRead = [
                // document.querySelector('header'), 
                document.querySelector('main'),
                // document.querySelector('footer'),
                document.querySelectorAll('.course-card'), // Menangkap elemen kursus di grid Home
                document.querySelectorAll('.question-container'), // Menangkap pertanyaan Quiz
                document.querySelectorAll('.quiz-container'), // Tambahan elemen spesifik Quiz
            ];
        
            let fullText = '';
        
            elementsToRead.forEach(element => {
                if (element) {
                    if (element instanceof NodeList) {
                        element.forEach(node => {
                            fullText += node.textContent.trim() + '\n\n';
                        });
                    } else {
                        fullText += element.textContent.trim() + '\n\n';
                    }
                }
            });
        
            if (!fullText) {
                console.error('No content found to read!');
                return;
            }
        
            console.log('Reading full page content:', fullText);
            speak(fullText);
        },

        changeFontSize: function (change) {
            document.querySelectorAll('body, p, div, span, h1, h2, h3, h4, h5, h6').forEach((element) => {
                const currentSize = parseFloat(window.getComputedStyle(element).fontSize);
                element.style.fontSize = currentSize + change + 'px';
            });
        },
    };

    VoiceController.init();
});
