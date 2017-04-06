<?php
use App\Models\GuideArea;
use App\Models\Language;
$gareas = GuideArea::all();
$languages = Language::all();

?>
<div class="search-cat">
	<form id="guide-search" action="{{URL::to('search/results')}}" method="get" >
		<div class="select-type type">
			<select multiple="multiple" name="gAreas[]" class="testselect2" placeholder="Type">
			@foreach ($gareas as $area)
				<option value="{{ $area->guide_area }}">{{ $area->guide_area }}</option>
			@endforeach
			</select>
		</div>
		<div class="select-type">
			<select id="country" onchange="print_state('state',this.selectedIndex);$('#state')[0].sumo.reload();
" name="country[]" placeholder="Select Country" class="testselect2"></select>
		</div>
		<div class="select-type">
			<select id="state" name="state[]" placeholder="Select State" class="testselect2">
			</select>
		</div>
		<div class="select-type">
			<select multiple="multiple" name="glang[]" class="testselect2" placeholder="Select Language">
				@foreach ($languages as $language)
					<option value="{{ $language->language }}">{{ $language->language }}</option>
				@endforeach
			</select>
		</div>
		<div class="select-type select-one">
			<select name="exp-rate" placeholder="Order" class="SlectBox">
				<option value=""></option>
				<option value="Experience">Experience (Descending)</option>
				<option value="Experience">Experience (Ascending)</option>
				<option value="Rating">Rating (Decending)</option>
				<option value="Rating">Rating (Ascending)</option>
			</select>
		</div>
		<div class="input-type mob-input-type">
			<input type="text" name="dest-name" id="autocomplete-name" placeholder="Keyword" value="@if(!empty($selectedname)){{$selectedname}}@endif">
		</div>
		<div class="submit-wrap">
			<button class="btn btn-danger"><i class="fa fa-search"></i></button>
		</div>
	</form>
</div>
