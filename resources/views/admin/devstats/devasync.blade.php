<tbody id="devtbody">
  @for($index=0; $index < count($devices); $index++)
    <tr>
      <td>{{ $index+1 }}</td>
      <td>{{ $devices[$index]->name }}</td>
      <td>{{ $devices[$index]->dev_sn }}</td>
      <td>{{ $devices[$index]->dev_type }}</td>
      <td>{{ $devices[$index]->znet_status }}</td>
      <td>{{ $devices[$index]->dev_data }}</td>
      <td>{{ $devices[$index]->gw_sn }}</td>
      <td>{{ $devices[$index]->area }}</td>
      <td>{{ $devices[$index]->ispublic }}</td>
      <td>{{ $devices[$index]->owner }}</td>
      <td>{{ $devices[$index]->updated_at }}</td>
      <td>
        <a href="javascript:void(0);" class="btn btn-info" role="button">操作</a>
        <a href="{{ url('/admin?action=devstats/devedit&id='.$devices[$index]->id) }}" class="btn btn-primary" role="button">修改</a>
        <a href="javascript:deviceDelAlert('{{ $devices[$index]->id }}', '{{ $devices[$index]->dev_sn }}', '1', '{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
      </td>
    </tr>
  @endfor
</tbody>