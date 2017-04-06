{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
        {!! HTML::style('css/bootstrap.css') !!}
        {!! HTML::style('css/backend/chosen.min.css') !!}

          {!! HTML::script('js/backend/chosen.jquery.min.js') !!}

        <script type="text/javascript">
          $(document).ready(function(){
            $("select.chosen-selectmain").chosen({width: "100%"});
                    });
        </script>
<div class="form-group required" id="otherarea">
      <select data-placeholder="Choose some other Guide area..." name="OtherGuidingArea[]" multiple="multiple" class="chosen-selectmain form-control margin">
          @foreach($options as  $option)
          <option value="{{$option}}" >
            {{$option}}
          </option>
          @endforeach
      </select>
</div><!--form control-->
