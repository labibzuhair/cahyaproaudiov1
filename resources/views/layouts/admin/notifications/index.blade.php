@extends('layouts.admin.master.master')

@section('title', 'Notifikasi Admin')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Notifikasi Admin</h2>
        @if ($notifications->isEmpty())
            <p class="text-center">Tidak ada notifikasi.</p>
        @else
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notification->created_at->format('d-m-Y') }}</div>
                                <span class="font-weight-bold">{{ $notification->data['message'] }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
