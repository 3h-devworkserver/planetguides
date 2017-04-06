<?php namespace App\Http\Controllers\Backend;
use App\Repositories\Frontend\User\UserContract;
use App\Repositories\Frontend\Sliderupload;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Datatable;
use DB;
use File;
use Input;
use App\Repositories\Frontend\Licenseupload;
use App\Http\Requests\Backend\Access\User\DeleteSlidesRequest;

class SlidesController extends Controller {

    /**
     * @param UserContract $user
     */
    public function __construct(UserContract $user) {
        $this->user = $user;
    }

    public function getImages(){
        return view('backend.gallery.imagesUpload');
    }


    public function postImages(Sliderupload $gallery){
            $data['stat']='error';
            $data['msg'] = 'Unknown error';
            if ($this->user->checkUserAuth(['1','2'])) {
                $data['msg'] = 'Sorry you do not have access to delete this item!!!';
                return response()->json($data); 
            }
            
            $gallery->postImages();
            $msg = ('$gallery->result()');
            // return view('backend.gallery.imagesUpload')->withFlashSuccess('Successfully Uploaded Slides.');
            return redirect()->to('admin/slides/create')->withFlashSuccess('Successfully Uploaded Slides.');
        }

    public function getAllSlides(){
        $table = $this->setDatatableSlider(); //role of users
         return view('backend.slides.slides', compact('table'));
    }

    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableSlider()
    {
        $route = route('api.table.slides');
        
            //,trans('crud.slides.status')
        //, trans('crud.slides.image')
            return Datatable::table()
            ->addColumn(trans('crud.pages.name'), trans('crud.pages.image'),  trans('crud.pages.caption'), trans('crud.pages.image_type'),trans('crud.pages.created'))
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->render();

       
    }

    public function getAllSlidesImages(){
        
            $admin = $this->user->findOrThrowException(auth()->id());
            $slider = $admin->gallerys()->where('type','slides')->orderBy('created_at', 'desc');
            dd($slider);
    return view('frontend.includes.banner')->withUserid(auth()->id())->withGallerys($slider)->withClass('gallery');
    }

    public function deleteSlides($id){
        $slide = Gallery::find($id);
        if($slide->delete())
            return redirect()->to('admin/slides/management')->withFlashSuccess('Successfully deleted Slides.');
    }


    public function editSlides($id){
        $slide = Gallery::find($id);
        return view('backend.slides.edit', compact('slide'));
    }
    

    
    public function updateSlides($id, Request $request){
      $slide = Gallery::where('id', $id)->first();
      $input = $request->except('image');
     $teste = $request['image'];
      $unlink = $slide->path;
      if($request->hasFile('image'))
            {
               $check = File::delete($unlink);
               $dir = 'Slider';
               $path = config('access.uploadDir').'/'.$dir;
               $extension = Input::file('image')->getClientOriginalExtension();
          //$file_size = Input::file('licensePic')->getSize();
              $file = Input::file('image');
              /////before upload filename
               $filename = $this->filename($extension);
               $fullpath = $path.'/'.$filename;
               Input::file('image')->move($path, $filename);
               $categories = DB::table('gallerys')->where('id', $id)->update(['path'=>$fullpath]);
              // items::where('id',$id)->update(['img'=>$fullpath]);

            }




      if ($slide->update()){
        $captionupdate = DB::table('gallerys')->where('id', $id)->update(['caption'=>$request['caption']]); 
        return redirect()->route('admin.slides.all')->withFlashSuccess('Slides was Successfully updated.');
      }
    }

    public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }



}
