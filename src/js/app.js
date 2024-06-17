let step = 1;
const initialStep = 1;
const finalStep = 3;

const appointment = {
    id: "",
    name: "",
    date: "",
    hour: "",
    services: []
}

document.addEventListener('DOMContentLoaded', () => {
    startApp();
})

function startApp() {
    tabs();
    showSection();
    queryAPI();
    pagerButtons();
    laterPage();
    previousPage();
    showSummary();

    customerId();
    customerName();
    selectDate();
    selectHour();
}

function showSection() {
    const previousSection = document.querySelector('.show');
    previousSection && previousSection.classList.remove('show');

    const section = document.querySelector(`#step-${step}`);
    section.classList.add('show');

    // Quitar el resaltado en el tab previo
    const previousTab = document.querySelector('.current');
    if (previousTab) {
        previousTab.classList.remove('current');
    }

    // resalta el tab actual
    const tab = document.querySelector(`[data-step="${step}"]`);
    tab.classList.add('current');
}

function pagerButtons() {
    const previousButton = document.querySelector('#previous');
    const laterButton = document.querySelector('#later');

    if (step === 1) {
        previousButton.classList.add('hide');
        laterButton.classList.remove('hide');
    } else if (step === 2) {
        previousButton.classList.remove('hide');
        laterButton.classList.remove('hide');
    } else if (step === 3) {
        previousButton.classList.remove('hide');
        laterButton.classList.add('hide');

        showSummary();
    }

    showSection();
}

function tabs() {
    const buttons = document.querySelectorAll('.tabs button');

    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            step = parseInt(e.target.dataset.step);

            showSection();
            pagerButtons();
        });
    });
}

function previousPage() {
    const previousPage = document.querySelector('#previous');
    previousPage.addEventListener('click', () => {

        if (step <= initialStep) return;
        step--;

        pagerButtons();
    });
}

function laterPage() {
    const laterPage = document.querySelector('#later');
    laterPage.addEventListener('click', () => {

        if (step >= finalStep) return;
        step++;

        pagerButtons();
    });
}

// Obtener los servicios

async function queryAPI() {

    try {
        const url = `${location.origin}/api/services`;
        const result = await fetch(url);
        const services = await result.json();
        showServices(services);

    } catch (error) {
        console.log(error);
    }
}

function showServices(services) {

    services.forEach(service => {
        const { id, name, price } = service;

        const serviceName = document.createElement('P');
        serviceName.classList.add('service-name');
        serviceName.textContent = name;

        const servicePrice = document.createElement('P');
        servicePrice.classList.add('service-price');
        servicePrice.textContent = `$${price}`;

        const serviceDiv = document.createElement('DIV');
        serviceDiv.classList.add('service');
        serviceDiv.dataset.serviceId = id;

        serviceDiv.onclick = () => {
            selectService(service);
        }

        serviceDiv.appendChild(serviceName);
        serviceDiv.appendChild(servicePrice);

        document.querySelector('#services').appendChild(serviceDiv);
    });
}

function selectService(service) {
    const { id } = service;
    const { services } = appointment;

    const serviceDiv = document.querySelector(`[data-service-id="${id}"]`);

    // Comprobar si un servicio ya fue agregado 
    if (services.some(added => added.id === id)) {
        // Eliminarlo de los servicios seleccionados
        appointment.services = services.filter(added => added.id !== id);
    } else {
        appointment.services = [...services, service];
    }
    serviceDiv.classList.toggle('selected');
}

function customerId() {
    appointment.id = document.querySelector('#id').value;
}

function customerName() {
    // Se crea la variable 'name' y se guarda en el objeto de 'appointment'
    appointment.name = document.querySelector('#name').value;
}

function selectDate() {
    const inputDate = document.querySelector('#date');

    // Obtener fecha
    inputDate.addEventListener('input', (e) => {
        const day = new Date(e.target.value).getUTCDay();

        // Revisar que no sea en fin de semana
        if ([6, 0].includes(day)) {
            e.target.value = '';
            showAlert('error', 'Fines de semana no permitidos', '.form');
        } else {
            appointment.date = e.target.value;
        }

    });
}

