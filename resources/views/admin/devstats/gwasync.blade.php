<tbody id="gwtbody">
  @for($index=0; $index < $gwpagetag->getRow(); $index++)
    @if($index < count($gateways))
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
        <button onclick="location='{{ url('/admin?action=devstats/gwedit&page='.$gwpagetag->getPage().'&id='.$gateways[$index]->id) }}'" type="button" class="btn btn-primary" role="button">修改</button>
        <button onclick="javascript:gatewayDelAlert('{{ $gateways[$index]->id }}', '{{ $gateways[$index]->gw_sn }}', '0', '{{ csrf_token() }}');" type="button" class="btn btn-danger" role="button">删除</button>
      </td>
    </tr>
    @elseif($gwpagetag->isavaliable())
    <tr style="height: 40px;"></tr>
    @endif
  @endfor
</tbody>