<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatable;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Frontend\Licenseupload;

class LicenseController extends Controller
{
	 

	/**
     * @var UserContract
     */
	protected $users;

    public function __construct(UserContract $users) {
        $this->users = $users;
        
    }

	public function getAllLicense() {
		$table = $this->setLicenseDatatable();
		 return view('backend.licenseList', compact('table'));
	}

	public function getLicense($id) {
		$user = $this->users->findOrThrowException($id, true);
		return view('backend.license', compact('user'));
	}

    public function deleteLicense(LicenseUpload $license,Request $request){
        $this->validate($request, [
            'id' => 'integer'
        ]);
        $data['stat']='error';
        if($license->delete($request['id'])){
            $data['stat']='ok';
        }
        return response()->json($data);
    }

	/**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setLicenseDatatable()
    {
        
        $route = route('api.table.license');

            return Datatable::table()
            ->addColumn('ID')
            ->addColumn('Name')
            ->addColumn('Email')
            ->addColumn('License')
            ->addColumn('Signup Date')
            ->addColumn('Action')
            ->setUrl($route)
            ->setOrder(array(4=>'desc', 1=>'asc'))
             ->setOptions([
                            // 'order'=> [[ '4' ,"desc"],['1','asc']],
                            'oLanguage' => trans('crud.datatables'),
                            'aoColumns' => [
                                ['bSortable' => true],
                                ['bSortable' => true],
                                ['bSortable' => true],
                                ['bSortable' => false,'sClass' =>'sm-license-img'],
                                ['bSortable' => true],
                                ['bSortable' => false]
                            ]
                        ])
            // ->setOptions(['oLanguage' => trans('crud.datatables')])
            // ->setOrder(['4'=>'desc', '1'=>'asc'])
            ->render();

       
    }




}