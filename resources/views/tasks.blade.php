<x-layout title="Tasks">
    <h1>Tasks</h1>

    @forelse ($tasks as $task)
        <li>{{ $task }}</li>
    @empty
        <p>There are no tasks.</p>
    @endforelse
</x-layout>
