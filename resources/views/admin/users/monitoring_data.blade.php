<table class="table table-bordered">
    <thead>
    <tr>
        <th>Date</th>
        <th>Results</th>
    </tr>
    </thead>
    <tbody>
        @foreach($list as $monitor)
        <tr>
            <td>{{$monitor->created_at}}</td>
            <td>{{$monitor->set_reps}}</td>
        </tr>
        @endforeach
        @if(count($list) == 0)
        <tr>
            <td colspan="2">NO DATA FOUND!</td>
        </tr>
        @endif
    </tbody>
</table>