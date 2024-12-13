document.addEventListener("DOMContentLoaded", () => {
    const likeButtons = document.querySelectorAll(".like-button");

    likeButtons.forEach(button => {
        button.addEventListener("click", async () => {
            const type = button.dataset.type; // thread/comment
            const id = button.dataset.id;
            const liked = button.dataset.liked === "true";

            try {
                const response = await fetch(`/like/${type}/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "Content-Type": "application/json"
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    button.querySelector(".like-count").textContent = result.likes_count;
                    button.dataset.liked = !liked; // Toggle liked state
                    button.textContent = `${result.likes_count} Like`;
                } else {
                    console.error("Failed to like");
                }
            } catch (error) {
                console.error("Error:", error);
            }
        });
    });
});
