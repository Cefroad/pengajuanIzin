// Event delegation untuk membuka modal
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("openModal")) {
        const modalId = e.target.getAttribute("data-id");
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector(".modalContent");

        modal.classList.remove("hidden");


        setTimeout(() => {
            modalContent.classList.remove("opacity-0", "translate-y-[-100%]");
            modalContent.classList.add("opacity-100", "translate-y-0");
        }, 10);
    }
});


// Event delegation untuk menutup modal
document.addEventListener("click", (e) => {
    if (e.target && e.target.classList.contains("closeModal")) {
        const modal = e.target.closest(".modal");
        const modalContent = modal.querySelector(".modalContent");

        modalContent.classList.remove("opacity-100", "translate-y-0");
        modalContent.classList.add("opacity-0", "translate-y-[-100%]");

        setTimeout(() => {
            modal.classList.add("hidden");

        }, 300);
    }
});



// Menutup modal dengan tombol Escape
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        const modal = document.querySelector(".modal:not(.hidden)");
        if (modal) {
            const modalContent = modal.querySelector(".modalContent");

            modalContent.classList.remove("opacity-100", "translate-y-0");
            modalContent.classList.add("opacity-0", "translate-y-[-100%]");

            setTimeout(() => {
                modal.classList.add("hidden");

            }, 300);
        }
    }
});

