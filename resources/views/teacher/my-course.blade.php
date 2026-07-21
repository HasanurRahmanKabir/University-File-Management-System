@extends('layouts.teacher')

@section('title', 'My Course Info - Teacher Dashboard')

@section('content')

        <div class="container-fluid">
            <h2 class="mb-4">My Academic Courses</h2>

            <h4 class="section-title">Running Semester (Spring 2025)</h4>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Course Title</th>
                                    <th>Credit</th>
                                    <th>Students</th>
                                    <th>Schedule</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-success">CSE-0400</td>
                                    <td>System Design Project</td>
                                    <td>3.0</td>
                                    <td>45</td>
                                    <td>Monday (10:00 AM)</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-success">CSE-0302</td>
                                    <td>Database Systems Lab</td>
                                    <td>1.5</td>
                                    <td>50</td>
                                    <td>Wednesday (02:00 PM)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h4 class="section-title text-muted">Previous Semester Records</h4>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Semester</th>
                                    <th>Course Code</th>
                                    <th>Course Title</th>
                                    <th>Year</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fall</td>
                                    <td>CSE-0201</td>
                                    <td>Data Structures</td>
                                    <td>2024</td>
                                    <td><span class="badge bg-secondary">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>Fall</td>
                                    <td>CSE-0101</td>
                                    <td>Intro to Computing</td>
                                    <td>2024</td>
                                    <td><span class="badge bg-secondary">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>Spring</td>
                                    <td>CSE-0305</td>
                                    <td>Software Engineering</td>
                                    <td>2024</td>
                                    <td><span class="badge bg-secondary">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
