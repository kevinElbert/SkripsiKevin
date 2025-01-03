document.getElementById('play-tts').addEventListener('click', async () => {
    console.log("Button clicked!");
    const text = document.getElementById('description-text').innerText;

    try {
        const response = await fetch('/tts/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                text: text,
                lang: 'id-id',
            }),
        });

        const data = await response.json();
        if (response.ok && data.audio_url) {
            const audio = new Audio(data.audio_url);
            audio.play();
        } else {
            console.error('Error:', data.error);
            alert('Failed to generate speech: ' + (data.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred.');
    }
});
