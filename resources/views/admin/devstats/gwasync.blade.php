<tbody id="gwtbody">
  @for($index=0; $index < count($gateways); $index++)
    <tr>
      <td>{{ $index+1 }}</td>
      <td>{{ $gateways[$index]->name }}</td>
      <td>{{ $gateways[$index]->gw_sn }}</td>
      <td>{{ $gateways[$index]->transtocol }}</td>
      <td>{{ $gateways[$index]->area }}</td>
      <td>{{ $gateways[$index]->ispublic }}</td>
      <td>{{ $gateways[$index]->owner }}</td>
      <td>{{ $gateways[$index]->updated_at }}</td>
      <td>
        <a href="{{ url('/admin?action=devstats/gwedit&id='.$gateways[$index]->id) }}" class="btn btn-primary" role="button">修改</a>
        <a href="javascript:gatewayDelAlert('{{ $gateways[$index]->id }}', '{{ $gateways[$index]->gw_sn }}', '0', '{{ csrf_token() }}');" class="btn btn-danger" role="button">删除</a>
      </td>
    </tr>
  @endfor
</tbody>