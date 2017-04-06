<?php namespace App\Http\Controllers\Backend;
use App\Repositories\Frontend\User\UserContract;
use App\Repositories\Frontend\Sliderupload;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\GuideArea;
use App\Models\Language;
use Illuminate\Http\Request;
use Datatable;
use Input;
use DB;
use App\Repositories\Frontend\Licenseupload;
use App\Http\Requests\Backend\Access\User\DeleteSlidesRequest;

class MiscellaneousController extends Controller {

    /**
     * @param UserContract $user
     */
    public function __construct(UserContract $user) {
        $this->user = $user;
    }

    public function getArea(){
        return view('backend.miscellaneous.addGuideArea');
    }

   


    public function postAddPlace(Request $request){
    	$this->validate($request, [
    'guide_area' => 'required|unique:guideareas|max:255',
]);
            $userid = Auth::user();
            $addGuideArea = GuideArea::create([
                'user_id' => $userid->id,
                'user_name' => $userid->fname,
                'guide_area' => trim(Input::get('guide_area')),
                'ordering' => Input::get('ordering'),
              ]);
            return redirect()->to('admin/miscellaneous/guidAreaemanagement')->withFlashSuccess('Successfully Added New Guide Area.');
        }

    public function getAllGuidearea(){
        $table = $this->setDatatableMisc();
         //role of users
         return view('backend.miscellaneous.manageGuideArea', compact('table'));
    }




     // language add
    public function getLanguage(){
        return view('backend.miscellaneous.addLanguage');
    }

    public function postLanguage(Request $request){
        $this->validate($request, [
    'language' => 'required|unique:languages|max:255',
]);
            $userid = Auth::user();
            $addGuideArea = Language::create([
                'user_id' => $userid->id,
                'user_name' => $userid->fname,
                'language' => trim(Input::get('language')),
                'ordering' => Input::get('ordering'),
              ]);
             return redirect()->route('admin.miscellaneous.getAllLanguage')->withFlashSuccess('Successfully Added Language.');
        }


         public function getAllLanguage(){

        $table = $this->setDatatableMiscLang();
         //role of users
         return view('backend.miscellaneous.manageLanguage', compact('table'));
    }

  

    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableMisc()
    {
        $route = route('api.table.misc');
        
            //,trans('crud.slides.status')
        //, trans('crud.slides.image')
            return Datatable::table()
            ->addColumn(trans('crud.pages.gname'), trans('Guide Area'), trans('Order'), trans('crud.pages.created'))
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->setOrder(['2'=>'asc'])
            ->render();

       
    }

    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableMiscLang()
    {
        $route = route('api.table.misclang');
        
            //,trans('crud.slides.status')
        //, trans('crud.slides.image')
            return Datatable::table()
            ->addColumn(trans('crud.pages.gname'), trans('Language'), trans('Order') ,trans('crud.pages.created'))
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->setOrder(['2'=>'asc'])
            ->render();

       
    }

    public function getAllSlidesImages(){
        
            $admin = $this->user->findOrThrowException(auth()->id());
            $slider = $admin->gallerys()->where('type','slides')->orderBy('created_at', 'desc');
            dd($slider);
    return view('frontend.includes.banner')->withUserid(auth()->id())->withGallerys($slider)->withClass('gallery');
    }

    public function deleteGuideArea($id){
        $place = GuideArea::find($id);
        if($place->delete())
            return redirect()->to('/admin/miscellaneous/guidAreaemanagement')->withFlashSuccess('Successfully deleted Guide Area.');
    }
    public function deletelanguage($id){
        $language = Language::find($id);
        if($language->delete())
            return redirect()->to('/admin/miscellaneous/languagemanagement')->withFlashSuccess('Language was Successfully deleted ');
    }


    public function editGuideArea($id){
        $guidearea = GuideArea::find($id);
        return view('backend.miscellaneous.editguidearea', compact('guidearea'));
    }


    public function updateGuidearea($id, Request $request){
        $guidearea= GuideArea::findorFail($id);
        $guidearea->update(['guide_area'=>trim($request['guide_area']), 'ordering'=>$request['ordering']]); 

        // $guidearea = DB::table('guideareas')->where('id', $id)->update(['guide_area'=>$request['guide_area'], 'ordering'=>$request['ordering']]); 
        return redirect()->route('admin.miscellaneous.getAllarea')->withFlashSuccess('GuideArea was Successfully updated.');
    }



    public function editLanguage($id){
        $language = Language::find($id);
        return view('backend.miscellaneous.editLanguage', compact('language'));
    }


    public function updateLanguage($id, Request $request){
        $guidearea = DB::table('languages')->where('id', $id)->update(['language'=>trim($request['language']), 'ordering'=>$request['ordering']]); 
        return redirect()->route('admin.miscellaneous.getAllLanguage')->withFlashSuccess('Language was Successfully updated.');
    }


}
