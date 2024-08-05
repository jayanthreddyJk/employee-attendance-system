<table class="table table-bordered">
    <thead>
        <tr>
            <th>Punch In</th>
            <th>Punch Out</th>
        </tr>
    </thead>
    <tbody>
        @forelse($punchRecords as $record)
        <tr>
            <td>{{ $record->punch_in }}</td>
            <td>{{ $record->punch_out }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2" class="text-center">No records found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
