@extends('layouts.student')

@section('title', 'Student Dashboard - OBE System')

@section('content')
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="mb-2 mb-md-0 text-break">Welcome, Riadul Islam</h2>
                <span class="badge bg-primary p-2 mt-2 mt-md-0">Semester: Spring 2025</span>
            </div>

            <div class="row mb-4">
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card p-3 stat-card h-100">
                        <h6>Enrolled Courses</h6>
                        <h4>05</h4>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card p-3 stat-card h-100" style="border-color: #198754;">
                        <h6>New Files Uploaded</h6>
                        <h4>12</h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 stat-card h-100" style="border-color: #ffc107;">
                        <h6>Pending Assignments</h6>
                        <h4>03</h4>
                    </div>
                </div>
            </div>

            <section id="course-info" class="mb-5">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-graduation-cap me-2"></i> <strong>My Course Information</strong>
                    </div>
                    <div class="card-body px-2 px-md-3">
                        <div class="table-responsive">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Instructor</th>
                                        <th>Year</th>
                                        <th>Semester</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CSE-0400</td>
                                        <td>System Design Project</td>
                                        <td>Dr. Ahmed</td>
                                        <td>2025</td>
                                        <td>Spring</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection
