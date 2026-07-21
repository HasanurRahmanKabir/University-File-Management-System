@extends('layouts.student')

@section('title', 'Category List - Student Dashboard')

@section('content')

        <div class="container-fluid">
            <h2 class="mb-4 fw-bold text-dark">Course Categories</h2>

            <section id="core-courses" class="mb-5">
                <div class="card">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fas fa-code me-2"></i> Core Courses
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-header-custom text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Focus Area</th>
                                        <th>Credits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>01</td>
                                        <td class="fw-bold">Data Structures</td>
                                        <td>Algorithm & Logic</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>02</td>
                                        <td class="fw-bold">Operating Systems</td>
                                        <td>System Management</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>03</td>
                                        <td class="fw-bold">Software Engineering</td>
                                        <td>Development Lifecycle</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section id="electrical-courses" class="mb-5">
                <div class="card">
                    <div class="card-header bg-warning text-dark font-weight-bold">
                        <i class="fas fa-bolt me-2"></i> Electrical Courses
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-header-custom text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Focus Area</th>
                                        <th>Credits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>01</td>
                                        <td class="fw-bold">Electrical Circuits</td>
                                        <td>Circuit Analysis</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>02</td>
                                        <td class="fw-bold">Digital Logic Design</td>
                                        <td>Gate-level Processing</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                    <tr class="text-center">
                                        <td>03</td>
                                        <td class="fw-bold">Electronics</td>
                                        <td>Semiconductor Devices</td>
                                        <td><span class="badge bg-light text-dark border">3.0</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
