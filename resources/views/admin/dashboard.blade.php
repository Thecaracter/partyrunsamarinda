@extends('layouts.app')

@section('content')
    <div class="grid gap-6 p-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-50">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <div class="text-gray-500 text-sm">Total Peserta</div>
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($totalPeserta) }}</div>
                        <div class="text-sm text-gray-600">{{ number_format($lastMonthPeserta) }} bulan ini</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-50">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <div class="text-gray-500 text-sm">Check In</div>
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($checkInStats['total_checked_in']) }}
                        </div>
                        <div class="text-sm text-gray-600">dari {{ number_format($totalPeserta) }} peserta</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-5">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-50">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <div class="text-gray-500 text-sm">Pembayaran</div>
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($totalPaid) }}</div>
                        <div class="text-sm text-gray-600">{{ number_format($totalPending) }} pending</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Jersey Stock</h3>
                <div class="space-y-4">
                    @foreach ($jerseyInventory as $jersey)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Size {{ $jersey['size'] }}</span>
                                <span class="text-purple-600 font-semibold">{{ number_format($jersey['remaining']) }}
                                    tersisa</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>Stock: {{ number_format($jersey['stock']) }}</div>
                                <div>Terpakai: {{ number_format($jersey['used']) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Distribusi Kategori</h3>
                <div class="h-80 w-full">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Distribusi Usia</h3>
                <div class="h-80 w-full">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Tren Registrasi (30 Hari Terakhir)</h3>
                <div class="h-80 w-full">
                    <canvas id="registrationChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Distribusi Provinsi</h3>
                <div class="h-80 w-full">
                    <canvas id="provinceChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Metode Pembayaran</h3>
                <div class="h-80 w-full">
                    <canvas id="paymentMethodChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Distribusi Golongan Darah</h3>
                <div class="h-80 w-full">
                    <canvas id="bloodTypeChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium mb-4">Statistik Medis</h3>
                <div class="h-80 w-full">
                    <canvas id="medicalChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    // Category Chart
                    new Chart(document.getElementById('categoryChart'), {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($categoryDistribution->pluck('kategori')) !!},
                            datasets: [{
                                data: {!! json_encode($categoryDistribution->pluck('total')) !!},
                                backgroundColor: [
                                    'rgba(59, 130, 246, 0.8)', // Blue
                                    'rgba(16, 185, 129, 0.8)', // Green  
                                    'rgba(239, 68, 68, 0.8)', // Red
                                    'rgba(245, 158, 11, 0.8)' // Orange
                                ],
                                borderColor: [
                                    'rgb(59, 130, 246)',
                                    'rgb(16, 185, 129)',
                                    'rgb(239, 68, 68)',
                                    'rgb(245, 158, 11)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Age Chart
                    new Chart(document.getElementById('ageChart'), {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($ageGroups->pluck('age_group')) !!},
                            datasets: [{
                                label: 'Jumlah Peserta',
                                data: {!! json_encode($ageGroups->pluck('total')) !!},
                                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                borderColor: 'rgb(59, 130, 246)',
                                borderWidth: 1,
                                borderRadius: 5,
                                barPercentage: 0.6
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });

                    // Registration Trends Chart
                    new Chart(document.getElementById('registrationChart'), {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($registrationTrends->pluck('date')) !!},
                            datasets: [{
                                label: 'Registrasi',
                                data: {!! json_encode($registrationTrends->pluck('total')) !!},
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });

                    // Province Distribution Chart
                    new Chart(document.getElementById('provinceChart'), {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($provincesDistribution->pluck('provinsi')) !!},
                            datasets: [{
                                data: {!! json_encode($provincesDistribution->pluck('total')) !!},
                                backgroundColor: [
                                    'rgba(59, 130, 246, 0.8)',
                                    'rgba(16, 185, 129, 0.8)',
                                    'rgba(239, 68, 68, 0.8)',
                                    'rgba(245, 158, 11, 0.8)',
                                    'rgba(147, 51, 234, 0.8)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Payment Method Chart
                    new Chart(document.getElementById('paymentMethodChart'), {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($paymentMethodStats->pluck('midtrans_payment_type')) !!},
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                data: {!! json_encode($paymentMethodStats->pluck('total')) !!},
                                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                borderColor: 'rgb(59, 130, 246)',
                                borderWidth: 1,
                                borderRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });

                    // Blood Type Chart
                    new Chart(document.getElementById('bloodTypeChart'), {
                        type: 'pie',
                        data: {
                            labels: {!! json_encode($bloodTypes->pluck('golongan_darah')) !!},
                            datasets: [{
                                data: {!! json_encode($bloodTypes->pluck('total')) !!},
                                backgroundColor: [
                                    'rgba(239, 68, 68, 0.8)',
                                    'rgba(59, 130, 246, 0.8)',
                                    'rgba(16, 185, 129, 0.8)',
                                    'rgba(245, 158, 11, 0.8)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Medical Stats Chart
                    new Chart(document.getElementById('medicalChart'), {
                        type: 'bar',
                        data: {
                            labels: ['Dengan Alergi', 'Tanpa Alergi', 'Dengan Riwayat Medis'],
                            datasets: [{
                                label: 'Jumlah Peserta',
                                data: [
                                    {!! $medicalStats['with_allergies'] !!},
                                    {!! $medicalStats['without_allergies'] !!},
                                    {!! $medicalStats['with_medical_history'] !!}
                                ],
                                backgroundColor: [
                                    'rgba(239, 68, 68, 0.8)',
                                    'rgba(16, 185, 129, 0.8)',
                                    'rgba(245, 158, 11, 0.8)'
                                ],
                                borderColor: [
                                    'rgb(239, 68, 68)',
                                    'rgb(16, 185, 129)',
                                    'rgb(245, 158, 11)'
                                ],
                                borderWidth: 1,
                                borderRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });

                    // Check-in by Hour Chart
                    new Chart(document.getElementById('checkInChart'), {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($checkInStats['check_in_by_hour']->pluck('hour')) !!},
                            datasets: [{
                                label: 'Check-in',
                                data: {!! json_encode($checkInStats['check_in_by_hour']->pluck('total')) !!},
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Jam'
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });

                } catch (error) {
                    console.error('Error:', error);
                }
            });
        </script>
    @endpush
@endsection
