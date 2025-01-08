// resources/js/voiceControl.js

document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan tombol voice control ke header
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

    // Inisialisasi Speech Recognition
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    let isListening = false;

    recognition.lang = 'id-ID';
    recognition.continuous = true;
    recognition.interimResults = true;

    // Event Handlers
    recognition.onstart = function() {
        isListening = true;
        updateButtonState(true);
        showFeedback('Mendengarkan...', 'info');
    };

    recognition.onend = function() {
        isListening = false;
        updateButtonState(false);
    };

    recognition.onerror = function(event) {
        console.error('Speech recognition error:', event.error);
        showFeedback('Terjadi kesalahan: ' + event.error, 'error');
        isListening = false;
        updateButtonState(false);
    };

    recognition.onresult = function(event) {
        const current = event.resultIndex;
        const transcript = event.results[current][0].transcript.toLowerCase();
        
        processVoiceCommand(transcript);
    };

    // Process voice commands
    async function processVoiceCommand(command) {
        try {
            const response = await fetch('/voice-action/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ command: command })
            });

            const data = await response.json();
            
            // Feedback suara
            speak(data.message);

            // Handle different actions
            switch(data.action) {
                case 'navigate':
                    window.location.href = data.url;
                    break;
                case 'search_course':
                    searchAndNavigateToCourse(data.query);
                    break;
                case 'navigate_quiz':
                    handleQuizNavigation();
                    break;
                case 'navigate_forum':
                    handleForumNavigation();
                    break;
                case 'toggle_contrast':
                    document.body.classList.toggle('high-contrast');
                    // Gunakan route yang sudah ada
                    fetch('/update-contrast-mode', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    break;
                case 'read_text':
                    readPageContent();
                    break;
                case 'increase_font':
                    changeFontSize(2);
                    break;
                case 'decrease_font':
                    changeFontSize(-2);
                    break;
            }
        } catch (error) {
            console.error('Error processing command:', error);
            showFeedback('Terjadi kesalahan saat memproses perintah', 'error');
        }
    }

    // Utility Functions
    function updateButtonState(isListening) {
        const button = document.getElementById('toggleVoice');
        if (button) {
            button.querySelector('.mic-icon').textContent = isListening ? '⏹️' : '🎤';
            button.querySelector('.voice-text').textContent = isListening ? 'Berhenti' : 'Voice Control';
            button.classList.toggle('bg-red-500', isListening);
            button.classList.toggle('bg-blue-500', !isListening);
        }
    }

    function showFeedback(message, type = 'info') {
        const feedbackDiv = document.getElementById('voiceFeedback') || createFeedbackElement();
        feedbackDiv.textContent = message;
        feedbackDiv.className = `fixed bottom-4 right-4 p-4 rounded-lg ${
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        } text-white`;
        
        setTimeout(() => {
            feedbackDiv.remove();
        }, 3000);
    }

    function createFeedbackElement() {
        const div = document.createElement('div');
        div.id = 'voiceFeedback';
        document.body.appendChild(div);
        return div;
    }

    function speak(text) {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'id-ID';
        window.speechSynthesis.speak(utterance);
    }

    function changeFontSize(change) {
        const elements = document.querySelectorAll('body, p, div, span, h1, h2, h3, h4, h5, h6');
        elements.forEach(element => {
            const currentSize = parseFloat(window.getComputedStyle(element).fontSize);
            element.style.fontSize = (currentSize + change) + 'px';
        });
    }

    async function searchAndNavigateToCourse(query) {
        try {
            const response = await fetch(`/voice-action/search-course?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            if (data.found) {
                window.location.href = data.url;
            } else {
                speak('Maaf, kursus tidak ditemukan');
            }
        } catch (error) {
            console.error('Error searching course:', error);
            speak('Terjadi kesalahan saat mencari kursus');
        }
    }

    function readPageContent() {
        const mainContent = document.querySelector('main');
        if (mainContent) {
            const text = mainContent.textContent.trim();
            speak(text);
        }
    }

    function handleQuizNavigation() {
        // Cek apakah sedang di halaman course
        const courseId = document.body.getAttribute('data-course-id');
        if (courseId) {
            window.location.href = `/courses/${courseId}/quiz`;
        } else {
            speak('Silakan buka halaman kursus terlebih dahulu untuk mengakses kuis');
        }
    }

    function handleForumNavigation() {
        // Cek apakah sedang di halaman course
        const courseId = document.body.getAttribute('data-course-id');
        if (courseId) {
            window.location.href = `/forum/${courseId}`;
        } else {
            speak('Silakan buka halaman kursus terlebih dahulu untuk mengakses forum');
        }
    }

    // Toggle voice recognition
    const toggleButton = document.getElementById('toggleVoice');
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            if (isListening) {
                recognition.stop();
            } else {
                recognition.start();
            }
        });
    }
});