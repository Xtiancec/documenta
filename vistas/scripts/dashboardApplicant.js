document.addEventListener('DOMContentLoaded', function () {
    const applicantId = document.getElementById('dashboardData').dataset.applicantId;

    let documentsChart;
    let accessLogsChart;
    let evaluationChart;
    let processChart;
    let educationChart;
    let documentTypeChart;
    let experienceChart;

    let previousData = null;

    function loadDashboardData() {
        console.log('Cargando datos...');

        fetch(`../controlador/DashboardApplicantController.php?applicant_id=${applicantId}&t=${new Date().getTime()}`, {
            cache: 'no-store',
            headers: {
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);

            // Compara los datos actuales con los datos anteriores
            if (JSON.stringify(previousData) === JSON.stringify(data)) {
                console.log('No hay cambios en los datos. No se actualizan los gráficos.');
                return; // No actualiza si los datos no han cambiado
            }

            // Almacena los nuevos datos para futuras comparaciones
            previousData = data;

            // Destruir gráficos existentes si ya están creados
            if (documentsChart) documentsChart.destroy();
            if (accessLogsChart) accessLogsChart.destroy();
            if (evaluationChart) evaluationChart.destroy();
            if (processChart) processChart.destroy();
            if (educationChart) educationChart.destroy();
            if (documentTypeChart) documentTypeChart.destroy();
            if (experienceChart) experienceChart.destroy();

            // Progreso de Documentos
            if (data.documents_progress.length > 0 && data.documents_progress[0].total_documentos > 0) {
                const documentsChartCtx = document.getElementById('documentsChart').getContext('2d');
                documentsChart = new Chart(documentsChartCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Documentos Subidos', 'Total Documentos'],
                        datasets: [{
                            data: [data.documents_progress[0].documentos_subidos, data.documents_progress[0].total_documentos],
                            backgroundColor: ['#36A2EB', '#FF6384']
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Progreso de Documentos'
                        }
                    }
                });
            }

            // Historial de Accesos
            const accessLogsChartCtx = document.getElementById('accessLogsChart').getContext('2d');
            const labels = data.access_logs.map(log => log.fecha);
            const accessData = data.access_logs.map(log => log.accesos);
            accessLogsChart = new Chart(accessLogsChartCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Número de Accesos',
                        data: accessData,
                        backgroundColor: '#36A2EB'
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Historial de Accesos'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });

            // Estado de Evaluación de Documentos
            if (data.evaluation.length > 0) {
                const evaluationChartCtx = document.getElementById('evaluationChart').getContext('2d');
                const evaluationData = [data.evaluation[0].revisados, data.evaluation[0].no_revisados];
                evaluationChart = new Chart(evaluationChartCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Revisados', 'No Revisados'],
                        datasets: [{
                            data: evaluationData,
                            backgroundColor: ['#36A2EB', '#FF6384']
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Estado de Evaluación de Documentos'
                        }
                    }
                });
            }

            // Estado del Proceso de Selección
            if (data.selection_state.length > 0) {
                const processChartCtx = document.getElementById('processChart').getContext('2d');
                const processState = data.selection_state[0].state_name;
                processChart = new Chart(processChartCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Progreso'],
                        datasets: [{
                            label: processState,
                            data: [1],
                            backgroundColor: '#36A2EB'
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Estado del Proceso de Selección'
                        }
                    }
                });
            } else {
                document.getElementById('processChart').parentElement.innerHTML = '<p class="text-muted">No disponible</p>';
            }

            // Progreso Educativo
            if (data.education.length > 0) {
                const educationChartCtx = document.getElementById('educationChart').getContext('2d');
                const educationLabels = data.education.map(item => item.education_type);
                const educationData = data.education.map(item => item.total);
                educationChart = new Chart(educationChartCtx, {
                    type: 'radar',
                    data: {
                        labels: educationLabels,
                        datasets: [{
                            label: 'Progreso Educativo',
                            data: educationData,
                            backgroundColor: 'rgba(54,162,235,0.2)',
                            borderColor: '#36A2EB',
                            pointBackgroundColor: '#36A2EB'
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Progreso Educativo'
                        }
                    }
                });
            }

            // Documentos Subidos por Tipo
            if (data.documents_by_type.length > 0) {
                const documentTypeChartCtx = document.getElementById('documentTypeChart').getContext('2d');
                const documentTypeLabels = data.documents_by_type.map(item => item.document_name);
                const documentTypeData = data.documents_by_type.map(item => item.total);
                documentTypeChart = new Chart(documentTypeChartCtx, {
                    type: 'pie',
                    data: {
                        labels: documentTypeLabels,
                        datasets: [{
                            data: documentTypeData,
                            backgroundColor: ['#36A2EB', '#FF6384']
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Documentos Subidos por Tipo'
                        }
                    }
                });
            }

            // Experiencia Laboral Total
            if (data.experience.length > 0 && data.experience[0].total_experiencia !== null) {
                const experienceChartCtx = document.getElementById('experienceChart').getContext('2d');
                const totalExperience = data.experience[0].total_experiencia || 0;
                experienceChart = new Chart(experienceChartCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Experiencia Total (Años)'],
                        datasets: [{
                            label: 'Años de Experiencia',
                            data: [totalExperience],
                            backgroundColor: '#36A2EB'
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Total de Años de Experiencia Laboral'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            } else {
                document.getElementById('experienceChart').parentElement.innerHTML = '<p class="text-muted">No hay experiencia registrada.</p>';
            }
        })
        .catch(error => console.error('Error al cargar los datos del dashboard:', error));
    }

    // Cargar los datos cada 5 segundos y solo actualizar si cambian
    loadDashboardData();
    setInterval(loadDashboardData, 5000);
});
