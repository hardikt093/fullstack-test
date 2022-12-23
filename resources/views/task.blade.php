@extends('layouts.layout')
@section('content')
<section class="section-content pt-1">
    <div class="container-fluid height-100">
        <div class="row">
            <div class="col-sm-8">
                <h3 class="page-title">Task Lists</h3>
            </div>
            <div class="col-sm-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">Create Task</button>
            </div>
        </div>
        <div class="card-top d-flex">
            <div class="card-body">
                <div class="card-body-top d-flex justify-content-between align-items-center py-2 px-3">
                    <h2>Task Today</h2>
                </div>
                <div class="card-body-top-main" id="today-task">
                    
                </div>
            </div>
            <div class="card-body">
                <div class="card-body-top progress-blue d-flex justify-content-between align-items-center py-2 px-3">
                    <h2>Task Tomorrow</h2>
                </div>
                <div class="card-body-top-main" id="tomorrow-task">
                    
                </div>
            </div>
            <div class="card-body">
                <div class="card-body-top bg-purple d-flex justify-content-between align-items-center py-2 px-3">
                    <h2>Task Next Week</h2>
                </div>
                <div class="card-body-top-main" id="next-week-task">
                    
                </div>
            </div>
            <div class="card-body">
                <div class="card-body-top progress-red d-flex justify-content-between align-items-center py-2 px-3">
                    <h2>Task Next Month</h2>
                </div>
                <div class="card-body-top-main" id="next-month-task">
                    
                </div>
            </div>
            <div class="card-body">
                <div class="card-body-top progress-lightred d-flex justify-content-between align-items-center py-2 px-3">
                    <h2>Task Next</h2>
                </div>
                <div class="card-body-top-main" id="next-task">
                    
                </div>
            </div>
            <div class="card-body">
                <div class="card-body-top bg-lightgreen d-flex justify-content-between align-items-center py-2 px-3">
                    <h2>Completed</h2>
                </div>
                <div class="card-body-top-main" id="completed-task">
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => url('task/create'), 'class' => 'tooltip-right-bottom', 'id' => 'formtask']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="description">Description</label>
                        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                        {!! Form::text('start_date', null, ['class' => 'form-control datepicker', 'id' => 'start_date']) !!}
                    </div>
                    <div class="form-group col-md-6 mb-3 end-date-box">
                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                        {!! Form::text('end_date', null, ['class' => 'form-control datepicker', 'id' => 'end_date']) !!}
                    </div>
                    
                    <div class="form-group col-md-12 mb-3">
                        <label for="period">Repeat <span class="text-danger">*</span></label>
                        {!! Form::select('period', [null => 'Select'] + $periods, null, ['class' => 'form-control', 'id' => 'period']) !!}
                    </div>
                    <div class="col-12 text-right">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('page-scripts')
<script src="{{ asset('/js/task.js') }}"></script>
@endsection