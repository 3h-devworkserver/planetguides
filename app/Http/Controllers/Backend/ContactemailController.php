<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatable;
use App\Models\Contact;
use App\Http\Requests\Backend\Contact\SendContactReplyEmailRequest;
use Mail;

class ContactemailController extends Controller
{

public function index(){
	 $route = route('api.table.contactemail');

            $table =  Datatable::table()
			            ->addColumn(trans('ID'), trans('Name'), trans('Email'), trans('Message'), trans('Created'))
			            ->addColumn(trans('crud.actions'))
			            ->setUrl($route)
			            // ->setOptions(['oLanguage' => trans('crud.datatables')])
			            ->setOrder([4=>'desc'])
			            // ->setOrder([3=>'desc', 1=>'asc'])
			            ->render();

	return view('backend.contactemail.index', compact('table'));
}

public function showReplyContactEmail($id, SendContactReplyEmailRequest $request){
	$template = file_get_contents(base_path() . '/resources/views/backend/contactemail/mailtemplate.blade.php');
	$contact = Contact::findOrFail($id);
	// return $contact;
	return view('backend.contactemail.reply', compact('contact', 'template'));
}

public function sendReplyContactEmail($id, SendContactReplyEmailRequest $request){
	 $this->validate($request, [
        'subject' => 'required',
        'to' => 'required',
    ]);
	 $contact = Contact::findOrFail($id)->toArray();
	 $user= array();
	 $user['to'] = $request->to;
	 $user['subject']= $request->subject;
	 $user['email']= $request->email;
	 file_put_contents(base_path() . '/resources/views/backend/contactemail/temp.blade.php', $request->email );


try{
	Mail::send('backend.contactemail.temp', ['contact' => $contact], function ($m) use ($user, $contact) {
            $m->from('info@guidenp.com', 'GuideNP');
            $m->to($user['to'], $contact['name'])->subject($user['subject']);
        });
}catch(\Exception $e){
	return redirect()->back()->withFlashDanger('Error while sending Email')->withInput($request->all());
}
// return $mail;
	return redirect('admin/contactemail')->withFlashSuccess('Email has been send successfully');
}



}