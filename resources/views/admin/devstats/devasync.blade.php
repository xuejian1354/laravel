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
      <td style="min-width: 160px;">
        <button onclick="javascript:deviceOptDialog('{{ $devices[$index]->name }}', '{{ $devices[$index]->gw_sn }}', '{{ $devices[$index]->dev_sn }}', '{{ $devices[$index]->dev_type }}', '{{ $devices[$index]->iscmdfound }}');" type="button" class="btn btn-info" role="button" data-target="#devOptModal" data-toggle="modal">操作</button>
        <button onclick="location='{{ url('/admin?action=devstats/devedit&id='.$devices[$index]->id) }}'" type="button" class="btn btn-primary" role="button">修改</button>
        <button onclick="javascript:deviceDelAlert('{{ $devices[$index]->id }}', '{{ $devices[$index]->dev_sn }}', '1', '{{ csrf_token() }}');" type="button" class="btn btn-danger" role="button">删除</button>
      </td>
    </tr>
  @endfor
</tbody>