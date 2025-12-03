import './bootstrap';
import Chart from 'chart.js/auto';

// Chart untuk frekuensi transaksi
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('transactionChart');
    if (ctx) {
        const countPemasukan = window.countPemasukan || 0;
        const countPengeluaran = window.countPengeluaran || 0;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    data: [countPemasukan, countPengeluaran],
                    backgroundColor: [
                        'rgba(25, 135, 84, 0.8)',  // hijau untuk pemasukan
                        'rgba(220, 53, 69, 0.8)'   // merah untuk pengeluaran
                    ],
                    borderColor: [
                        'rgba(25, 135, 84, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} kali (${percentage}%)`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: function(value, context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${value}\n(${percentage}%)`;
                        },
                        textAlign: 'center'
                    }
                }
            }
        });
    }
});
