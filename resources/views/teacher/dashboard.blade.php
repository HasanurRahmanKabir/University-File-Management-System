@extends('layouts.teacher')

@section('title', 'Teacher Dashboard - OBE System')

@section('content')
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="mb-2 mb-md-0 text-break">Welcome, Masud Tarek</h2>
                <span class="badge bg-success p-2 mt-2 mt-md-0">Academic Year: 2025</span>
            </div>

            <div class="row mb-4">
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card p-3 stat-card h-100">
                        <h6>Active Courses</h6>
                        <h4>03</h4>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card p-3 stat-card h-100" style="border-color: #0d6efd;">
                        <h6>Total Students</h6>
                        <h4>145</h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 stat-card h-100" style="border-color: #dc3545;">
                        <h6>Total Uploads</h6>
                        <h4>24</h4>
                    </div>
                </div>
            </div>

            <section class="mb-5">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-tasks me-2"></i> <strong>Current Course Overview</strong>
                    </div>
                    <div class="card-body px-2 px-md-3">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Files</th>
                                        <th>Year</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CSE-0400</td>
                                        <td>System Design Project</td>
                                        <td>12</td>
                                        <td>2025</td>
                                        <td><button class="btn btn-sm btn-success">View Details</button></td>
                                    </tr>
                                    <tr>
                                        <td>CSE-0300</td>
                                        <td>Database Management System</td>
                                        <td>08</td>
                                        <td>2025</td>
                                        <td><button class="btn btn-sm btn-success">View Details</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
