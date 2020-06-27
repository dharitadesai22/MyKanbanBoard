@extends('layouts.app')

@section('content')
            @if (session('status'))
                <div class="text-sm border border-t-8 rounded px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

@endsection
