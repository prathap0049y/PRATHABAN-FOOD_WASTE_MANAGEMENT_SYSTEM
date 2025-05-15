// Add item to the list
document.getElementById('itemForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;

    if (name && email) {
        const item = document.createElement('li');
        item.innerHTML = `
            <span>${name} - ${email}</span>
            <button class="button">
                <div class="trash">
                    <div class="top">
                        <div class="paper"></div>
                    </div>
                    <div class="box"></div>
                    <div class="check">
                        <svg viewBox="0 0 8 6">
                            <polyline points="1 3.4 2.71428571 5 7 1"></polyline>
                        </svg>
                    </div>
                </div>
                <span>Delete</span>
            </button>
        `;

        document.getElementById('itemsList').appendChild(item);

        // Clear the form
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';

        // Add delete functionality to the new button
        const deleteButton = item.querySelector('.button');
        deleteButton.addEventListener('click', function (e) {
            if (!deleteButton.classList.contains('delete')) {
                deleteButton.classList.add('delete');
                setTimeout(() => {
                    item.remove(); // Remove the list item after animation
                }, 3200);
            }
            e.preventDefault();
        });
    }
});