 <tr>
    <td>{{ $item->name }}</td>
    <td>{{ $item_count }}</td>
    <td class="text-right">Rp{{ $price_text }}</td>
    <input type="hidden" name="item[{{ $item->id }}][id]" value="{{ $item->id }}">
    <input type="hidden" name="item[{{ $item->id }}][name]" value="{{ $item->name }}">
    <input type="hidden" name="item[{{ $item->id }}][price]" value="{{ $item_price }}">
    <input type="hidden" name="item[{{ $item->id }}][count]" value="{{ $item_count }}">
 </tr>
