// Datos de ejemplo para maestros y alumnos
var maestros = [
    { nombre: "Juan", apellido: "Pérez", horario: "8:00 AM", asistencias: 5 },
    { nombre: "María", apellido: "Gómez", horario: "9:00 AM", asistencias: 3 }
];

var alumnos = [
    { nombre: "Luis", apellido: "Martínez", grado: "10°", horario: "8:30 AM", asistencias: 8 },
    { nombre: "Ana", apellido: "Rodríguez", grado: "11°", horario: "9:30 AM", asistencias: 6 }
];

// Función para mostrar maestros en la tabla
function mostrarMaestros() {
    var html = "";
    for (var i = 0; i < maestros.length; i++) {
        html += "<tr>";
        html += "<td>" + maestros[i].nombre + "</td>";
        html += "<td>" + maestros[i].apellido + "</td>";
        html += "<td>" + maestros[i].horario + "</td>";
        html += "</tr>";
    }
    document.getElementById("teacher-table").getElementsByTagName("tbody")[0].innerHTML = html;
}

// Función para mostrar alumnos en la tabla
function mostrarAlumnos() {
    var html = "";
    for (var i = 0; i < alumnos.length; i++) {
        html += "<tr>";
        html += "<td>" + alumnos[i].nombre + "</td>";
        html += "<td>" + alumnos[i].apellido + "</td>";
        html += "<td>" + alumnos[i].grado + "</td>";
        html += "<td>" + alumnos[i].horario + "</td>";
        html += "</tr>";
    }
    document.getElementById("student-table").getElementsByTagName("tbody")[0].innerHTML = html;
}

// Función para dibujar gráfico de maestros
function drawTeacherChart() {
    var ctx = document.getElementById('teacher-chart').getContext('2d');
    var teacherChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: maestros.map(function(maestro) {
                return maestro.nombre + ' ' + maestro.apellido;
            }),
            datasets: [{
                label: 'Asistencias',
                data: maestros.map(function(maestro) {
                    return maestro.asistencias;
                }),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Función para dibujar gráfico de alumnos
function drawStudentChart() {
    var ctx = document.getElementById('student-chart').getContext('2d');
    var studentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: alumnos.map(function(alumno) {
                return alumno.nombre + ' ' + alumno.apellido;
            }),
            datasets: [{
                label: 'Asistencias',
                data: alumnos.map(function(alumno) {
                    return alumno.asistencias;
                }),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Llamar a las funciones para mostrar maestros y alumnos al cargar la página
mostrarMaestros();
mostrarAlumnos();
drawTeacherChart();
drawStudentChart();

