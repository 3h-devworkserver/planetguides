<?php

if( ! function_exists('get_ops'))
{
    /**
     * Returns resource operations for the datatables or nested sets
     *
     * @param $resource
     * @param $id
     * @param $class
     * @return string
     */
    function get_ops($resource, $id, $status, $class="btn")
    {
        if($class=="btn")
        {
            $show_class = "btn btn-xs bg-navy";
            $edit_class = "btn btn-xs bg-olive";
            $delete_class = "btn btn-xs btn-danger destroy";
        }
        else
        {
            $show_class = "inline-show";
            $edit_class = "inline-edit";
            $delete_class = "inline-delete";
        }
        
        $edit_path = route('admin.'.$resource.'.edit', ['id' => $id]);
        $delete_path = route('admin.'.$resource.'.destroy', ['id' => $id]);


        

        
        $ops  = '<ul class="list-inline no-margin-bottom">';
      
        $ops .=  '<li>';
        $ops .=  '<a class="'.$edit_class.'" href="'.$edit_path.'"><i class="fa fa-pencil-square-o"></i> '.trans('labels.button.edit').'</a>';
        $ops .=  '</li>';
        $ops .= '<li>';
        switch($status) {
            case 0:
                $ops .= '<a href="'.route('admin.pages.status', [$id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="Activate Page"></i></a> ';
                break;
            case 1:
                $ops .= '<a href="'.route('admin.pages.status', [$id, 0]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="Deactivate Page"></i></a> ';
                break;
            default:
                $ops .= '';
        }
        $ops .= '</li>';
       
       $ops .=  '<li>';
        $ops .= Form::open(['method' => 'DELETE', 'url' => $delete_path]);
        $ops .= Form::submit('&#xf1f8; ' .trans('labels.button.delete'), ['onclick' => "return confirm('".trans('alerts.delete.confirmation')."');", 'class' => $delete_class]);
        $ops .= Form::close();
        $ops .=  '</li>';
        $ops .=  '</ul>';
        return $ops;
    }
}



