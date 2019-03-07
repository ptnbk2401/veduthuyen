@if (!$objItems->first())
    @php
        $colspan = 7;
    @endphp
    <tr class="even pointer">
        <td class="a-center " colspan="{{ $colspan }}">
            <p>Chưa có dữ liệu</p>
        </td>
    </tr>
@else
    @foreach ($objItems as $key => $objItem)
        @php
            $id = $objItem->id;
            $arGroup = $objmVNEGroup->getItemsAllByUid($id);
            //dd($arGroup);
            $username = $objItem->username;
            $fullname = $objItem->fullname;
            $urlEdit = route('vadmin.core.user.edit', [$id]);
            $urlDel  = route('vadmin.core.user.del', [$id]);

            $trrow = "odd";
        @endphp
        @if ($key % 2 == 0)
            @php
                $trrow = "even";
            @endphp
        @endif
        <tr class="{{ $trrow }} pointer">
            <td class="a-center ">
                <input type="checkbox" class="flat vnedel" name="vnedel[]" value="{{ $id }}">
            </td>
            <td class=" ">{{ $fullname }}({{ $username }})</td>
            <td class=" ">
                @if (count($arGroup) > 0)
                    @foreach ($arGroup as $key => $arV)
                        {{$arV->name}} {{ ($key+1) != count($arGroup)?'|':'' }}
                    @endforeach
                @endif
            </td>
            <td class=" ">{{ $objItem->email }}</td>
            <td class=" ">{{ $objItem->phone }}</td>

            @if($objItem->active==0)
                <td class=" "><span id="doithay{{$id}}" ><img onclick="return active({{$id}})" src="/public/templates/admin/images/disactive.png"/></span></td>
            @else
                <td class=" "><span id="doithay{{$id}}" ><img onclick="return active({{$id}})" src="/public/templates/admin/images/active.png"/></span></td>
            @endif


            <td class=" ">{{ $id }}</td>
            <td class=" last"><a href="{{ $urlEdit }}">Sửa</a> | <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="{{ $urlDel }}">Xóa</a>
            </td>
        </tr>
    @endforeach
@endif