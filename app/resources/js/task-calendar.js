document.addEventListener('DOMContentLoaded', function () {
    const prevBtn = document.getElementById('prev-month');
    const nextBtn = document.getElementById('next-month');
    const dateInput = document.getElementById('date');
    const form = document.getElementById('filters-form');

    if (!prevBtn || !nextBtn || !dateInput || !form) {
        return;
    }

    function changeMonth(offset) {
        const current = new Date(dateInput.value || new Date());
        current.setMonth(current.getMonth() + offset);

        const year = current.getFullYear();
        const month = String(current.getMonth() + 1).padStart(2, '0');
        const day = String(current.getDate()).padStart(2, '0');

        dateInput.value = `${year}-${month}-${day}`;
        form.submit();
    }

    prevBtn.addEventListener('click', function (e) {
        e.preventDefault();
        changeMonth(-1);
    });

    nextBtn.addEventListener('click', function (e) {
        e.preventDefault();
        changeMonth(1);
    });
});
