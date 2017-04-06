<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Pages\PageContract;
use Kris\LaravelFormBuilder\FormBuilder;
use Laracasts\Flash\Flash;
use Datatable;
use App\Http\Requests\Backend\Page\CreatePageRequest;
use App\Http\Requests\Backend\Page\DeletePageRequest;
use App\Http\Requests\Backend\Page\StatusPageRequest;
use App\Http\Requests\Backend\Page\UpdatePageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @var PageContract
     */
    protected $pages;

    public function __construct(PageContract $pages) {
        $this->pages = $pages;
        
    }

    public function index()
    {
        

        $table = $this->setDatatable('1');
        return view('backend.pages.index', compact('table'));
    }

    /**
     * Show the form for creating a new page.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\PagesForm', [
            'method' => 'POST',
            'url' => route('admin.pages.store')
        ]);
        return view('backend.pages.create', compact('form'));
    }

     /**
     * Store a newly created page in storage
     *
     * @param PageRequest $request
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        $this->pages->create($request->all()); 
        return redirect()->route('admin.pages.index')->withFlashSuccess(trans("alerts.pages.created"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivated()
    {
       
        $table = $this->setDatatable('0');
        return view('backend.pages.deactivated', compact('table'));
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param Page $page
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $pages = $this->pages->findOrThrowException($id);
        $form = $formBuilder->create('App\Forms\PagesEditForm', [
            'method' => 'PATCH',
            'url' => route('admin.pages.update', ['id' => $pages->id]),
            'model' => $pages
        ]);
        return view('backend.pages.edit', compact('form','pages'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function update($id, UpdatePageRequest $request) {
  
        $this->pages->update($id,$request->all());
        
        return redirect('/admin/pages')->withFlashSuccess(trans("alerts.pages.updated"));
        // return redirect()->route('admin.pages.index')->withFlashSuccess(trans("alerts.pages.updated"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeletePageRequest $request)
    {
        $this->pages->delete($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.pages.deleted"));
    }

    public function status($id, $status, StatusPageRequest $request)
    {
        $this->pages->status($id, $status);
        return redirect()->back()->withFlashSuccess(trans("alerts.pages.updated"));
    }

     /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatable($status)
    {
        

        if($status)
            $route = route('api.table.page');

        else
            $route = route('api.table.page.deactivated');

            return Datatable::table()
            ->addColumn(trans('crud.pages.id'), trans('crud.pages.title'), trans('crud.pages.created'), trans('crud.pages.last_updated'))
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->setOptions([
                // 'stateSave'=>true,
                'oLanguage' => trans('crud.datatables')])
            ->render();

       
    }
}