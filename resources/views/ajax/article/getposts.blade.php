<table class="table table-striped jambo_table bulk_action" id="tabledata" style="font-size: 12px; ">
<thead>
<tr class="headings">
<th class="column-title text-center">STT</th>
<th class="column-title text-center" style="width: 150px">Tiêu đề</th>
<th class="column-title text-center">Hình ảnh</th>
<th class="column-title text-center">Mô tả</th>
</tr>
</thead>
<tbody id="dataPost">
	@if (empty($arData))
<tr class="even pointer">
  <td class="text-center " colspan="4">
     <p>No data</p>
  </td>
</tr>
@else
@foreach ($arData as $key => $item)
@php
    $aname = $item['title'];
    $code = str_slug($aname);
    $preview_text = $item['description'];
    $picture = $item['img'];
    $href = $item['href'];
    $trrow = "odd"
@endphp
@if ($key % 2 == 0)
    @php
        $trrow = "even";
    @endphp
@endif
<tr class="{{ $trrow }} pointer">
<td class="text-center">{{ $key+1 }}</td>
<td class=" ">
  <a href="{{ $href }}" target="_blank" title="" rel="nofollow">{{ $aname }}</a>
</td>
<td class="text-center">
  @if(!empty($picture))
    <a href="{{ $picture }}" target="_blank"><img height="100px" width="150px" src="{{$picture}}" alt=""/></a>
  @endif
</td>
<td class="text-center">{{$preview_text}}</td>
</tr>
@endforeach
@endif
<tr >
<td class="text-center" colspan="4">
	<input type="hidden" name="countData" readonly value="{{ count($arData) }}">
</td>
</tr>
</tbody>
</table>

