document.addEventListener("DOMContentLoaded", function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            tabPanes.forEach(pane => pane.classList.remove('active'));

            const index = Array.from(tabButtons).indexOf(button);
            tabPanes[index].classList.add('active');
        });
    });
});