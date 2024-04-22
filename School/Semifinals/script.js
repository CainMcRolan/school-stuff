const modal = document.getElementById("myModal");
const btn = document.getElementById("myBtn");
const span = document.getElementsByClassName("close")[0];
const editForm = document.getElementById("editForm");

btn.onclick = function() {
    modal.style.display = "block";
    addForm.style.display = "block";
    editForm.style.display = "none";
}

const editButtons = document.querySelectorAll(".edit_button");
editButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        modal.style.display = "block";
        addForm.style.display = "none";
        editForm.style.display = "block";
        const userId = event.target.getAttribute('data-user-id');
        document.querySelector('.user_id').value = userId;
        const row = event.target.closest('tr');
        const cells = row.querySelectorAll('td');
        document.querySelector('.user_name').value = cells[0].textContent;
        document.querySelector('.user_course').value = cells[1].textContent;
        document.querySelector('.user_contact').value = cells[2].textContent;
    });
});

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }

}