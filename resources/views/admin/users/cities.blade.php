<label class="form-control-label" for="city">City</label>
<select id="city" class="form-control" name="city" data-plugin="selectpicker" onchange="setCityField(this)">
	<option></option>
	<?php foreach ($cities as $id => $city) { ?>
		<option value="<?= $id ?>" <?= (isset($ucity) && $ucity == $city) ? 'selected' : '' ?>><?= $city ?></option>
	<?php } ?>
</select>
<input id="city_name" type = "hidden" name = "city_name" value = "<?= (isset($ucity)) ? $ucity:''?>" />