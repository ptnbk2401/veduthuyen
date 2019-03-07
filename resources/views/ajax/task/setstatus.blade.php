<select name="status" id="selectid" size="1" class="form-control" style="font-size:10px;padding:6px 2px;width:120px" onchange="return setStatus({{ $id }})">
@foreach ($arStatus as $key => $statusName)
    @if ($key == $status)
    <option value="{{ $key }}" selected="selected">{{ $statusName }}</option>
    @else
    <option value="{{ $key }}">{{ $statusName }}</option>
    @endif
@endforeach
</select>