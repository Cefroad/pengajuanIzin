const modal = document.getElementById("modal");
const modalContent = document.getElementById("modalContent");
const openBtn = document.getElementById("openModal");
const closeBtn = document.getElementById("closeModal");
const cancelBtn = document.getElementById("cancelBtn");

function openModal() {
    modal.classList.remove("hidden");


    // Triggering animation for modal appearance
    setTimeout(() => {
        modalContent.classList.remove("opacity-0", "translate-y-[-100%]");
        modalContent.classList.add("opacity-100", "translate-y-0");
    }, 10);
}

function closeModal() {
    // Reverse the transition
    modalContent.classList.remove("opacity-100", "translate-y-0");
    modalContent.classList.add("opacity-0", "translate-y-[-100%]");

    setTimeout(() => {
        modal.classList.add("hidden");

    }, 300); // Wait for the transition to complete
}

openBtn.addEventListener("click", openModal);
closeBtn.addEventListener("click", closeModal);
cancelBtn.addEventListener("click", closeModal);

modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
});

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("hidden")) {
        closeModal();
    }
});

