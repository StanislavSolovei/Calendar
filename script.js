function openTaskModal(date) {
    const modal = document.getElementById("taskModal");
    const modalBody = document.getElementById("modal-body");

    modal.style.display = "block";

    fetch(`manage_tasks.php?get_form=1&date=${date}`)
        .then(response => response.text())
        .then(html => {
            modalBody.textContent = html;
        });
}

function closeModal() {
    document.getElementById("taskModal").style.display = "none";
}

window.onclick = function(event) {
    const modal = document.getElementById("taskModal");
    if (event.target == modal) {
        closeModal();
    }
}
