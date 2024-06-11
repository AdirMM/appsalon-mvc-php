document.addEventListener('DOMContentLoaded', () => {
    startApp();
});

const startApp = () => {
    searchByDate();
}

function searchByDate () {
    const dateInput = document.querySelector('#date');
    dateInput.addEventListener('input', (e) => {
        const selectedDate = e.target.value;

        window.location = `?date=${selectedDate}`;
    });
}