@if ($form_name === 'form_order')
    <select name="dropdown_order" onchange="submit(this.form)" class="display-inlineblock text">
        @foreach ($order_types as $order_type_key => $order_type_value)
        <option value="<?= $order_type_key; ?>" {{ $order_type_key === $order ? " selected" : '' }}><?= $order_type_value; ?>順</option>
        @endforeach
    </select>
@else
    <input type="hidden" name="dropdown_order" value="<?= $order; ?>"/>
@endif
@if ($form_name === 'form_display')
    @foreach ($display_option as $display_option_key => $display_option_value)
    <label><input type="checkbox" name="<?= $display_option_value['name']; ?>" value="<?= $display_option_key ; ?>" class="display_inline-block" {{ $display_option_value['status'] === "checked" ? " checked" : '' }}><?= $display_option_value['value_jap']; ?></label>
    @endforeach
@else
    @foreach ($checked_display_option as $checked_display_option_key => $checked_display_option_value)
    <input type="hidden" name="<?= $checked_display_option_value['name']; ?>" value="<?= $checked_display_option_key; ?>" class="display-inlineblock">
    @endforeach
@endif
@if ($form_name === 'form_peginate_prev')
    <input type="hidden" name="page_token" value="<?= $result->prevPageToken; ?>"/>
@endif
@if ($form_name === 'form_peginate_next')
    <input type="hidden" name="page_token" value="<?= $result->nextPageToken; ?>"/>
@endif