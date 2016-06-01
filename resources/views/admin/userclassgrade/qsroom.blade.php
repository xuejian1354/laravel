<div class="table-responsive">
  <table class="table table-striped" style="min-width: 500px; max-width: 600px;">
    <thead>
      <tr>
        <th>#</th>
        <th>教室</th>
        <th>使用情况</th>
        <th>时间</th>
        <th>课程</th>
        <th>使用者</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="devtbody">
	@foreach($qsrooms as $index => $qsroom)
	  <tr>
	    <td>{{ $index+1 }}</td>
	    <td>{{ $qsroom->name }}</td>
	    @if($qsroom->isuse)
	      <td>已使用</td>
	    @else
	      <td>未使用</td>
	    @endif
	    <td>{{ $qsroom->time }}</td>
	    @if($qsroom->course)
	      <td>{{ $qsroom->course }}</td>
	    @else
	      <td>无</td>
	    @endif
	    @if($qsroom->owner)
	      <td>{{ $qsroom->owner }}</td>
	    @else
	      <td>无</td>
	    @endif
	  </tr>
	@endforeach
	</tbody>
  </table>
</div>
