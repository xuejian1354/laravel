@section('userdetails')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h5 style="float: right;">当前用户: {{ $user->name }}<br>
  <a href="admin?action=usermanage&tabpos={{ $user->grade-1 }}" style="float: right; margin-top: 5px;">返回</a></h5>
  <h1 class="page-header">{{ $amenu->cmenu }}</h1>

  @if($userdetail != null)
    @if(isset($info))
    <div class="alert alert-success">
      {{ $info }}
    </div>
    @endif
  <a id='tripot' href="javascript:loadDetailEdt();" style="float: right;">修改</a>
  <form method="POST" action="{{ url('/admin/userdetails/adddetail') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="sn" value="{{ $user->sn }}">
    <table class="table table-striped table-bordered">
      <tbody>
        <tr>
          <td><b>姓名</b></td>
          <td class="detailshow">{{ $userdetail->name }}</td>
          <td class="detailedt hidden"><input name="userdetailname" class="form-control" type="text" placeholder="{{ $user->name }}" value="{{ $userdetail->name }}"></td>
          <td><b>性别</b></td>
          <td class="detailshow">{{ $userdetail->sexuality }}</td>
          <td class="detailedt hidden">
            <select name="sexuality" class="form-control">
            @if($userdetail->sexuality == '男')
              <option selected="selected">男</option>
            @else
              <option>男</option>
            @endif
            @if($userdetail->sexuality == '女')
              <option selected="selected">女</option>
            @else
              <option>女</option>
            @endif
            </select>
          </td>
          <td><b>民族</b></td>
          <td class="detailshow">{{ $userdetail->people }}</td>
          <td class="detailedt hidden"><input name="people" class="form-control" type="text" placeholder="汉" value="{{ $userdetail->people }}"></td>
        </tr>
        @if($user->grade == 3)
        <tr>
          <td><b>学号</b></td>
          <td class="detailshow">{{ $userdetail->num }}</td>
          <td class="detailedt hidden"><input name="num" class="form-control" type="text" value="{{ $user->sn }}"></td>
          <td><b>班级</b></td>
          <td class="detailshow">{{ $userdetail->typestr }}</td>
          <td class="detailedt hidden">
            <select name="typestr" class="form-control">
            @foreach($classgrades as $classgrade)
              @if($userdetail->typestr == $classgrade->val)
              <option selected="selected">{{ $classgrade->val }}</option>
              @else
              <option>{{ $classgrade->val }}</option>
              @endif
            @endforeach
            </select>
          </td>
          <td><b>身份</b></td>
          <td class="detailshow">学生</td>
          <td class="detailedt hidden"><input name="gradestr" readonly="true" value="学生" style="border: none;"></td>
        </tr>
        @elseif($user->grade == 2)
        <tr>
          <td><b>工号</b></td>
          <td class="detailshow">{{ $userdetail->num }}</td>
          <td class="detailedt hidden"><input name="num" class="form-control" type="text" value="{{ $user->sn }}"></td>
          <td><b>学院</b></td>
          <td class="detailshow">{{ $userdetail->typestr }}</td>
          <td class="detailedt hidden">
            <select name="typestr" class="form-control">
            @foreach($academies as $academy)
              @if($userdetail->typestr == $academy->val)
                <option selected="selected">{{ $academy->val }}</option>
              @else
                <option>{{ $academy->val }}</option>
              @endif
            @endforeach
            </select>
          </td>
          <td><b>身份</b></td>
          <td class="detailshow">教师</td>
          <td class="detailedt hidden"><input name="gradestr" readonly="true" value="教师" style="border: none;"></td>
        </tr>
        @else
        <tr>
          <td><b>工号</b></td>
          <td colspan="5" class="detailshow">{{ $userdetail->num }}</td>
          <td colspan="2" class="detailedt hidden"><input name="num" class="form-control" type="text" value="{{ $user->sn }}"></td>
        </tr>
        @endif
        <tr>
          <td><b>出生年月</b></td>
          <td colspan="2" class="detailshow">{{ $userdetail->birthdate }}</td>
          <td colspan="2" class="detailedt hidden"><input name="birthdate" class="form-control" type="text" value="{{ $userdetail->birthdate }}"></td>
          <td><b>籍贯</b></td>
          <td colspan="2" class="detailshow">{{ $userdetail->native }}</td>
          <td colspan="2" class="detailedt hidden"><input name="native" class="form-control" type="text" value="{{ $userdetail->native }}"></td>
        </tr>
        <tr>
          <td><b>联系电话</b></td>
          <td colspan="2" class="detailshow">{{ $userdetail->cellphone }}</td>
          <td colspan="2" class="detailedt hidden"><input name="cellphone" class="form-control" type="text" value="{{ $userdetail->cellphone }}"></td>
          <td><b>政治面貌</b></td>
          <td colspan="2" class="detailshow">{{ $userdetail->polity }}</td>
          <td colspan="2" class="detailedt hidden"><input name="polity" class="form-control" type="text" value="{{ $userdetail->polity }}"></td>
        </tr>
        <tr>
          <td><b>身份证号码</b></td>
          <td colspan="5" class="detailshow">{{ $userdetail->civinum }}</td>
          <td colspan="5" class="detailedt hidden"><input name="civinum" class="form-control" type="text" value="{{ $userdetail->civinum }}"></td>
        </tr>
        <tr>
          <td><b>家族住址</b></td>
          <td colspan="5" class="detailshow">{{ $userdetail->address }}</td>
          <td colspan="5" class="detailedt hidden"><input name="address" class="form-control" type="text" value="{{ $userdetail->address }}"></td>
        </tr>
        <tr>
          <td><b>QQ</b></td>
          <td colspan="2" class="detailshow">{{ $userdetail->qq }}</td>
          <td colspan="2" class="detailedt hidden"><input name="qq" class="form-control" type="text" value="{{ $userdetail->qq }}"></td>
          <td><b>邮箱</b></td>
          <td colspan="2" class="detailshow">{{ $userdetail->email }}</td>
          <td colspan="2" class="detailedt hidden"><input name="email" class="form-control" type="text" value="{{ $userdetail->email }}"></td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="btn btn-info detailedt hidden">提交</button>
  </form>
  @else
    @if(isset($info))
    <div class="alert alert-danger">
      {{ $info }}
    </div>
    @else
    <div class="alert alert-info">
    @if($user->grade == 4)
      <strong>Whoops ! </strong>没有发现 {{ $user->name }} 的个人资料哟 !<br>请认真填写，方便管理员识别您的身份信息 !
    @else
      <strong>Whoops ! </strong>没有发现 {{ $user->name }} 的个人资料哟，请在此处添加
    @endif
    </div>
    @endif
  <form method="POST" action="{{ url('/admin/userdetails/adddetail') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="sn" value="{{ $user->sn }}">
    <table class="table table-striped table-bordered">
      <tbody>
        <tr>
          <td><b>姓名*</b></td>
          <td><input name="userdetailname" class="form-control" type="text" placeholder="{{ $user->name }}"></td>
          <td><b>性别</b></td>
          <td>
            <select name="sexuality" class="form-control">
              <option>男</option>
              <option>女</option>
            </select>
          </td>
          <td><b>民族</b></td>
          <td><input name="people" class="form-control" type="text" placeholder="汉"></td>
        </tr>
        @if($user->grade == 3)
        <tr>
          <td><b>学号*</b></td>
          <td><input name="num" class="form-control" type="text" value="{{ $user->sn }}"></td>
          <td><b>班级*</b></td>
          <td>
            <select name="typestr" class="form-control">
            @foreach($classgrades as $classgrade)
              <option>{{ $classgrade->val }}</option>
            @endforeach
            </select>
          </td>
          <td><b>身份*</b></td>
          <td><input name="gradestr" readonly="true" value="学生" style="border: none;"></td>
        </tr>
        @elseif($user->grade == 2)
        <tr>
          <td><b>工号*</b></td>
          <td><input name="num" class="form-control" type="text" value="{{ $user->sn }}"></td>
          <td><b>学院*</b></td>
          <td>
            <select name="typestr" class="form-control">
            @foreach($academies as $academy)
              <option>{{ $academy->val }}</option>
            @endforeach
            </select>
          </td>
          <td><b>身份*</b></td>
          <td><input name="gradestr" readonly="true" value="教师" style="border: none;"></td>
        </tr>
        @else
        <tr>
          <td><b>工号*</b></td>
          <td colspan="2"><input name="num" class="form-control" type="text" value="{{ $user->sn }}"></td>
        </tr>
        @endif
        <tr>
          <td><b>出生年月</b></td>
          <td colspan="2"><input name="birthdate" class="form-control" type="text"></td>
          <td><b>籍贯</b></td>
          <td colspan="2"><input name="native" class="form-control" type="text"></td>
        </tr>
        <tr>
          <td><b>联系电话</b></td>
          <td colspan="2"><input name="cellphone" class="form-control" type="text"></td>
          <td><b>政治面貌</b></td>
          <td colspan="2"><input name="polity" class="form-control" type="text"></td>
        </tr>
        <tr>
          <td><b>身份证号码</b></td>
          <td colspan="5"><input name="civinum" class="form-control" type="text"></td>
        </tr>
        <tr>
          <td><b>家族住址</b></td>
          <td colspan="5"><input name="address" class="form-control" type="text"></td>
        </tr>
        <tr>
          <td><b>QQ</b></td>
          <td colspan="2"><input name="qq" class="form-control" type="text"></td>
          <td><b>邮箱</b></td>
          <td colspan="2"><input name="email" class="form-control" type="text"></td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="btn btn-info">提交</button>
  </form>
  @endif
</div>
<script type="text/javascript">
function loadDetailEdt()
{
	if($('#tripot').text() != '修改')
	{
		$('.detailshow').removeClass('hidden');
		$('.detailedt').addClass('hidden');
		$('#tripot').text('修改');
	}
	else
	{
		$('.detailshow').addClass('hidden');
		$('.detailedt').removeClass('hidden');
		$('#tripot').text('取消');
	}
}
</script>
@endsection