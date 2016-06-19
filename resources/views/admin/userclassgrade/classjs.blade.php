<script type="text/javascript">
function loadQueryRooms()
{
	var tobj = new Object();
	tobj.time = $('#querytime').val();
	if(tobj.time == null || tobj.time == '无')
	{
		tobj.time = undefined;
	}

	tobj.method = $('#querychr').attr('method');
	if(tobj.method == 1)
	{
		tobj.roomnamesn = $('#roomnamesn').val();
		if(tobj.roomnamesn == null || tobj.roomnamesn == '无')
		{
			tobj.roomnamesn = undefined;
			if(tobj.time == undefined)
			{
				alert('请设置查询条件');
				return;
			}
		}
	}
	else
	{
		tobj.roomtype = $('#roomtype option:selected').attr('roomtype');
		tobj.roomaddr = $('#roomaddr option:selected').attr('roomaddr');
		if(tobj.roomtype == '无')
		{
			tobj.roomtype = undefined;
		}

		if(tobj.roomaddr == '无')
		{
			tobj.roomaddr = undefined;
		}

		if(tobj.roomtype == undefined && tobj.roomaddr == undefined && tobj.time == undefined)
		{
			alert('请设置查询条件');
			return;
		}
	}

	//alert(JSON.stringify(tobj));
	loadContent('queryRoomlist', '/admin?action=userclassgrade/queryroom&data='+JSON.stringify(tobj));
}

$('#querychr').change(function(){
	if($(this).val() == '条件查询')
	{
		$('.curquery').addClass('hidden');
		$('.conquery').removeClass('hidden');
		$('#querychr').attr('method', '2');
	}
	else
	{
		$('.curquery').removeClass('hidden');
		$('.conquery').addClass('hidden');
		$('#querychr').attr('method', '1');
	}

	$('#roomnamesn').val('');
	$('.setselect').val('');
});

@if($user->privilege > 3)
$('#optsel').change(function(){
	var roomsn = $('#optsel option:selected').attr('roomsn');
	loadContent('optlist', '/admin?action=userclassgrade/opt&roomsn='+roomsn);
});
@endif

$('.setblank').remove();
$('.setselect').val('');
</script>