@extends('layouts.app')

@section('title', 'Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashbaord.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@push('csrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')

   <!-- Navigation Bar -->
   <nav class="navbar">
    <h1>Task Manager</h1>
    <div class="nav-right">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<!-- Task Card -->
<div class="task-card">
    <h2>My Tasks</h2>
    <div class="add-btn">
        <button type="button">Add Task</button>
    </div>
    <div class="task-status-buttons">
        <div class="task-status-buttons">
            <a href="{{ route('tasks.filter', ['type' => 'all']) }}" class="status-btn {{ request()->query('type') == 'all' ? 'active' : '' }}">All</a>
            <a href="{{ route('tasks.filter', ['type' => 'pending']) }}" class="status-btn {{ request()->query('type') == 'pending' ? 'active' : '' }}">Pending</a>
            <a href="{{ route('tasks.filter', ['type' => 'completed']) }}" class="status-btn {{ request()->query('type') == 'completed' ? 'active' : '' }}">Completed</a>
        </div>
    </div>
    <ul id="task-list">
        @foreach ($tasks as $task)
        <li>
            <span class="priority 
                @if($task->priority == 'Low')
                    low
                @elseif($task->priority == 'Medium')
                    medium
                @elseif($task->priority == 'High')
                    high
                @endif
            "></span> <span class="title">{{ $task->title }}</span>
            <select class="task-action" task_id='{{ $task->id }}'>
                <option value="pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="edit">Edit</option>
                <option value="delete">Delete</option>
            </select>
        </li>
        @endforeach
    </ul>

    <div>
        {{ $tasks->links() }}
    </div>
</div>

<!-- Modal Background -->
<div id="custom-modal" class="modal">
    <div class="modal-content">
        <h2>Add Task</h2>
        
        <!-- Task Title -->
        <input type="hidden" value="" id='task-id'>
        <label for="task-title">Title</label>
        <input type="text" id="task-title" placeholder="Enter task title">
        <div class="text-danger hidden Ttitle">
           
        </div>

        <!-- Task Description -->
        <label for="task-desc">Description</label>
        <textarea id="task-desc" placeholder="Enter task description"></textarea>

        <!-- Priority Dropdown -->
        <label for="task-priority">Priority</label>
        <select id="task-priority">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>

        <!-- Due Date -->
        <label for="task-due-date">Due Date</label>
        <input type="date" id="task-due-date">
        <div class="text-danger hidden Ddate">
           
        </div>

        <!-- Buttons -->
        <div class="modal-buttons">
            <button class="save-btn">Save</button>
            <button class="cancel-btn">Cancel</button>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('js/script.js') }}"></script>
@endpush
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
