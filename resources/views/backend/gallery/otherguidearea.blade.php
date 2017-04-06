{!! HTML::style('css/font-awesome/css/font-awesome.min.css') !!}
        {!! HTML::style('css/bootstrap.css') !!}
        {!! HTML::style('css/backend/chosen.min.css') !!}

          {!! HTML::script('js/backend/chosen.jquery.min.js') !!}

        <script type="text/javascript">
          $(document).ready(function(){
            $("select.chosen-selectmain").chosen();
                    });
        </script>
<div class="form-group required" id="otherarea">
    {!! Form::label('otherArea', trans('validation.attributes.otherArea'), ['class' => 'col-lg-2 col-md-2 control-label']) !!}
    <div class="col-lg-10">
      <select data-placeholder="Choose some other Guide area..." name="OtherGuidingArea[]" multiple="multiple" class="chosen-selectmain form-control margin">
          @foreach($options as  $option)
          <option value="{{$option}}" >
            {{$option}}
          </option>
          @endforeach
      </select>
     
    </div>
</div><!--form control-->