function selectHour() {
    const inputHour = document.querySelector('#hour');

    inputHour.addEventListener('input', (e) => {
        const appointmentTime = e.target.value;
        const hour = appointmentTime.split(':')[0];

        if (hour < 10 || hour > 18) {
            e.target.value = '';
            showAlert('error', 'Horas no validas', '.form');
        } else {
            appointment.hour = e.target.value;
        }

    });
}

function showAlert(type, message, element, vanish = true) {
    // previene generar mas de una alerta
    const previousAlert = document.querySelector('.alert');
    if (previousAlert) {
        previousAlert.remove();
    }

    // Scripting para crear la alerta
    const alert = document.createElement('DIV');
    alert.textContent = message;
    alert.classList.add('alert');
    alert.classList.add(type);

    const ref = document.querySelector(element);
    ref.appendChild(alert);

    if (vanish) {
        // Eliminar alerta
        setTimeout(() => {
            alert.remove();
        }, 4000);
    }
}

function showSummary() {
    const summary = document.querySelector('.summary-content');


    // Limpiar el summary-content
    while (summary.firstChild) {
        summary.removeChild(summary.firstChild);
    }

    if (Object.values(appointment).includes('') || appointment.services.length === 0) {
        showAlert('error', 'Faltan datos de Servicios, Fecha u Hora', '.summary-content', false);
        return;
    }

    // Formatear el div de resumen
    const { name, date, hour, services } = appointment;

    // Header para services en summary
    const headerServices = document.createElement('H3');
    headerServices.textContent = 'Resumen de Servicios';
    summary.appendChild(headerServices);

    // Iterando y mostrando los servicios

    services.forEach(service => {

        const { id, price, name } = service;

        const serviceDiv = document.createElement('DIV');
        serviceDiv.classList.add('service-container');

        const serviceText = document.createElement('P');
        serviceText.textContent = name;

        const servicePrice = document.createElement('P');
        servicePrice.innerHTML = `<span>Precio:</span> ${price}`;

        serviceDiv.appendChild(serviceText);
        serviceDiv.appendChild(servicePrice);
        summary.appendChild(serviceDiv);
    })

    // Header para services en summary
    const headerAppointment = document.createElement('H3');
    headerAppointment.textContent = 'Resumen de cita';
    summary.appendChild(headerAppointment);

    // Summary appointment
    const customerName = document.createElement('P');
    customerName.innerHTML = `<span>Nombre:</span> ${name}`;
    summary.appendChild(customerName);

    // Formatear la fecha
    const dateObj = new Date(date);
    const month = dateObj.getMonth();
    const day = dateObj.getDate() + 2;
    const year = dateObj.getFullYear();

    const dateUTC = new Date(Date.UTC(year, month, day));

    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = dateUTC.toLocaleDateString('es-MX', options);

    const appointmentDate = document.createElement('P');
    appointmentDate.innerHTML = `<span>Fecha:</span> ${formattedDate}`;
    summary.appendChild(appointmentDate);

    const appointmentHour = document.createElement('P');
    appointmentHour.innerHTML = `<span>Hora:</span> ${hour} Horas`;
    summary.appendChild(appointmentHour);

    const total = services.reduce((total, service) => total + parseFloat(service.price), 0);
    const paragraphTotal = document.createElement('P');
    paragraphTotal.innerHTML = `<span>Total:</span> $${total}`;
    summary.appendChild(paragraphTotal);

    // Boton para crear una cita
    const reserveButton = document.createElement('BUTTON');
    reserveButton.classList.add('button');
    reserveButton.textContent = 'Reservar Cita';
    reserveButton.onclick = reserveAppointment;

    summary.appendChild(reserveButton);
}

async function reserveAppointment() {

    const { date, hour, services, id } = appointment;

    const servicesId = services.map(service => service.id);

    const data = new FormData();
    data.append('date', date);
    data.append('hour', hour);
    data.append('user_id', id);
    data.append('services', servicesId);

    // console.log([...data]);
    // return;

    try {
        // Peticion hascia la api
        const url = `${location.origin}/api/appointments`;
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        const result = await response.json();

        if (result.result) {
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                text: "Tu cita fue creada correctamente",
                button: "OK"
            }).then(() => window.location.reload());
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al intentar reservar su cita, por favor intentelo de nuevo",
        });
    }

    // console.log(result);
}