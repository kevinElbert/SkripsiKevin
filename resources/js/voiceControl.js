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
    let transcript = '';

    recognition.lang = 'id-ID';
    recognition.continuous = true;
    recognition.interimResults = true;

    function getAllCourseIds() {
        const ids = new Set();
        
        // 1. Check main element
        const mainElement = document.querySelector('main[data-course-id]');
        if (mainElement && mainElement.dataset.courseId) {
            ids.add(mainElement.dataset.courseId);
        }

        // 2. Check container elements
        const containerElements = document.querySelectorAll('.container[data-course-id]');
        containerElements.forEach(el => {
            if (el.dataset.courseId) ids.add(el.dataset.courseId);
        });

        // 3. Check any element with data-course-id
        const allElements = document.querySelectorAll('[data-course-id]');
        allElements.forEach(el => {
            if (el.dataset.courseId) ids.add(el.dataset.courseId);
        });

        // 4. Try to get from URL
        const urlMatch = window.location.pathname.match(/courses\/(\d+)/);
        if (urlMatch) {
            ids.add(urlMatch[1]);
        }

        // Convert Set to Array and get the first valid ID
        const courseIds = Array.from(ids).filter(id => id && id !== 'undefined' && id !== '');
        
        console.log('Found course IDs:', courseIds);
        return courseIds[0] || null;
    }

    // Event Handlers
    recognition.onstart = function() {
        isListening = true;
        updateButtonState(true);
        showFeedback('Mendengarkan...', 'info');
        console.log('Speech recognition started');
    };

    recognition.onend = function() {
        isListening = false;
        updateButtonState(false);
        console.log('Speech recognition stopped');

        if (transcript) {
            processVoiceCommand(transcript);
            transcript = ''; // Reset transcript
        }
    };

    recognition.onerror = function(event) {
        console.error('Speech recognition error:', event.error);
        showFeedback('Terjadi kesalahan: ' + event.error, 'error');
        isListening = false;
        updateButtonState(false);
    };

    recognition.onresult = function(event) {
        const current = event.resultIndex;
        transcript = event.results[current][0].transcript.toLowerCase();
        console.log('Recognized command:', transcript);
    };

    // Process voice commands
    async function processVoiceCommand(command) {
        console.log('Processing voice command:', command);
        const courseId = getAllCourseIds();
        console.log('Found course ID:', courseId);

        showFeedback('Memproses perintah...', 'info');
        
        try {
            const response = await fetch('/voice-action/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    command: command,
                    course_id: courseId
                })
            });

            const data = await response.json();
            console.log('Server response:', data);

            removeFeedback();

            // Feedback suara
            speak(data.message);

            // Handle different actions
            switch (data.action) {
                case 'navigate':
                    if (data.url) {
                        window.location.href = data.url;
                    } else {
                        showFeedback('URL tidak tersedia', 'error');
                    }
                    break;
                case 'error':
                    showFeedback(data.message, 'error');
                    break;
                case 'toggle_contrast':
                    document.body.classList.toggle('high-contrast');
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
                default:
                    if (data.action === 'unknown') {
                        showFeedback('Perintah tidak dikenali.', 'error');
                    } else {
                        console.warn('Unrecognized action:', data.action);
                    }
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
        removeFeedback(); // Remove any existing feedback
        const feedbackDiv = document.createElement('div');
        feedbackDiv.id = 'voiceFeedback';
        feedbackDiv.textContent = message;
        feedbackDiv.className = `fixed bottom-4 right-4 p-4 rounded-lg ${
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        } text-white z-50`;

        document.body.appendChild(feedbackDiv);

        setTimeout(() => {
            removeFeedback();
        }, 3000);
    }

    function removeFeedback() {
        const feedbackDiv = document.getElementById('voiceFeedback');
        if (feedbackDiv) {
            feedbackDiv.remove();
        }
    }

    function speak(text) {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'id-ID';
        window.speechSynthesis.speak(utterance);
    }

    function readPageContent() {
        const mainContent = document.querySelector('main');
        if (mainContent) {
            const text = mainContent.textContent.trim();
            speak(text);
        }
    }

    function changeFontSize(change) {
        const elements = document.querySelectorAll('body, p, div, span, h1, h2, h3, h4, h5, h6');
        elements.forEach(element => {
            const currentSize = parseFloat(window.getComputedStyle(element).fontSize);
            element.style.fontSize = (currentSize + change) + 'px';
        });
    }

    // Toggle voice recognition
    const toggleButton = document.getElementById('toggleVoice');
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            if (isListening) {
                recognition.stop();
            } else {
                // Cek dan minta izin mikrofon jika belum
                navigator.mediaDevices.getUserMedia({ audio: true })
                    .then(function(stream) {
                        stream.getTracks().forEach(track => track.stop());
                        recognition.start();
                    })
                    .catch(function(error) {
                        console.error('Error accessing microphone:', error);
                        showFeedback('Tidak dapat mengakses mikrofon. Mohon berikan izin untuk menggunakan mikrofon.', 'error');
                    });
            }
        });
    }

    // Add debug logging
    console.log('Voice control initialized');
    console.log('Available elements with data-course-id:');
    document.querySelectorAll('[data-course-id]').forEach(el => {
        console.log(el.tagName, el.className, 'course_id:', el.dataset.courseId);
    });
});