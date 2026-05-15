document.addEventListener('DOMContentLoaded', () => {
    if (window.jQuery && window.jQuery.fn.DataTable) {
        window.jQuery('.datatable').DataTable({
            pageLength: 10,
            order: [],
            responsive: true
        });
    }

    document.querySelectorAll('.rich-editor-wrapper').forEach((wrapper) => {
        const editor = wrapper.querySelector('.rich-editor');
        const input = wrapper.querySelector('.rich-editor-input');

        wrapper.querySelectorAll('[data-command]').forEach((button) => {
            button.addEventListener('click', () => {
                const command = button.getAttribute('data-command');
                const value = button.getAttribute('data-value');
                document.execCommand(command, false, value);
                editor.focus();
                input.value = editor.innerHTML.trim();
            });
        });

        editor.addEventListener('input', () => {
            input.value = editor.innerHTML.trim();
        });

        const form = wrapper.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                input.value = editor.innerHTML.trim();
            });
        }
    });

    if (window.Chart && window.dashboardChartData) {
        const founderCanvas = document.getElementById('founderChart');
        if (founderCanvas) {
            new Chart(founderCanvas, {
                type: 'bar',
                data: {
                    labels: window.dashboardChartData.founder.labels,
                    datasets: [{
                        data: window.dashboardChartData.founder.values,
                        backgroundColor: ['#0f5e8c', '#d8993f', '#17395d', '#5f7c95', '#8e5332', '#7c9d8b'],
                        borderRadius: 14
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        const complianceCanvas = document.getElementById('complianceChart');
        if (complianceCanvas && window.dashboardChartData.compliance.labels.length) {
            new Chart(complianceCanvas, {
                type: 'doughnut',
                data: {
                    labels: window.dashboardChartData.compliance.labels,
                    datasets: [{
                        data: window.dashboardChartData.compliance.values,
                        backgroundColor: ['#0f5e8c', '#d8993f', '#b14a42', '#1a7f5a', '#7488a6']
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    }
});
