document.addEventListener('DOMContentLoaded', () => {
    const tabBtn = document.querySelectorAll(".profile__nav ul li");
    const tab = document.querySelectorAll(".tab");

    tabs(0);

    tabBtn.forEach(item => {
        item.addEventListener('click', e => {
            tabs(e.target.dataset.tab);
        });
    });

    function tabs(panelIndex) {
        tab.forEach(function (node) {
            node.style.display = "none";
        });
        tab[panelIndex].style.display = "block";
    }
});