@extends('layouts.student')

@section('title', 'Course File Info - Student Dashboard')

@section('content')

        <div class="container-fluid">
            <h2 class="mb-4">Course Materials & Files</h2>

            <section id="course-files-1" class="mb-5">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-folder-open me-2 text-primary"></i> <strong>Course: CSE-0400 (System Design Project)</strong></span>
                        <span class="badge bg-primary">Spring 2025</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>File Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-primary">Notes</span></td>
                                        <td>Lecture 01</td>
                                        <td>Introduction to System Architecture</td>
                                        <td class="text-center"><a href="#" class="btn-download"><i class="fas fa-download me-1"></i> Download</a></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-success">Slides</span></td>
                                        <td>Chapter 2</td>
                                        <td>UI/UX Design Principles PPT</td>
                                        <td class="text-center"><a href="#" class="btn-download"><i class="fas fa-eye me-1"></i> View</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section id="course-files-2" class="mb-5">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center border-bottom">
                        <span><i class="fas fa-folder-open me-2 text-success"></i> <strong>Course: CSE-0300 (Database Management System)</strong></span>
                        <span class="badge bg-success">Spring 2025</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>File Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge bg-warning text-dark">Assignment</span></td>
                                        <td>ER Diagram</td>
                                        <td>Database Schema Design Assignment - 01</td>
                                        <td class="text-center"><a href="#" class="btn-download"><i class="fas fa-download me-1"></i> Download</a></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-danger">CT</span></td>
                                        <td>Question</td>
                                        <td>Class Test 01 - SQL Queries & Joins</td>
                                        <td class="text-center"><a href="#" class="btn-download"><i class="fas fa-file-pdf me-1"></i> View PDF</a></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge bg-primary">Notes</span></td>
                                        <td>Lecture 05</td>
                                        <td>Normalization (1NF, 2NF, 3NF) Handwritten Notes</td>
                                        <td class="text-center"><a href="#" class="btn-download"><i class="fas fa-download me-1"></i> Download</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
